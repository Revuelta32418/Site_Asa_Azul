/*-------- botoes da nav descricao --------*/
const abaBtns = document.querySelectorAll(".viagem-aba-btn");

if (abaBtns.length > 0) {
    abaBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            abaBtns.forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");

            const alvo = document.getElementById(btn.dataset.aba);
            if (alvo) {
                alvo.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });
}
