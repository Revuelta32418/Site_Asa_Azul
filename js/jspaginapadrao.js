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

document.addEventListener('DOMContentLoaded', function() {
    const vagoes = document.getElementById('galeriaVagoes');
    const dots = document.querySelectorAll('#galeriaIndicadores .dot');

    if (!vagoes || dots.length === 0) return;

    let indexAtual = 0;
    const totalFotos = vagoes.children.length; // 4 fotos
    const fotosPorTela = 2;
    const maxIndex = totalFotos - fotosPorTela; // 2 passos (0, 1, 2)

    function atualizarGaleria() {
        // Pega a largura do item + o gap (12px)
        const itemWidth = vagoes.children[0].getBoundingClientRect().width + 12;
        const deslocamento = indexAtual * itemWidth;

        vagoes.style.transform = `translateX(-${deslocamento}px)`;

        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === indexAtual);
        });
    }

    // Suporte para deslizar o dedo na tela (Touch Swipe)
    let startX = 0;
    let endX = 0;

    vagoes.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
    }, { passive: true });

    vagoes.addEventListener('touchend', e => {
        endX = e.changedTouches[0].clientX;
        const diffX = startX - endX;

        if (Math.abs(diffX) > 40) { // Se moveu mais de 40px
            if (diffX > 0 && indexAtual < maxIndex) {
                indexAtual++; // Desliza pra esquerda -> avança 1 foto
            } else if (diffX < 0 && indexAtual > 0) {
                indexAtual--; // Desliza pra direita -> volta 1 foto
            }
            atualizarGaleria();
        }
    }, { passive: true });
});