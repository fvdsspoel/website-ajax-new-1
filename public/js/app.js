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

    // Floating chat menu
    var chat = document.getElementById('float-chat');
    if (chat) {
        var btn = chat.querySelector('.float-chat-btn');
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = !chat.classList.contains('open');
            chat.classList.toggle('open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', function (e) {
            if (!chat.contains(e.target)) {
                chat.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
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
