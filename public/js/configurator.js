(function () {
    const script = document.currentScript;
    const priceUrl = script.dataset.priceUrl;
    const submitUrl = script.dataset.submitUrl;
    const csrf = script.dataset.csrf;

    const MODULE_LABELS = {
        base: 'Base cabinet',
        wall: 'Wall cabinet',
        drawer: 'Drawer unit',
        corner: 'Corner unit',
    };

    let modules = [];
    let counter = 0;

    const listEl = document.getElementById('module-list');
    const lmOut = document.getElementById('lm-out');
    const priceOut = document.getElementById('price-out');
    const substrateEl = document.getElementById('substrate');
    const form = document.getElementById('submit-form');
    const formMessage = document.getElementById('form-message');

    function renderModules() {
        listEl.innerHTML = '';
        if (modules.length === 0) {
            const empty = document.createElement('p');
            empty.className = 'module-empty';
            empty.textContent = 'No modules yet — add one below.';
            listEl.appendChild(empty);
            return;
        }
        modules.forEach((m) => {
            const row = document.createElement('div');
            row.className = 'module-row';
            row.innerHTML = `<span>${MODULE_LABELS[m.type]}</span>`;
            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'module-remove';
            remove.setAttribute('aria-label', 'Remove module');
            remove.textContent = '×';
            remove.addEventListener('click', () => {
                modules = modules.filter((x) => x.id !== m.id);
                renderModules();
                fetchPrice();
            });
            row.appendChild(remove);
            listEl.appendChild(row);
        });
    }

    async function fetchPrice() {
        try {
            const res = await fetch(priceUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    modules: modules.map((m) => ({ type: m.type })),
                    substrate: substrateEl.value,
                }),
            });
            if (!res.ok) return;
            const data = await res.json();
            lmOut.textContent = data.total_lm.toFixed(1) + ' lm';
            priceOut.textContent = '₱' + Math.round(data.estimated_price).toLocaleString();
        } catch (e) {
            // Network hiccup — leave the last known figures on screen
            // rather than showing an error for a non-critical live estimate.
        }
    }

    document.querySelectorAll('.add-module').forEach((btn) => {
        btn.addEventListener('click', () => {
            modules.push({ id: counter++, type: btn.dataset.type });
            renderModules();
            fetchPrice();
        });
    });

    substrateEl.addEventListener('change', fetchPrice);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('name').value.trim();
        const contact = document.getElementById('contact').value.trim();

        if (!name || !contact) {
            formMessage.textContent = 'Please fill in your name and contact details first.';
            formMessage.className = 'form-error';
            return;
        }

        formMessage.textContent = 'Sending…';
        formMessage.className = '';

        try {
            const res = await fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name,
                    contact,
                    modules: modules.map((m) => ({ type: m.type })),
                    substrate: substrateEl.value,
                }),
            });
            const data = await res.json();
            formMessage.textContent = data.message;
            formMessage.className = data.success ? 'form-success' : 'form-error';
        } catch (e) {
            formMessage.textContent = "We couldn't send that right now — please call us or try again.";
            formMessage.className = 'form-error';
        }
    });

    renderModules();
})();
