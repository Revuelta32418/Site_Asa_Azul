function toggleVerMais(btn, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    const estaExpandido = container.classList.toggle('expandido');
    const label = btn.querySelector('span');
    const icone = btn.querySelector('i');

    if (estaExpandido) {
        if (label) label.textContent = 'Ver menos';
        if (icone) icone.className = 'bi bi-chevron-up';
    } else {
        if (label) label.textContent = 'Ver mais';
        if (icone) icone.className = 'bi bi-chevron-down';
    }
}