// "Design your kitchen" — lead-capture builder. No price is ever shown;
// the server prices the design for the sales team only (see README).
(function () {
    var script = document.currentScript;
    var submitUrl = script.dataset.submitUrl;
    var csrf = script.dataset.csrf;
    var t = JSON.parse(document.getElementById('builder-i18n').textContent);

    var modules = [];
    var counter = 0;

    var wallRow = document.getElementById('elev-wall');
    var baseRow = document.getElementById('elev-base');
    var counterEl = document.getElementById('elev-counter');
    var emptyEl = document.getElementById('elev-empty');
    var listEl = document.getElementById('module-list');
    var countEl = document.getElementById('module-count');
    var elev = document.getElementById('elev');
    var form = document.getElementById('submit-form');
    var msg = document.getElementById('form-message');

    function checked(name) {
        var el = document.querySelector('input[name="' + name + '"]:checked');
        return el ? el.value : null;
    }

    function applyColour() {
        var el = document.querySelector('input[name="colour"]:checked');
        if (el) elev.style.setProperty('--finish', el.dataset.hex);
    }

    function cabinet(m) {
        var div = document.createElement('div');
        div.className = 'cab cab--' + m.type;
        div.title = t.modules[m.type];
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = '×';
        btn.setAttribute('aria-label', t.remove + ': ' + t.modules[m.type]);
        btn.addEventListener('click', function () {
            modules = modules.filter(function (x) { return x.id !== m.id; });
            render();
        });
        div.appendChild(btn);
        return div;
    }

    function render() {
        wallRow.innerHTML = '';
        baseRow.innerHTML = '';
        listEl.innerHTML = '';
        var hasBase = false;
        var tally = {};

        modules.forEach(function (m) {
            if (m.type === 'wall') {
                wallRow.appendChild(cabinet(m));
            } else {
                baseRow.appendChild(cabinet(m));
                hasBase = true;
            }
            tally[m.type] = (tally[m.type] || 0) + 1;
        });

        Object.keys(tally).forEach(function (type) {
            var li = document.createElement('li');
            li.textContent = tally[type] + ' × ' + t.modules[type];
            listEl.appendChild(li);
        });

        // Counter top spans the base run
        counterEl.hidden = !hasBase;
        if (hasBase) counterEl.style.width = baseRow.scrollWidth + 'px';

        emptyEl.hidden = modules.length > 0;
        countEl.textContent = modules.length;
    }

    document.querySelectorAll('.module-add').forEach(function (btn) {
        btn.addEventListener('click', function () {
            modules.push({ id: counter++, type: btn.dataset.type });
            render();
        });
    });

    document.querySelectorAll('input[name="colour"]').forEach(function (el) {
        el.addEventListener('change', applyColour);
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var name = document.getElementById('name').value.trim();
        var contact = document.getElementById('contact').value.trim();

        if (modules.length === 0) { msg.textContent = t.needModule; msg.style.color = 'var(--err)'; return; }
        if (!name || !contact) { msg.textContent = t.needContact; msg.style.color = 'var(--err)'; return; }

        var accessories = Array.prototype.map.call(
            document.querySelectorAll('input[name="accessories[]"]:checked'),
            function (el) { return el.value; }
        );

        var button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        msg.textContent = t.sending;
        msg.style.color = '';

        fetch(submitUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({
                name: name,
                contact: contact,
                modules: modules.map(function (m) { return { type: m.type }; }),
                substrate: checked('substrate'),
                layout: checked('layout'),
                colour: checked('colour'),
                accessories: accessories,
            }),
        })
            .then(function (res) { return res.json().then(function (d) { return { ok: res.ok, d: d }; }); })
            .then(function (r) {
                var ok = r.ok && r.d.success;
                msg.textContent = ok ? t.success : t.error;
                msg.style.color = ok ? 'var(--ok)' : 'var(--err)';
                if (ok) form.reset(); else button.disabled = false;
            })
            .catch(function () {
                msg.textContent = t.error;
                msg.style.color = 'var(--err)';
                button.disabled = false;
            });
    });

    applyColour();
    render();
})();
