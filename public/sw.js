/**
 * Service Worker - PIK-R REQUEST Web Push Notifications
 * @version 6.0 - Universal Cross-Browser Compatibility
 * Supports: Chrome, Samsung Internet, Firefox, Edge, Opera (Android & Desktop)
 */

var SW_VERSION = '6.0';
var DEFAULT_ICON  = '/assets/img/Logo_pikr.png';
var DEFAULT_BADGE = '/assets/img/Logo_pikr.png';

// ─── Install: skip waiting so new SW activates immediately ───────────────────
self.addEventListener('install', function(event) {
    self.skipWaiting();
});

// ─── Activate: claim all clients so new SW takes effect right away ───────────
self.addEventListener('activate', function(event) {
    event.waitUntil(self.clients.claim());
});

// ─── Push: receive push from server ─────────────────────────────────────────
self.addEventListener('push', function(event) {
    if (!event.data) return;

    var payload;
    try {
        payload = event.data.json();
    } catch (e) {
        payload = {
            title: 'PIK-R REQUEST',
            body:  event.data.text(),
            url:   '/'
        };
    }

    var title = payload.title || 'PIK-R REQUEST 🔔';
    var body  = payload.body  || 'Ada pembaruan konten terbaru.';
    var url   = payload.url   || '/';
    var icon  = payload.icon  || DEFAULT_ICON;
    var badge = payload.badge || DEFAULT_BADGE;
    var id    = payload.id    || Date.now();

    var options = {
        body:              body,
        icon:              icon,
        badge:             badge,
        vibrate:           [200, 100, 200],
        tag:               'pikr-' + id,
        renotify:          true,
        requireInteraction: false,
        silent:            false,
        // Store URL in data so notificationclick can read it
        data: {
            url:  url,
            id:   id,
            type: payload.type || 'informasi'
        }
        // NOTE: No 'actions' array — not supported in Samsung Internet & Firefox Android
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

// ─── Notification Click: open target URL reliably on ALL browsers ─────────────
self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    // ── Get the URL ──────────────────────────────────────────────────────────
    var targetUrl = '/';
    try {
        if (event.notification.data && event.notification.data.url) {
            targetUrl = event.notification.data.url;
        }
    } catch(e) {}

    // ── Normalize to absolute URL ─────────────────────────────────────────────
    var fullUrl = targetUrl;
    try {
        if (!/^https?:\/\//i.test(targetUrl)) {
            // Remove trailing slash from scope, add path
            var base = self.registration.scope.replace(/\/$/, '');
            var path = targetUrl.charAt(0) === '/' ? targetUrl : '/' + targetUrl;
            fullUrl = base + path;
        }
    } catch(e) {
        fullUrl = self.registration.scope || '/';
    }

    var openUrl = fullUrl; // capture in closure

    // ── Open Strategy: handles all browsers & all states ─────────────────────
    event.waitUntil(
        self.clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then(function(clientList) {

            var i, client;

            // 1. Found an existing window at EXACT target URL → just focus it
            for (i = 0; i < clientList.length; i++) {
                client = clientList[i];
                try {
                    if (client.url === openUrl && client.focus) {
                        return client.focus();
                    }
                } catch(e) {}
            }

            // 2. Found any visible window → navigate it to target URL
            for (i = 0; i < clientList.length; i++) {
                client = clientList[i];
                try {
                    if (client.visibilityState === 'visible') {
                        if (client.navigate) {
                            return client.navigate(openUrl).then(function(c) {
                                return c && c.focus ? c.focus() : null;
                            }).catch(function() {
                                return self.clients.openWindow(openUrl);
                            });
                        }
                    }
                } catch(e) {}
            }

            // 3. Found any window (even background) → navigate + focus it
            for (i = 0; i < clientList.length; i++) {
                client = clientList[i];
                try {
                    if (client.navigate) {
                        return client.navigate(openUrl).then(function(c) {
                            return c && c.focus ? c.focus() : null;
                        }).catch(function() {
                            return self.clients.openWindow(openUrl);
                        });
                    }
                    if (client.focus) {
                        return client.focus();
                    }
                } catch(e) {}
            }

            // 4. No window found → open new window (browser will launch to foreground)
            return self.clients.openWindow(openUrl);

        }).catch(function() {
            // Ultimate fallback
            return self.clients.openWindow(openUrl);
        })
    );
});
