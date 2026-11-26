/* Ajax website — notifications of the chat (26 November 2026).
 * "Notify me of the answer": when Maya or the Ajax team replies while the visitor is not on the website,
 * the CRM sends the reply here; it shows as a notification, and a tap opens the website with the chat open. */
self.addEventListener('install', function () { self.skipWaiting(); });
self.addEventListener('activate', function (e) { e.waitUntil(self.clients.claim()); });

self.addEventListener('push', function (event) {
    var d = {};
    try { d = event.data ? event.data.json() : {}; } catch (e) { d = { body: event.data ? event.data.text() : '' }; }
    event.waitUntil(self.registration.showNotification(d.title || 'Ajax Trading Corp.', {
        body: d.body || 'You have a new reply in the chat.',
        icon: '/images/notify-icon.png',
        badge: '/images/notify-icon.png',
        tag: d.tag || 'ajax-chat',
        renotify: true,
        data: { url: d.url || '/?chat=open' }
    }));
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    var url = (event.notification.data && event.notification.data.url) || '/?chat=open';
    event.waitUntil(self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (list) {
        for (var i = 0; i < list.length; i++) {
            if (list[i].url.indexOf(self.location.origin) === 0 && 'focus' in list[i]) {
                list[i].navigate(url);
                return list[i].focus();
            }
        }
        return self.clients.openWindow(url);
    }));
});
