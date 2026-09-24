/**
 * Service Worker - PIK-R REQUEST Web Push Notifications
 * Website: PIK-R REQUEST SMAN 1 Tasik Putri Puyu
 */

const DEFAULT_ICON = '/assets/img/Logo_pikr.png';
const DEFAULT_BADGE = '/assets/img/Logo_pikr.png';

// 1. Install Event
self.addEventListener('install', (event) => {
    self.skipWaiting();
});

// 2. Activate Event
self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

// 3. Push Event - When server sends Web Push
self.addEventListener('push', (event) => {
    if (!event.data) {
        return;
    }

    let payload;
    try {
        payload = event.data.json();
    } catch (e) {
        payload = {
            title: 'PIK-R REQUEST 🔔',
            body: event.data.text(),
            url: '/',
            icon: DEFAULT_ICON,
            badge: DEFAULT_BADGE,
            type: 'informasi'
        };
    }

    const title = payload.title || 'PIK-R REQUEST 🔔';
    
    // Notification options - tailored for mobile Android & desktop (WhatsApp style)
    const options = {
        body: payload.body || 'Ada pembaruan konten terbaru di website PIK-R REQUEST.',
        icon: payload.icon || DEFAULT_ICON,
        badge: payload.badge || DEFAULT_BADGE,
        vibrate: [250, 100, 250, 100, 250], // Pola getar HP seperti pesan masuk
        tag: 'pikr-notif-' + (payload.id || Date.now()),
        renotify: true,
        requireInteraction: false,
        silent: false,
        data: {
            url: payload.url || '/',
            id: payload.id || null,
            type: payload.type || 'informasi',
            timestamp: payload.timestamp || Date.now()
        },
        actions: [
            {
                action: 'open_url',
                title: 'Lihat Detail ↗'
            },
            {
                action: 'dismiss',
                title: 'Tutup'
            }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

// 4. Notification Click Event - When user clicks the push notification or its actions
self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    // If user clicked 'Tutup' action, just close
    if (event.action === 'dismiss') {
        return;
    }

    const targetUrl = (event.notification.data && event.notification.data.url) 
        ? event.notification.data.url 
        : '/';

    // Build absolute URL - handle both relative and absolute URLs
    let fullUrl;
    try {
        // If already absolute URL (starts with http/https), use as-is
        if (/^https?:\/\//i.test(targetUrl)) {
            fullUrl = targetUrl;
        } else {
            fullUrl = new URL(targetUrl, self.location.origin).href;
        }
    } catch (e) {
        fullUrl = self.location.origin + '/';
    }

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((windowClients) => {
            // Try to find an already-open tab with the exact target URL and focus it
            for (let i = 0; i < windowClients.length; i++) {
                const client = windowClients[i];
                if (client.url === fullUrl && 'focus' in client) {
                    return client.focus();
                }
            }
            // Always open a new window/tab to the target URL for reliable deep linking
            return clients.openWindow(fullUrl);
        })
    );
});
