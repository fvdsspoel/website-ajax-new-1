// Design selector: 6 steps, a live sketch, file upload, sent to the website server → CRM.
(function () {
    var form = document.getElementById('designer');
    if (!form) return;
    var t = JSON.parse(form.dataset.i18n);
    var panes = form.querySelectorAll('.pane');
    var bars = form.querySelectorAll('.stepper span');
    var label = document.getElementById('step-label');
    var stepNames = JSON.parse(form.dataset.steps);
    var back = form.querySelector('[data-back]'), next = form.querySelector('[data-next]'), skip = form.querySelector('[data-skip]'), submit = form.querySelector('[data-submit]');
    var errBox = document.getElementById('form-error');
    var colours = JSON.parse(document.getElementById('sketch-colours').textContent);
    var cur = 0, files = [];
    var MAX = 5, MAX_BYTES = 8 * 1024 * 1024, OK = /\.(jpe?g|png|webp|pdf)$/i;

    function val(name) { var el = form.querySelector('input[name="' + name + '"]:checked'); return el ? el.value : ''; }
    function lab(name) { var el = form.querySelector('input[name="' + name + '"]:checked'); return el ? el.dataset.label : ''; }

    function go(i) {
        cur = Math.max(0, Math.min(panes.length - 1, i));
        panes.forEach(function (p, j) { p.classList.toggle('is-active', j === cur); });
        bars.forEach(function (b, j) { b.className = j < cur ? 'is-done' : (j === cur ? 'is-current' : ''); });
        label.textContent = t.step + ' ' + (cur + 1) + ' ' + t.of + ' ' + panes.length + ' · ' + stepNames[cur];
        back.hidden = cur === 0;
        var last = cur === panes.length - 1;
        next.hidden = last; skip.hidden = last; submit.hidden = !last;
        if (window.innerWidth < 1000) form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Layouts follow the room: kitchen, wardrobe, living have their own; others share one set.
    function syncRoom() {
        var room = val('room');
        var set = ['kitchen', 'wardrobe', 'living'].indexOf(room) >= 0 ? room : (room ? 'other' : 'kitchen');
        form.querySelectorAll('[data-layouts]').forEach(function (g) {
            var on = g.dataset.layouts === set;
            g.hidden = !on;
            g.querySelectorAll('input').forEach(function (inp) { inp.disabled = !on; if (!on) inp.checked = false; });
        });
        var top = form.querySelector('[data-top-block]');
        var needsTop = !room || room === 'kitchen' || room === 'bath' || room === 'whole';
        top.hidden = !needsTop;
        if (!needsTop) form.querySelectorAll('input[name="top"]').forEach(function (i) { i.checked = false; });
        document.querySelector('[data-sum="top"]').hidden = !needsTop;
    }

    function sum(key, text) {
        var row = document.querySelector('[data-sum="' + key + '"] dd');
        if (!row) return;
        row.textContent = text || '—';
        row.classList.toggle('empty', !text);
    }

    // Live sketch of the choice (top view for kitchens, front view for the rest).
    function sketch() {
        var room = val('room') || 'kitchen', layout = val('layout'), c = colours[val('colour')] || '#e9e4d8', top = colours[val('top')] || '#f1efe9';
        if (val('top') === 'none') top = 'transparent';
        var R = function (x, y, w, h, cls, fill) { return '<rect class="' + cls + '" x="' + x + '" y="' + y + '" width="' + w + '" height="' + h + '" rx="1.5" fill="' + fill + '"/>'; };
        var cab = function (x, y, w, h) { return R(x, y, w, h, 'cab', c) + R(x, y, w, Math.min(3, h), 'top', top); };
        var s = '<svg viewBox="0 0 160 100" xmlns="http://www.w3.org/2000/svg">';
        if (room === 'kitchen' || room === 'whole' || room === 'bath') {
            s += '<path class="wall" d="M10 10H150V90H10Z"/>';
            var L = layout || 'straight';
            s += cab(14, 14, 132, 20);
            if (L === 'l_shape' || L === 'u_shape') s += cab(14, 34, 20, 52);
            if (L === 'u_shape') s += cab(126, 34, 20, 52);
            if (L === 'island') s += cab(50, 58, 60, 22);
            if (L === 'parallel') s += cab(14, 66, 132, 20);
            s += '<rect x="70" y="18" width="18" height="11" rx="2" fill="rgba(0,0,0,.18)"/>';
            s += '<text x="80" y="52" text-anchor="middle">' + (lab('layout') || '').toUpperCase() + '</text>';
        } else if (room === 'wardrobe' || room === 'bedroom') {
            var n = layout === 'sliding' ? 2 : 4;
            s += '<path class="wall" d="M10 92H150"/>';
            if (layout === 'walk_in') { s += cab(20, 14, 120, 14) + cab(20, 28, 18, 62) + cab(122, 28, 18, 62); }
            else if (layout === 'open') { s += cab(30, 10, 100, 82); for (var k = 1; k < 4; k++) s += '<path d="M30 ' + (10 + k * 20.5) + 'H130" stroke="rgba(0,0,0,.35)"/>'; }
            else { for (var d = 0; d < n; d++) { var w = 100 / n; s += R(30 + d * w + .5, 10, w - 1, 82, 'cab', c); if (val('style') === 'handles') s += '<rect x="' + (30 + d * w + w / 2 - 1) + '" y="40" width="2" height="18" fill="#222"/>'; } }
        } else if (room === 'living') {
            s += '<path class="wall" d="M6 92H154"/>';
            if (layout === 'wall' || layout === 'shelves') s += R(18, 8, 124, 70, 'cab', c);
            s += '<rect x="50" y="22" width="60" height="34" rx="2" fill="#151515"/>';
            s += cab(26, 70, 108, 18);
        } else {
            s += '<path class="wall" d="M10 92H150"/>' + cab(40, 30, 80, 60);
        }
        s += '</svg>';
        document.getElementById('sketch').innerHTML = s;
    }

    function refresh() {
        syncRoom();
        sum('room', lab('room'));
        var size = form.size_m && form.size_m.value ? ' · ' + form.size_m.value + ' m' : '';
        sum('layout', (lab('layout') || '') + size);
        sum('style', lab('style'));
        sum('finish', lab('finish'));
        sum('colour', lab('colour'));
        sum('top', lab('top'));
        sum('files', files.length ? files.length + ' ✓' : '');
        sketch();
        var nx = val('next');
        form.querySelector('[data-visit-fields]').hidden = !(nx === 'measure' || nx === 'showroom');
    }

    form.addEventListener('change', function (e) {
        refresh();
        // A picked tile moves you on (not for colour/top, which share a step).
        if (e.target.type === 'radio' && ['room', 'style'].indexOf(e.target.name) >= 0) setTimeout(function () { go(cur + 1); }, 260);
    });
    form.addEventListener('input', function (e) { if (e.target.name === 'size_m') refresh(); });
    next.addEventListener('click', function () { go(cur + 1); });
    skip.addEventListener('click', function () { go(cur + 1); });
    back.addEventListener('click', function () { go(cur - 1); });

    // Files: up to 5, JPG/PNG/WEBP/PDF, 8 MB each — checked before sending.
    var input = document.getElementById('files'), list = document.getElementById('file-list'), dz = document.getElementById('dropzone');
    function showError(msg) { errBox.textContent = msg; errBox.hidden = !msg; if (msg && cur !== panes.length - 1) alert(msg); }
    function addFiles(fl) {
        Array.prototype.forEach.call(fl, function (f) {
            if (files.length >= MAX) { showError(t.too_many); return; }
            if (!OK.test(f.name)) { showError(t.bad_type + ' ' + f.name); return; }
            if (f.size > MAX_BYTES) { showError(t.too_big + ' ' + f.name); return; }
            files.push(f);
        });
        input.value = '';
        renderFiles(); refresh();
    }
    function renderFiles() {
        list.innerHTML = '';
        files.forEach(function (f, i) {
            var row = document.createElement('div'); row.className = 'file-item';
            var thumb;
            if (/^image\//.test(f.type)) { thumb = document.createElement('img'); thumb.src = URL.createObjectURL(f); thumb.alt = ''; }
            else { thumb = document.createElement('span'); thumb.className = 'ficon'; thumb.textContent = 'PDF'; }
            var name = document.createElement('span'); name.textContent = f.name + ' · ' + (f.size / 1048576).toFixed(1) + ' MB';
            var rm = document.createElement('button'); rm.type = 'button'; rm.setAttribute('aria-label', 'Remove'); rm.innerHTML = '&times;';
            rm.addEventListener('click', function () { files.splice(i, 1); renderFiles(); refresh(); });
            row.appendChild(thumb); row.appendChild(name); row.appendChild(rm); list.appendChild(row);
        });
    }
    input.addEventListener('change', function () { addFiles(input.files); });
    ['dragenter', 'dragover'].forEach(function (ev) { dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.add('is-over'); }); });
    ['dragleave', 'drop'].forEach(function (ev) { dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.remove('is-over'); }); });
    dz.addEventListener('drop', function (e) { if (e.dataTransfer && e.dataTransfer.files) addFiles(e.dataTransfer.files); });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        showError('');
        if (!form.name.value.trim() || !form.mobile.value.trim()) { showError(t.required); (form.name.value.trim() ? form.mobile : form.name).focus(); return; }
        var fd = new FormData(form);
        fd.delete('files[]');
        files.forEach(function (f) { fd.append('files[]', f, f.name); });
        submit.disabled = true; submit.dataset.text = submit.innerHTML; submit.textContent = t.sending;
        fetch(form.action, { method: 'POST', body: fd, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
            .then(function (res) {
                if (!res.ok || !res.j.success) throw new Error((res.j && (res.j.message || (res.j.errors && Object.values(res.j.errors)[0][0]))) || t.error);
                if (window.fbq) window.fbq('track', 'Lead');
                if (window.gtag) window.gtag('event', 'generate_lead');
                form.querySelectorAll('.pane, .pane-nav, .stepper, #step-label').forEach(function (el) { el.hidden = true; el.classList.remove('is-active'); });
                document.getElementById('done').hidden = false;
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .catch(function (err) { showError(err.message || t.error); })
            .finally(function () { submit.disabled = false; if (submit.dataset.text) submit.innerHTML = submit.dataset.text; });
    });

    // "#upload" (from the homepage) jumps straight to the upload step.
    refresh();
    if (location.hash === '#upload') go(4); else go(0);
    window.scrollTo(0, 0);
})();
