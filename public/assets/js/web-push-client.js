/**
 * PIK-R REQUEST - Web Push Client Manager
 * @version 6.0 - Universal Cross-Browser Support
 * Supports: Chrome, Samsung Internet, Firefox, Edge, Opera (Android + Desktop)
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

    /**
     * Detect browsers that partially or fully don't support Web Push.
     * Returns: 'unsupported_browser' | 'ios_safari' | 'ok'
     */
    function checkBrowserCompatibility() {
        var ua = navigator.userAgent || '';

        // UC Browser - no reliable SW/Push support
        if (/UCBrowser|UCWeb|UCWEB/i.test(ua)) {
            return 'unsupported_browser';
        }

        // Old Android WebView (not Chrome) - no push support
        if (/wv\).*Version\/\d/i.test(ua) && !/Chrome/i.test(ua)) {
            return 'unsupported_browser';
        }

        // In-app browser (Facebook, Instagram, TikTok, etc.)
        if (/FBAN|FBAV|Instagram|musical_ly|TikTok/i.test(ua)) {
            return 'unsupported_browser';
        }

        // Opera Mini - no SW support
        if (/Opera Mini/i.test(ua)) {
            return 'unsupported_browser';
        }

        // iOS Safari (Push only works in PWA mode iOS 16.4+)
        if (/iPad|iPhone|iPod/i.test(ua) && !/CriOS|FxiOS|EdgiOS/i.test(ua)) {
            return 'ios_safari';
        }

        return 'ok';
    }

    window._pikrBrowserCompat = checkBrowserCompatibility();

    const PikrWebPush = {
        swRegistration: null,
        isSupported: false,
        isSubscribed: false,
        vapidPublicKey: null,

        async init() {
            // Auto redirect to HTTPS if on live domain (e.g. cPanel)
            if (window.location.protocol === 'http:' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
                try {
                    window.location.href = window.location.href.replace('http:', 'https:');
                    return;
                } catch (e) {}
            }

            if (!('serviceWorker' in navigator) || !('PushManager' in window) || typeof window.Notification === 'undefined') {
                this.isSupported = false;
                this.updateUI();
                return;
            }

            this.isSupported = true;

            try {
                // Register Service Worker v6.0 and force immediate update check
                const reg = await navigator.serviceWorker.register('/sw.js?v=6.0', { scope: '/' });

                // Force browser to check for updated SW (works on Chrome, Samsung, Firefox)
                try { await reg.update(); } catch(e) {}

                this.swRegistration = await navigator.serviceWorker.ready;

                // Check existing subscription
                const subscription = await this.swRegistration.pushManager.getSubscription();
                this.isSubscribed = !(subscription === null);


                // Fetch VAPID public key
                await this.fetchVapidKey();

                // If user granted permission previously and subscription exists, sync with server
                if (this.isSubscribed && subscription) {
                    await this.sendSubscriptionToServer(subscription);
                } else if (typeof Notification !== 'undefined' && Notification.permission === 'granted') {
                    // Permission already granted but subscription missing in browser: auto-subscribe in background!
                    console.log('[WebPush] Permission granted, auto-subscribing in background...');
                    await this.subscribe(true);
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
            try {
                const json = subscription.toJSON ? subscription.toJSON() : {};
                const rawKey = subscription.getKey ? subscription.getKey('p256dh') : null;
                const rawAuth = subscription.getKey ? subscription.getKey('auth') : null;

                const p256dh = (json.keys && json.keys.p256dh)
                    ? json.keys.p256dh
                    : (rawKey ? btoa(String.fromCharCode.apply(null, new Uint8Array(rawKey))) : '');

                const auth = (json.keys && json.keys.auth)
                    ? json.keys.auth
                    : (rawAuth ? btoa(String.fromCharCode.apply(null, new Uint8Array(rawAuth))) : '');

                const subData = {
                    endpoint: subscription.endpoint,
                    keys: {
                        p256dh: p256dh,
                        auth: auth
                    },
                    contentEncoding: (PushManager.supportedContentEncodings || ['aesgcm'])[0]
                };

                const res = await fetch('/api/push-subscriptions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(subData)
                });

                const data = await res.json();
                if (data.status === 'success') {
                    console.log('[WebPush] Subscription saved successfully:', data);
                    localStorage.setItem('pikr_push_subscribed', 'true');
                    this.isSubscribed = true;
                    this.updateUI();
                } else {
                    console.warn('[WebPush] Server returned notice:', data);
                }
            } catch (err) {
                console.error('[WebPush] Failed sending subscription to server:', err);
            }
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
            state: 'prompt', // 'prompt' | 'loading' | 'success' | 'denied' | 'unsupported' | 'need_https'
            copied: false,
            initPrompt() {
                const urlParams = new URLSearchParams(window.location.search);
                const forceShow = urlParams.has('notif') || urlParams.has('prompt') || urlParams.has('reset_push');

                if (forceShow) {
                    try {
                        sessionStorage.removeItem('pikr_push_prompt_dismissed');
                        localStorage.removeItem('pikr_push_prompt_dismissed');
                    } catch (e) {}
                } else {
                    try {
                        if (sessionStorage.getItem('pikr_push_prompt_dismissed')) {
                            return;
                        }
                    } catch (e) {}
                }

                // Safe check notification permission
                let permission = 'default';
                try {
                    if (typeof window.Notification !== 'undefined') {
                        permission = window.Notification.permission;
                    }
                } catch (e) {}

                // If already granted in browser or already subscribed, NEVER show popup on reload/relog!
                if ((permission === 'granted' || localStorage.getItem('pikr_push_subscribed') === 'true') && !forceShow) {
                    return;
                }

                // If explicitly denied, don't nag user unless forced with ?notif=1
                if (permission === 'denied' && !forceShow) {
                    return;
                }

                // Display prompt after a brief 700ms entrance delay only for undecided users
                setTimeout(() => {
                    this.show = true;
                }, 700);
            },
            dismissPrompt() {
                this.show = false;
                try {
                    sessionStorage.setItem('pikr_push_prompt_dismissed', 'true');
                } catch (e) {}
            },
            redirectToHttps() {
                window.location.href = window.location.href.replace('http:', 'https:');
            },
            copyUrl() {
                try {
                    navigator.clipboard.writeText(window.location.href);
                    this.copied = true;
                    setTimeout(() => { this.copied = false; }, 2500);
                } catch (e) {
                    alert('Link website: ' + window.location.href);
                }
            },
            openInChrome() {
                const currentUrl = window.location.href.replace(/^https?:\/\//, '');
                const scheme = window.location.protocol.replace(':', '');
                window.location.href = 'intent://' + currentUrl + '#Intent;scheme=' + scheme + ';package=com.android.chrome;end';
            },
            async enablePush() {
                // Check if on insecure HTTP on live host
                if (window.location.protocol === 'http:' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
                    this.state = 'need_https';
                    return;
                }

                // Check push support
                const hasSW = 'serviceWorker' in navigator;
                const hasPush = 'PushManager' in window;
                const hasNotif = typeof window.Notification !== 'undefined';

                if (!hasSW || !hasPush || !hasNotif) {
                    this.state = 'unsupported';
                    return;
                }

                this.state = 'loading';
                try {
                    if (window.PikrWebPush) {
                        const success = await window.PikrWebPush.subscribe(true);
                        if (success) {
                            this.state = 'success';
                            try { sessionStorage.removeItem('pikr_push_prompt_dismissed'); } catch (e) {}
                            setTimeout(() => { this.show = false; }, 2600);
                        } else {
                            const perm = typeof window.Notification !== 'undefined' ? window.Notification.permission : '';
                            if (perm === 'denied') {
                                this.state = 'denied';
                            } else if (!window.PikrWebPush.isSupported) {
                                this.state = 'unsupported';
                            } else {
                                this.state = 'prompt';
                            }
                        }
                    } else {
                        const permission = await Notification.requestPermission();
                        if (permission === 'granted') {
                            this.state = 'success';
                            setTimeout(() => { this.show = false; }, 2200);
                        } else if (permission === 'denied') {
                            this.state = 'denied';
                        } else {
                            this.state = 'prompt';
                        }
                    }
                } catch (e) {
                    console.error('Error enabling push:', e);
                    this.state = 'prompt';
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
