// Ajax public site — small, dependency-free behaviours.
// (24 November 2026) The website counts itself: a step in the design page, a tap on Call / Messenger / Viber / WhatsApp.
// No cookies; the server keeps only a code of the day (see App\Support\SiteStats).
window.ajaxTrack = function (event, detail) {
    try {
        var meta = document.querySelector('meta[name="csrf-token"]');
        var body = 'e=' + encodeURIComponent(event) + (detail ? '&d=' + encodeURIComponent(detail) : '');
        fetch('/t', { method: 'POST', keepalive: true, credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': meta ? meta.content : '', 'X-Requested-With': 'XMLHttpRequest' }, body: body }).catch(function () {});
    } catch (e) { /* counting never gets in the way */ }
};
document.addEventListener('click', function (ev) {
    var a = ev.target && ev.target.closest ? ev.target.closest('a[href]') : null;
    if (!a) return;
    var href = a.getAttribute('href') || '';
    var kind = /^tel:/i.test(href) ? 'call_click' : /m\.me\/|messenger\.com/i.test(href) ? 'messenger_click' : /^viber:/i.test(href) ? 'viber_click' : /wa\.me\/|whatsapp/i.test(href) ? 'whatsapp_click' : null;
    if (kind) window.ajaxTrack(kind, location.pathname);
}, true);
(function () {
    // Mobile nav
    var toggle = document.querySelector('.nav-toggle');
    if (toggle) {
        var openIcon = toggle.querySelector('.icon-open');
        var closeIcon = toggle.querySelector('.icon-close');
        var setNavOpen = function (open) {
            document.body.classList.toggle('nav-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? toggle.dataset.labelClose : toggle.dataset.labelOpen);
            openIcon.hidden = open;
            closeIcon.hidden = !open;
        };
        toggle.addEventListener('click', function () {
            setNavOpen(!document.body.classList.contains('nav-open'));
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && document.body.classList.contains('nav-open')) setNavOpen(false);
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth > 1279) setNavOpen(false);
        });
    }

    // Live chat with Maya (via /chat/send and /chat/poll → CRM)
    var chat = document.getElementById('chat');
    if (chat) {
        var panel = document.getElementById('chat-panel');
        var toggleBtn = document.getElementById('chat-toggle');
        var closeBtn = document.getElementById('chat-close');
        var log = document.getElementById('chat-log');
        var form = document.getElementById('chat-form');
        var input = document.getElementById('chat-input');
        var typing = document.getElementById('chat-typing');
        var errorEl = document.getElementById('chat-error');
        var dot = document.getElementById('chat-dot');
        var t = JSON.parse(document.getElementById('chat-i18n').textContent);
        var started = chat.dataset.started === '1';
        var lastId = 0;
        var seen = {};
        var pollTimer = null;
        var sending = false;
        var humanShown = false;

        var store = {
            get: function (k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
            set: function (k, v) { try { sessionStorage.setItem(k, v); } catch (e) {} }
        };

        var pending = []; // visitor messages shown straight away, still waiting for their id

        function addMessage(m) {
            if (m.id) {
                lastId = Math.max(lastId, m.id);
                if (seen[m.id]) return;
                seen[m.id] = true;
                // The server sends our own message back (on poll or send): it is already on screen.
                if (m.from === 'visitor') {
                    for (var i = 0; i < pending.length; i++) {
                        if (pending[i] === m.text) { pending.splice(i, 1); return; }
                    }
                }
            } else if (m.from === 'visitor') {
                pending.push(m.text);
            }
            var div = document.createElement('div');
            div.className = 'msg ' + (m.from === 'visitor' ? 'msg--me' : 'msg--ajax');
            var name = document.createElement('span');
            name.className = 'msg-name';
            name.textContent = m.from === 'visitor' ? t.you : (m.name || 'Ajax');
            var p = document.createElement('p');
            p.textContent = m.text;
            div.appendChild(name);
            div.appendChild(p);
            log.appendChild(div);
            log.scrollTop = log.scrollHeight;
            if (m.from !== 'visitor' && panel.hidden) dot.hidden = false;
        }

        function note(text) {
            var div = document.createElement('div');
            div.className = 'msg-note';
            div.textContent = text;
            log.appendChild(div);
            log.scrollTop = log.scrollHeight;
        }

        function handle(data) {
            (data.messages || []).forEach(addMessage);
            if (data.human && !humanShown) { humanShown = true; note(t.human); }
        }

        function poll() {
            if (sending) return; // the send answer brings the new messages itself
            fetch(chat.dataset.pollUrl + '?after=' + lastId, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                .then(function (r) { return r.ok ? r.json() : null; })
                .then(function (d) { if (d) { errorEl.hidden = true; handle(d); } })
                .catch(function () {});
        }

        function startPolling() {
            if (pollTimer || !started) return;
            poll();
            pollTimer = setInterval(function () {
                // poll quickly while the panel is open, slowly while closed
                if (!panel.hidden || Date.now() % 20000 < 4000) poll();
            }, 4000);
        }

        function setOpen(open) {
            panel.hidden = !open;
            toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            chat.classList.toggle('is-open', open);
            document.body.classList.toggle('chat-open', open);
            store.set('ajaxChatOpen', open ? '1' : '0');
            if (open) { dot.hidden = true; log.scrollTop = log.scrollHeight; setTimeout(function () { input.focus(); }, 50); }
        }

        toggleBtn.addEventListener('click', function () { setOpen(panel.hidden); });
        closeBtn.addEventListener('click', function () { setOpen(false); toggleBtn.focus(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !panel.hidden) setOpen(false); });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); form.requestSubmit ? form.requestSubmit() : form.dispatchEvent(new Event('submit')); }
        });
        input.addEventListener('input', function () {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 120) + 'px';
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var text = input.value.trim();
            if (!text || sending) return;
            sending = true;
            errorEl.hidden = true;
            // show the visitor's message straight away
            addMessage({ from: 'visitor', text: text });
            input.value = '';
            input.style.height = 'auto';
            typing.hidden = false;

            var body = new URLSearchParams();
            body.set('text', text);
            body.set('after', String(lastId));
            body.set('page', location.pathname);

            fetch(chat.dataset.sendUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': chat.dataset.csrf, 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString()
            })
                .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
                .then(function (d) {
                    handle(d); // our own message comes back with its id and is matched to the one on screen
                    started = true;
                    startPolling();
                })
                .catch(function () { errorEl.hidden = false; })
                .then(function () { typing.hidden = true; sending = false; });
        });

        if (started) startPolling();
        if (store.get('ajaxChatOpen') === '1') setOpen(true);

        // Send a message as if the visitor typed it (the quick answers of Maya's offer).
        function sendText(text) {
            if (sending) return;
            input.value = text;
            form.requestSubmit ? form.requestSubmit() : form.dispatchEvent(new Event('submit', { cancelable: true }));
        }

        // (23 November 2026) Maya offers help: a visitor who started a design and stopped before leaving a name.
        // Shown once per visit, only when the chat has not started; nothing is sent until the visitor answers.
        window.ajaxChat = {
            started: function () { return started; },
            isOpen: function () { return !panel.hidden; },
            offer: function (context) {
                if (started || !panel.hidden || store.get('ajaxMayaOffer') === '1' || !t.nudge_text) return false;
                store.set('ajaxMayaOffer', '1');
                setOpen(true);
                addMessage({ from: 'ajax', name: 'Maya', text: t.nudge_text });
                var box = document.createElement('div');
                box.className = 'chat-quick';
                var extra = context ? '\n(' + t.nudge_choices + ': ' + context + ')' : '';
                [['help', t.nudge_help, t.nudge_help_msg + extra], ['expert', t.nudge_expert, t.nudge_expert_msg + extra], ['no', t.nudge_no, null]].forEach(function (b) {
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'chat-quick-btn chat-quick-btn--' + b[0];
                    btn.textContent = b[1];
                    btn.addEventListener('click', function () {
                        box.remove();
                        if (b[2]) { sendText(b[2]); } else { setOpen(false); }
                    });
                    box.appendChild(btn);
                });
                log.appendChild(box);
                log.scrollTop = log.scrollHeight;
                return true;
            }
        };
    }

    // Filter chips (portfolio + accessories): <button data-filter="x"> over [data-category] items
    document.querySelectorAll('[data-filter-group]').forEach(function (group) {
        var target = document.getElementById(group.dataset.filterGroup);
        if (!target) return;
        var buttons = group.querySelectorAll('[data-filter]');
        buttons.forEach(function (b) {
            b.addEventListener('click', function () {
                buttons.forEach(function (x) { x.setAttribute('aria-pressed', 'false'); });
                b.setAttribute('aria-pressed', 'true');
                var f = b.dataset.filter;
                target.querySelectorAll('[data-category]').forEach(function (el) {
                    el.hidden = !(f === 'all' || el.dataset.category === f);
                });
            });
        });
    });

    // Gentle reveal on scroll
    var items = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && items.length) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
            });
        }, { rootMargin: '0px 0px -8% 0px' });
        items.forEach(function (el) { io.observe(el); });
    } else {
        items.forEach(function (el) { el.classList.add('is-in'); });
    }
})();
