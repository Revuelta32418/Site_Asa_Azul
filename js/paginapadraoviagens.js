/*-----carrossel de cards-----*/
const vagoes = document.querySelector(".carrossel-vagoes");
const cards = document.querySelectorAll(".cardCarrossel");

const btnProx = document.querySelector(".proximo");
const btnAnt = document.querySelector(".anterior");

let indice = 0;
let autoplay;

// Quantos cards aparecem na tela
function cardsVisiveis() {
    if (window.innerWidth <= 768) return 1;
    if (window.innerWidth <= 992) return 2;
    return 3;
}

// Atualiza posição do carrossel
function atualizarcarrossel() {
    const larguraCard = cards[0].offsetWidth + 24;
    vagoes.style.transform =
        `translateX(-${indice * larguraCard}px)`;
}

// Proximo card
function proximo() {
    const max = cards.length - cardsVisiveis();

    indice++;
    if (indice > max) {
        indice = 0;
    }

    atualizarcarrossel();
}

// card anterior
function anterior() {
    const max = cards.length - cardsVisiveis();

    indice--;
    if (indice < 0) {
        indice = max;
    }

    atualizarcarrossel();
}

//botoes
btnProx.addEventListener("click", () => {
    proximo();
});

btnAnt.addEventListener("click", () => {
    anterior();
});

// Autoplay
function iniciarAutoplay() {
    autoplay = setInterval(() => {
        proximo();
    }, 2500);
}

function pararAutoplay() {
    clearInterval(autoplay);
}

// Pausa quando o mouse estiver no carrossel
const carrossel = document.querySelector(".container-carrossel");

carrossel.addEventListener("mouseenter", pararAutoplay);
carrossel.addEventListener("mouseleave", iniciarAutoplay);

window.addEventListener("resize", () => {
    atualizarcarrossel();
});

atualizarcarrossel();
iniciarAutoplay();