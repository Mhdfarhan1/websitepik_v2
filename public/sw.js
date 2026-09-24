/**
 * Service Worker - PIK-R REQUEST Web Push Notifications
 * Website: PIK-R REQUEST SMAN 1 Tasik Putri Puyu
 * @version 5.0 - Samsung Internet compatible, no action buttons
 */

const SW_VERSION = '5.0';
const DEFAULT_ICON = '/assets/img/Logo_pikr.png';
const DEFAULT_BADGE = '/assets/img/Logo_pikr.png';

// 1. Install Event - take over immediately
self.addEventListener('install', function(event) {
    self.skipWaiting();
});

// 2. Activate Event - claim all clients immediately
self.addEventListener('activate', function(event) {
    event.waitUntil(self.clients.claim());
});

// 3. Push Event - receive push from server
self.addEventListener('push', function(event) {
    if (!event.data) return;

    var payload;
    try {
        payload = event.data.json();
    } catch (e) {
        payload = {
            title: 'PIK-R REQUEST 🔔',
            body: event.data.text(),
            url: '/',
            type: 'informasi'
        };
    }

    var title = payload.title || 'PIK-R REQUEST 🔔';
    var body  = payload.body  || 'Ada pembaruan konten terbaru di website PIK-R REQUEST.';
    var icon  = payload.icon  || DEFAULT_ICON;
    var badge = payload.badge || DEFAULT_BADGE;
    var url   = payload.url   || '/';

    // IMPORTANT: No 'actions' array - Samsung Internet doesn't support it properly
    // Tapping the notification body is the only reliable action
    var options = {
        body: body,
        icon: icon,
        badge: badge,
        vibrate: [200, 100, 200],
        tag: 'pikr-' + (payload.id || Date.now()),
        renotify: true,
        requireInteraction: false,
        silent: false,
        data: {
            url: url,
            id: payload.id || null,
            type: payload.type || 'informasi'
        }
        // No 'actions' - removed for Samsung Internet compatibility
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

// 4. Notification Click - open target URL when tapping notification
self.addEventListener('notificationclick', function(event) {
    // Close the notification immediately
    event.notification.close();

    // Get the target URL
    var targetUrl = '/';
    try {
        if (event.notification.data && event.notification.data.url) {
            targetUrl = event.notification.data.url;
        }
    } catch(e) {}

    // Build absolute URL
    var fullUrl = targetUrl;
    try {
        if (!/^https?:\/\//i.test(targetUrl)) {
            var base = self.registration.scope.replace(/\/$/, '');
            fullUrl = base + (targetUrl.charAt(0) === '/' ? targetUrl : '/' + targetUrl);
        }
    } catch(e) {
        fullUrl = self.registration.scope;
    }

    // Open the URL - Samsung Internet compatible approach
    event.waitUntil(
        self.clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then(function(clientList) {
            // Find an existing window/tab of this browser
            var existingClient = null;
            for (var i = 0; i < clientList.length; i++) {
                if (clientList[i].visibilityState === 'visible') {
                    existingClient = clientList[i];
                    break;
                }
            }
            if (!existingClient && clientList.length > 0) {
                existingClient = clientList[0];
            }

            if (existingClient) {
                // Browser already open: navigate to URL and bring to foreground
                return existingClient.navigate(fullUrl).then(function(client) {
                    if (client && client.focus) return client.focus();
                }).catch(function() {
                    // navigate() failed (e.g. cross-origin), open new window
                    return self.clients.openWindow(fullUrl);
                });
            }

            // Browser closed: open new window (Android will launch the browser)
            return self.clients.openWindow(fullUrl);
        }).catch(function() {
            // Last resort fallback
            return self.clients.openWindow(fullUrl);
        })
    );
});
