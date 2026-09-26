// Ajax public site — small, dependency-free behaviours.
(function () {
    // Mobile nav
    var toggle = document.querySelector('.nav-toggle');
    if (toggle) {
        var openIcon = toggle.querySelector('.icon-open');
        var closeIcon = toggle.querySelector('.icon-close');
        var setOpen = function (open) {
            document.body.classList.toggle('nav-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? toggle.dataset.labelClose : toggle.dataset.labelOpen);
            openIcon.hidden = open;
            closeIcon.hidden = !open;
        };
        toggle.addEventListener('click', function () {
            setOpen(!document.body.classList.contains('nav-open'));
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && document.body.classList.contains('nav-open')) setOpen(false);
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth > 1240) setOpen(false);
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

        function addMessage(m) {
            if (m.id) {
                lastId = Math.max(lastId, m.id);
                if (seen[m.id]) return;
                seen[m.id] = true;
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
                    // server echoes the visitor's message with its id; skip re-drawing it
                    (d.messages || []).forEach(function (m) { if (m.from === 'visitor' && m.text === text) seen[m.id] = true; });
                    handle(d);
                    started = true;
                    startPolling();
                })
                .catch(function () { errorEl.hidden = false; })
                .then(function () { typing.hidden = true; sending = false; });
        });

        if (started) startPolling();
        if (store.get('ajaxChatOpen') === '1') setOpen(true);
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
