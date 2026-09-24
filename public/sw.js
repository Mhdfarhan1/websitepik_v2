/**
 * Service Worker - PIK-R REQUEST Web Push Notifications
 * Website: PIK-R REQUEST SMAN 1 Tasik Putri Puyu
 * @version 4.3 - Focus Chrome window after openWindow
 */

const SW_VERSION = '4.3';
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
self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    // If user clicked 'Tutup' action, just close
    if (event.action === 'dismiss') {
        return;
    }

    // Get target URL from notification data
    var targetUrl = '/';
    try {
        if (event.notification.data && event.notification.data.url) {
            targetUrl = event.notification.data.url;
        }
    } catch (e) {}

    // Build absolute URL - works when browser is fully closed on Android
    var fullUrl;
    try {
        if (/^https?:\/\//i.test(targetUrl)) {
            fullUrl = targetUrl;
        } else {
            // Use self.registration.scope as base for reliable origin detection
            var origin = self.registration.scope.replace(/\/$/, '');
            fullUrl = origin + (targetUrl.charAt(0) === '/' ? targetUrl : '/' + targetUrl);
        }
    } catch (e) {
        fullUrl = self.registration.scope;
    }

    // Directly open the URL + focus Chrome window to bring it to foreground
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(windowClients) {
            // If Chrome already has a window open, navigate it and bring to foreground
            if (windowClients.length > 0) {
                var client = windowClients[0];
                try {
                    client.navigate(fullUrl);
                } catch(e) {}
                if ('focus' in client) {
                    return client.focus();
                }
            }
            // No window open: open new tab and focus it (brings Chrome to foreground)
            return clients.openWindow(fullUrl).then(function(newClient) {
                if (newClient && 'focus' in newClient) {
                    return newClient.focus();
                }
            });
        }).catch(function() {
            // Fallback: just open window
            return clients.openWindow(fullUrl);
        })
    );
});

