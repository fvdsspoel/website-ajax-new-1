(function () {
    const script = document.currentScript;
    const submitUrl = script.dataset.submitUrl;
    const csrf = script.dataset.csrf;
    const moduleLm = JSON.parse(document.getElementById('module-lm-data').textContent);

    const MODULE_LABELS = {
        base: 'Base cabinet',
        wall: 'Wall cabinet',
        drawer: 'Drawer unit',
        corner: 'Corner unit',
    };

    let modules = [];
    let counter = 0;

    const listEl = document.getElementById('module-list');
    const countOut = document.getElementById('lm-out');
    const substrateEl = document.getElementById('substrate');
    const form = document.getElementById('submit-form');
    const formMessage = document.getElementById('form-message');

    // No price shown to the customer — this is a design/lead-capture
    // tool, not a checkout. The estimate is still computed server-side
    // on submit and attached for the sales team's reference only.
    function renderModules() {
        listEl.innerHTML = '';
        if (modules.length === 0) {
            const empty = document.createElement('p');
            empty.className = 'module-empty';
            empty.textContent = 'No modules yet — add one below.';
            listEl.appendChild(empty);
        } else {
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
                });
                row.appendChild(remove);
                listEl.appendChild(row);
            });
        }
        countOut.textContent = modules.length;
    }

    document.querySelectorAll('.add-module').forEach((btn) => {
        btn.addEventListener('click', () => {
            modules.push({ id: counter++, type: btn.dataset.type });
            renderModules();
        });
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('name').value.trim();
        const contact = document.getElementById('contact').value.trim();

        if (!name || !contact) {
            formMessage.textContent = 'Please fill in your name and contact details first.';
            formMessage.className = 'form-error';
            return;
        }
        if (modules.length === 0) {
            formMessage.textContent = 'Add at least one module so we know what to quote.';
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
