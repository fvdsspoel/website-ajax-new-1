// Ajax public site — motion and galleries (no libraries).
(function () {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Header: transparent over the dark hero, solid once you scroll.
    var header = document.getElementById('site-header');
    if (header) {
        var onScroll = function () { header.classList.toggle('is-solid', window.scrollY > 40); };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // Hero slideshow (crossfade + slow zoom) with progress dots.
    var slides = document.querySelectorAll('.hero-slide');
    var dots = document.querySelectorAll('.hero-dots button');
    if (slides.length > 1) {
        var current = 0, timer;
        var show = function (i) {
            slides[current].classList.remove('is-active');
            if (dots[current]) dots[current].classList.remove('is-active');
            current = (i + slides.length) % slides.length;
            var img = slides[current].querySelector('img[data-src]');
            if (img) { img.src = img.dataset.src; img.removeAttribute('data-src'); }
            slides[current].classList.add('is-active');
            if (dots[current]) { dots[current].classList.remove('is-active'); void dots[current].offsetWidth; dots[current].classList.add('is-active'); }
        };
        var play = function () { clearInterval(timer); if (!reduce) timer = setInterval(function () { show(current + 1); }, 6000); };
        dots.forEach(function (d, i) { d.addEventListener('click', function () { show(i); play(); }); });
        // Load the other slides once the page is idle.
        window.addEventListener('load', function () {
            setTimeout(function () {
                document.querySelectorAll('.hero-slide img[data-src]').forEach(function (img) { var pre = new Image(); pre.src = img.dataset.src; });
            }, 800);
        });
        play();
    }

    // Rotating word in the hero title.
    document.querySelectorAll('[data-rotator]').forEach(function (rot) {
        var words = rot.querySelectorAll('span');
        if (words.length < 2 || reduce) return;
        var i = 0;
        setInterval(function () {
            var prev = words[i];
            prev.classList.remove('is-active'); prev.classList.add('is-out');
            setTimeout(function () { prev.classList.remove('is-out'); }, 650);
            i = (i + 1) % words.length;
            words[i].classList.add('is-active');
        }, 2400);
    });

    // Reveal on scroll + counters.
    var counters = function (el) {
        el.querySelectorAll('[data-count]').forEach(function (c) {
            var end = parseFloat(c.dataset.count), start = performance.now(), dur = 1600;
            var fmt = function (v) { return Math.round(v).toLocaleString('en-PH'); };
            if (reduce) { c.textContent = fmt(end); return; }
            var step = function (t) {
                var p = Math.min(1, (t - start) / dur), e = 1 - Math.pow(1 - p, 3);
                c.textContent = fmt(end * e);
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        });
    };
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                en.target.classList.add('is-in');
                counters(en.target);
                io.unobserve(en.target);
            });
        }, { threshold: 0.14, rootMargin: '0px 0px -6% 0px' });
        document.querySelectorAll('[data-reveal], [data-counters]').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('[data-reveal]').forEach(function (el) { el.classList.add('is-in'); });
    }

    // Portfolio filter chips.
    var filterBar = document.querySelector('[data-filters]');
    if (filterBar) {
        filterBar.addEventListener('click', function (e) {
            var btn = e.target.closest('button[data-filter]');
            if (!btn) return;
            filterBar.querySelectorAll('button').forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
            var f = btn.dataset.filter;
            document.querySelectorAll('.project[data-cat]').forEach(function (p) { p.hidden = f !== 'all' && p.dataset.cat !== f; });
        });
    }

    // Lightbox: every project button opens its whole gallery.
    var lb = document.getElementById('lightbox');
    if (lb) {
        var lbImg = lb.querySelector('.lb-stage img'), lbTitle = lb.querySelector('h2'), lbMeta = lb.querySelector('.lb-head p');
        var thumbs = lb.querySelector('.lb-thumbs'), photos = [], idx = 0, opener = null;
        var go = function (i) {
            idx = (i + photos.length) % photos.length;
            lbImg.src = photos[idx].src;
            thumbs.querySelectorAll('button').forEach(function (b, j) { b.classList.toggle('is-active', j === idx); if (j === idx) b.scrollIntoView({ block: 'nearest', inline: 'center' }); });
        };
        var open = function (btn) {
            opener = btn;
            photos = JSON.parse(btn.dataset.gallery || '[]');
            lbTitle.textContent = btn.dataset.title || '';
            lbMeta.textContent = btn.dataset.meta || '';
            thumbs.innerHTML = '';
            photos.forEach(function (p, j) {
                var t = document.createElement('button');
                t.type = 'button';
                t.setAttribute('aria-label', (j + 1) + ' / ' + photos.length);
                t.innerHTML = '<img alt="" loading="lazy">';
                t.firstChild.src = p.thumb;
                t.addEventListener('click', function () { go(j); });
                thumbs.appendChild(t);
            });
            lb.classList.add('is-open');
            lb.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            go(0);
            lb.querySelector('.lb-close').focus();
        };
        var close = function () {
            lb.classList.remove('is-open');
            lb.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            if (opener) opener.focus();
        };
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-gallery]');
            if (btn) { e.preventDefault(); open(btn); }
        });
        lb.querySelector('.lb-close').addEventListener('click', close);
        lb.querySelector('.lb-prev').addEventListener('click', function () { go(idx - 1); });
        lb.querySelector('.lb-next').addEventListener('click', function () { go(idx + 1); });
        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowRight') go(idx + 1);
            if (e.key === 'ArrowLeft') go(idx - 1);
        });
        var sx = null;
        lb.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
        lb.addEventListener('touchend', function (e) {
            if (sx === null) return;
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 50) go(idx + (dx < 0 ? 1 : -1));
            sx = null;
        });
    }

    // Meta Pixel: a tap on Messenger / Viber / Call counts as "Contact".
    document.addEventListener('click', function (e) {
        var a = e.target.closest('[data-track]');
        if (a && window.fbq) window.fbq('track', a.dataset.track);
    });
})();
