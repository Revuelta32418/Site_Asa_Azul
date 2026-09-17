const abaBtns = document.querySelectorAll(".viagem-aba-btn");
const secoes = document.querySelectorAll(".secao-detalhes");

if (abaBtns.length > 0) {
    abaBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            abaBtns.forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");

            secoes.forEach((secao) => {
                secao.style.display = "none";
            });

            const alvoId = btn.getAttribute("data-aba");
            const secaoAlvo = document.getElementById(alvoId);

            if (secaoAlvo) {
                secaoAlvo.style.display = "block";
            }
        });
    });
}