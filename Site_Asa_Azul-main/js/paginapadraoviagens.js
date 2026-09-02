/*----------Header--------*/
//Hambuguer que esconde o navsuporte]
const menuToggle = document.querySelector(".menu-toggle");
const menuSuporte = document.querySelector(".nav-suporte-group");

menuToggle.addEventListener("click", () => {
    menuSuporte.classList.toggle("ativo");
});

//Escondendo o navmenu quando rolar
let ultimoScroll = 0;

const header = document.querySelector("header");

window.addEventListener("scroll", () => {

    const atual = window.pageYOffset;

    // Sempre mostra no topo
    if (atual <= 20) {
        header.classList.remove("esconder");
        ultimoScroll = atual;
        return;
    }

    if (atual > ultimoScroll) {
        header.classList.add("esconder");
    } else {
        header.classList.remove("esconder");
    }

    ultimoScroll = atual;

});

/*--------------modal-------------*/
const formLogin = document.getElementById("formLogin");

if (formLogin) {
    formLogin.addEventListener("submit", (e) => {
        e.preventDefault();
        // Aqui depois entra a lógica real de autenticação
        console.log("Tentativa de login enviada");
    });
}

/*----- Alternar Login / Cadastro -----*/
const formCadastro = document.getElementById("formCadastro");
const linkIrCadastro = document.getElementById("linkIrCadastro");
const linkVoltarLogin = document.getElementById("linkVoltarLogin");
const modalTitulo = document.getElementById("modalTitulo");
const modalSubtitulo = document.getElementById("modalSubtitulo");

function mostrarCadastro() {
    formLogin.style.display = "none";
    formCadastro.style.display = "block";
    modalTitulo.textContent = "Crie sua conta";
    modalSubtitulo.textContent = "É rápido e gratuito";
}

function mostrarLogin() {
    formCadastro.style.display = "none";
    formLogin.style.display = "block";
    modalTitulo.textContent = "Bem-vindo de volta";
    modalSubtitulo.textContent = "Entre para acompanhar suas viagens";
}

if (linkIrCadastro) {
    linkIrCadastro.addEventListener("click", (e) => {
        e.preventDefault();
        mostrarCadastro();
    });
}

if (linkVoltarLogin) {
    linkVoltarLogin.addEventListener("click", (e) => {
        e.preventDefault();
        mostrarLogin();
    });
}

// Reseta pro login toda vez que o modal for fechado
const modalLoginEl = document.getElementById("modalLogin");
modalLoginEl.addEventListener("hidden.bs.modal", mostrarLogin);

// Envio do cadastro
formCadastro.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log("Tentativa de cadastro enviada");
});

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