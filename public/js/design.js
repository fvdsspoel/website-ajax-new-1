// Design selector: 6 steps, file upload, sent to the website server → CRM.
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
        next.hidden = last; submit.hidden = !last;
        skip.hidden = cur === 0 || last;   // the room must be chosen; the contact step is sent, not skipped
        if (last) review();
        if (window.innerWidth < 1000) form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Layouts follow the room: kitchen, wardrobe, living have their own; others share one set.
    function syncRoom() {
        var room = val('room');
        // every room type has its own layouts and its own style drawings
        var set = form.querySelector('[data-layouts="' + room + '"]') ? room : (room ? 'other' : 'kitchen');
        form.querySelectorAll('[data-layouts]').forEach(function (g) {
            var on = g.dataset.layouts === set;
            g.hidden = !on;
            g.querySelectorAll('input').forEach(function (inp) { inp.disabled = !on; if (!on) inp.checked = false; });
        });
        // Style pictures follow the room too: a wardrobe shows wardrobes, a TV wall shows TV walls.
        var styleSet = room || 'kitchen';
        // a whole condo has no single wall to measure
        var sizeField = form.querySelector('#size').closest('.field');
        sizeField.hidden = room === 'whole';
        if (room === 'whole') form.size_m.value = '';
        form.querySelectorAll('[data-style-set]').forEach(function (el) { el.hidden = el.dataset.styleSet !== styleSet; });
        var top = form.querySelector('[data-top-block]');
        var needsTop = !room || room === 'kitchen' || room === 'bath' || room === 'whole';
        top.hidden = !needsTop;
        if (!needsTop) form.querySelectorAll('input[name="top"]').forEach(function (i) { i.checked = false; });
        document.querySelector('[data-sum="top"]').hidden = !needsTop;
    }

    // Colour step: every board colour (plywood or particle board) and every HPL colour; filter by finish.
    var cpGroup = 'board', cpFinish = 'all', lastFinish = '';
    function cpApply() {
        form.querySelectorAll('.cp').forEach(function (c) {
            var g = c.dataset.group, f = c.dataset.cfinish;
            c.hidden = g !== 'any' && ((cpGroup !== 'all' && g !== cpGroup) || (cpFinish !== 'all' && f !== cpFinish));
        });
        form.querySelectorAll('[data-cp-groups] button').forEach(function (b) { b.setAttribute('aria-pressed', b.dataset.group === cpGroup ? 'true' : 'false'); });
        form.querySelectorAll('[data-cp-finishes] button').forEach(function (b) { b.setAttribute('aria-pressed', b.dataset.cfinish === cpFinish ? 'true' : 'false'); });
    }
    // The finish picked above opens the matching colours: HPL → HPL, high-gloss → all gloss boards.
    function cpFollowFinish() {
        var fin = val('finish');
        if (fin === lastFinish) return;
        lastFinish = fin;
        if (fin === 'melamine') { cpGroup = 'board'; cpFinish = 'all'; }
        else if (fin === 'hpl') { cpGroup = 'hpl'; cpFinish = 'all'; }
        else if (fin === 'gloss') { cpGroup = 'all'; cpFinish = 'gloss'; }
        else { cpGroup = 'all'; cpFinish = 'all'; }
        form.querySelector('[data-paint-note]').hidden = fin !== 'paint';
        cpApply();
    }
    form.querySelector('[data-cp-groups]').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-group]'); if (!b) return;
        cpGroup = b.dataset.group; cpApply();
    });
    form.querySelector('[data-cp-finishes]').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-cfinish]'); if (!b) return;
        cpFinish = b.dataset.cfinish; cpApply();
    });

    function sum(key, text) {
        var row = document.querySelector('[data-sum="' + key + '"]');
        if (!row) return;
        row.querySelector('dd').textContent = text || '';
        row.hidden = !text;   // only what was chosen is listed
    }

    // The picture of the chosen style (desktop summary).
    function styleThumb() {
        var box = document.getElementById('sum-thumb'), el = form.querySelector('input[name="style"]:checked');
        var art = el ? el.parentNode.querySelector('.opt-art:not([hidden])') : null;
        // own ids for the copy: the step with the original drawing is hidden later, and hidden gradients don't paint
        box.innerHTML = art ? art.innerHTML.replace(/sk-/g, 'sum-sk-') : '';
        box.hidden = !art;
    }

    // On phones: the choices, listed on the last step before sending.
    function review() {
        var dl = document.querySelector('#review dl'), html = '';
        document.querySelectorAll('#summary-list > div').forEach(function (row) {
            if (!row.hidden) html += '<div>' + row.innerHTML + '</div>';
        });
        dl.innerHTML = html;
        document.getElementById('review').hidden = !html;
    }

    function refresh() {
        syncRoom();
        cpFollowFinish();
        sum('room', lab('room'));
        var size = form.size_m && form.size_m.value ? ' · ' + form.size_m.value + ' m' : '';
        sum('layout', (lab('layout') || '') + size);
        sum('style', lab('style'));
        sum('board', lab('board'));
        sum('finish', lab('finish'));
        sum('colour', lab('colour'));
        sum('top', lab('top'));
        sum('files', files.length ? files.length + ' ✓' : '');
        styleThumb();
        var any = Array.prototype.some.call(document.querySelectorAll('#summary-list > div'), function (r) { return !r.hidden; });
        document.getElementById('sum-empty').hidden = any;
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
                if (window.ajaxLead) window.ajaxLead();
                form.querySelectorAll('.pane, .pane-nav, .stepper, #step-label').forEach(function (el) { el.hidden = true; el.classList.remove('is-active'); });
                document.getElementById('done').hidden = false;
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .catch(function (err) { showError(err.message || t.error); })
            .finally(function () { submit.disabled = false; if (submit.dataset.text) submit.innerHTML = submit.dataset.text; });
    });

    // "#upload" (from the homepage) jumps straight to the upload step.
    cpApply();
    refresh();
    if (location.hash === '#upload') go(4); else go(0);
    window.scrollTo(0, 0);
})();
