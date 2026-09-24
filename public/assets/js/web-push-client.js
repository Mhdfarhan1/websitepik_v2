/**
 * PIK-R REQUEST - Web Push Client Manager
 * Handles Service Worker registration, VAPID subscription, and status.
 */

(function () {
    'use strict';

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    const PikrWebPush = {
        swRegistration: null,
        isSupported: false,
        isSubscribed: false,
        vapidPublicKey: null,

        async init() {
            if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                this.isSupported = false;
                this.updateUI();
                return;
            }

            this.isSupported = true;

            try {
                // Register Service Worker
                this.swRegistration = await navigator.serviceWorker.register('/sw.js', { scope: '/' });

                // Check existing subscription
                const subscription = await this.swRegistration.pushManager.getSubscription();
                this.isSubscribed = !(subscription === null);

                // Fetch VAPID public key
                await this.fetchVapidKey();

                // If user granted permission previously and subscription exists, sync with server
                if (this.isSubscribed && subscription) {
                    this.sendSubscriptionToServer(subscription);
                }

                this.updateUI();
            } catch (error) {
                console.warn('[WebPush] Error initializing Service Worker:', error);
                this.updateUI();
            }
        },

        async fetchVapidKey() {
            try {
                const response = await fetch('/api/push-subscriptions/vapid-public-key');
                const data = await response.json();
                if (data.status === 'success') {
                    this.vapidPublicKey = data.public_key;
                }
            } catch (e) {
                console.warn('[WebPush] Could not fetch VAPID key:', e);
            }
        },

        async subscribe(suppressSwal = false) {
            if (!this.isSupported) {
                if (!suppressSwal) {
                    if (window.Swal) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak Didukung',
                            text: 'Browser Anda tidak mendukung Web Push Notification.',
                        });
                    } else {
                        alert('Browser Anda tidak mendukung Web Push Notification.');
                    }
                }
                return false;
            }

            if (!this.vapidPublicKey) {
                await this.fetchVapidKey();
            }

            if (!this.vapidPublicKey) {
                if (!suppressSwal) alert('Konfigurasi VAPID server belum siap. Hubungi administrator.');
                return false;
            }

            // Check permission
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                this.updateUI();
                if (!suppressSwal) {
                    if (window.Swal) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Izin Ditolak',
                            text: 'Izin notifikasi ditolak. Anda dapat mengaktifkannya kembali melalui pengaturan situs browser Anda.',
                        });
                    } else {
                        alert('Izin notifikasi ditolak.');
                    }
                }
                return false;
            }

            try {
                const applicationServerKey = urlBase64ToUint8Array(this.vapidPublicKey);
                const subscription = await this.swRegistration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: applicationServerKey
                });

                await this.sendSubscriptionToServer(subscription);
                this.isSubscribed = true;
                this.updateUI();

                // Trigger instant notification banner on the device (mobile status bar / desktop banner)
                try {
                    if (this.swRegistration && this.swRegistration.showNotification) {
                        await this.swRegistration.showNotification('PIK-R REQUEST 🔔', {
                            body: 'Notifikasi Berhasil Diaktifkan! Kamu akan menerima info Prestasi, Kegiatan, & Berita terbaru langsung di HP.',
                            icon: '/assets/img/Logo_pikr.png',
                            badge: '/assets/img/Logo_pikr.png',
                            vibrate: [250, 100, 250, 100, 250],
                            tag: 'pikr-welcome-notification',
                            renotify: true,
                            data: { url: '/' },
                            actions: [
                                { action: 'open_url', title: 'Buka Website ↗' }
                            ]
                        });
                    }
                } catch (notifErr) {
                    console.log('Notice on local welcome notification:', notifErr);
                }

                if (!suppressSwal && window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Notifikasi Aktif! 🔔',
                        text: 'Terima kasih! Anda akan menerima pemberitahuan setiap ada prestasi, kegiatan, atau kabar terbaru dari PIK-R REQUEST.',
                        timer: 3500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl shadow-xl' }
                    });
                }

                return true;
            } catch (error) {
                console.error('[WebPush] Gagal berlangganan push:', error);
                this.updateUI();
                return false;
            }
        },

        async unsubscribe() {
            if (!this.swRegistration) return;
            try {
                const subscription = await this.swRegistration.pushManager.getSubscription();
                if (subscription) {
                    // Notify server
                    await fetch('/api/push-subscriptions/unsubscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ endpoint: subscription.endpoint })
                    });
                    await subscription.unsubscribe();
                }

                this.isSubscribed = false;
                this.updateUI();

                if (window.Swal) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Notifikasi Dinonaktifkan',
                        text: 'Anda tidak akan menerima notifikasi push dari website ini.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            } catch (error) {
                console.error('[WebPush] Error unsubscribing:', error);
            }
        },

        async sendSubscriptionToServer(subscription) {
            const rawKey = subscription.getKey ? subscription.getKey('p256dh') : null;
            const rawAuth = subscription.getKey ? subscription.getKey('auth') : null;

            const subData = {
                endpoint: subscription.endpoint,
                keys: {
                    p256dh: rawKey ? btoa(String.fromCharCode.apply(null, new Uint8Array(rawKey))) : '',
                    auth: rawAuth ? btoa(String.fromCharCode.apply(null, new Uint8Array(rawAuth))) : ''
                },
                contentEncoding: (PushManager.supportedContentEncodings || ['aesgcm'])[0]
            };

            await fetch('/api/push-subscriptions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(subData)
            });
        },

        updateUI() {
            const buttons = document.querySelectorAll('.btn-pikr-push-toggle');
            buttons.forEach(btn => {
                if (!this.isSupported) {
                    btn.style.display = 'none';
                    return;
                }

                const label = btn.querySelector('.push-toggle-label');
                const icon = btn.querySelector('.push-toggle-icon');

                if (Notification.permission === 'denied') {
                    if (label) label.textContent = 'Notifikasi Diblokir Browser';
                    if (icon) icon.className = 'fas fa-bell-slash text-rose-500';
                    btn.classList.add('opacity-60', 'cursor-not-allowed');
                } else if (this.isSubscribed) {
                    if (label) label.textContent = 'Notifikasi Aktif ✓';
                    if (icon) icon.className = 'fas fa-bell text-emerald-500';
                    btn.classList.remove('opacity-60', 'cursor-not-allowed');
                } else {
                    if (label) label.textContent = 'Aktifkan Notifikasi';
                    if (icon) icon.className = 'fas fa-bell text-amber-500';
                    btn.classList.remove('opacity-60', 'cursor-not-allowed');
                }
            });
        }
    };

    window.PikrWebPush = PikrWebPush;

    // Auto-init on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => PikrWebPush.init());
    } else {
        PikrWebPush.init();
    }

    // Alpine.js Component Handlers (Clean, Zero Inline Script in Templates)
    window.pikrNavbarBell = function() {
        return {
            open: false,
            unreadCount: 0,
            notifications: [],
            loading: false,
            init() {
                this.fetchCount();
                setInterval(() => { this.fetchCount(); }, 60000);
            },
            fetchCount() {
                fetch('/api/notifications/unread-count')
                    .then(r => r.json())
                    .then(d => { this.unreadCount = d.count || 0; })
                    .catch(() => {});
            },
            fetchRecent() {
                this.loading = true;
                fetch('/api/notifications/recent')
                    .then(r => r.json())
                    .then(d => {
                        this.notifications = d.data || [];
                        this.loading = false;
                    })
                    .catch(() => { this.loading = false; });
            },
            markAllRead() {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                fetch('/api/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    }
                }).then(() => {
                    this.unreadCount = 0;
                    this.notifications.forEach(n => { n.is_read = true; });
                });
            }
        };
    };

    window.pikrPushPromptBottom = function() {
        return {
            show: false,
            state: 'prompt', // 'prompt' | 'loading' | 'success' | 'denied'
            initPrompt() {
                if (!('serviceWorker' in navigator) || !('PushManager' in window) || !('Notification' in window)) {
                    return;
                }
                if (Notification.permission === 'granted' || Notification.permission === 'denied') {
                    return;
                }
                const dismissedAt = localStorage.getItem('pikr_push_prompt_dismissed');
                if (dismissedAt) {
                    const hoursPassed = (Date.now() - parseInt(dismissedAt, 10)) / (1000 * 60 * 60);
                    if (hoursPassed < 48) {
                        return;
                    }
                }
                setTimeout(() => {
                    if (Notification.permission === 'default') {
                        this.show = true;
                    }
                }, 2000);
            },
            dismissPrompt() {
                this.show = false;
                localStorage.setItem('pikr_push_prompt_dismissed', Date.now().toString());
            },
            async enablePush() {
                this.state = 'loading';
                try {
                    if (window.PikrWebPush) {
                        const success = await window.PikrWebPush.subscribe(true);
                        if (success) {
                            this.state = 'success';
                            localStorage.removeItem('pikr_push_prompt_dismissed');
                            setTimeout(() => { this.show = false; }, 2200);
                        } else {
                            if (Notification.permission === 'denied') {
                                this.state = 'denied';
                            } else {
                                this.state = 'prompt';
                            }
                        }
                    } else {
                        const permission = await Notification.requestPermission();
                        if (permission === 'granted') {
                            this.state = 'success';
                            setTimeout(() => { this.show = false; }, 2000);
                        } else {
                            this.state = 'denied';
                        }
                    }
                } catch (e) {
                    this.state = 'prompt';
                    this.show = false;
                }
            }
        };
    };

    document.addEventListener('alpine:init', () => {
        if (window.Alpine) {
            Alpine.data('pikrNavbarBell', window.pikrNavbarBell);
            Alpine.data('pikrPushPromptBottom', window.pikrPushPromptBottom);
        }
    });
})();
