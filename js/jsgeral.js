/*-----------FAQ-----------*/
/*----- FAQ animado -----*/
const faqItens = document.querySelectorAll(".faq-item");

faqItens.forEach((item) => {
    const botao = item.querySelector(".faq-toggle");
    const conteudo = item.querySelector(".faq-conteudo");

    botao.addEventListener("click", () => {
        const estaAberto = item.classList.contains("aberto");

        // Fecha todos os outros (efeito acordeão - só um aberto por vez)
        faqItens.forEach((outro) => {
            outro.classList.remove("aberto");
            outro.querySelector(".faq-conteudo").style.maxHeight = null;
        });

        // Abre o clicado, se estava fechado
        if (!estaAberto) {
            item.classList.add("aberto");
            conteudo.style.maxHeight = conteudo.scrollHeight + "px";
        }
    });
});