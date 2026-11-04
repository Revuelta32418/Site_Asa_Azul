<footer class="container-margem mx-auto">

    <section class="container-margem  d-flex flex-wrap justify-content-between mx-auto px-5 py-3 gap-3"
        id="conteudo">
        <div id="alunos">
            <strong>Alunos<br></strong>

            <a href="">Ana Luiza Araujo Silva<br></a>
            <a href="">Eloa Neves da Silva<br></a>
            <a href="">Isaac Henrique Machado<br></a>
            <a href="">Kayke Andrade Marino<br></a>
            <a href="">Maria Eduarda Martins Fernandes<br></a>
            <a href="">Miguel Revuelta Mendes<br></a>
            <a href="">Professora: Janaína</a>
        </div>

        <div id="trabalhe-conosco" class="justify-content-center">
            <strong>Trabalhe conosco<br></strong>
            <?php $tipoAtual = $_SESSION['usuario_tipo'] ?? 'cliente'; ?>

            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <button type="button" class="seja-guia" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    Seja um guia
                </button>
            <?php elseif ($tipoAtual === 'cliente'): ?>
                <button type="button" class="seja-guia" data-bs-toggle="modal" data-bs-target="#modalSejaGuia">
                    Seja um guia
                </button>
            <?php endif; ?>
            <br>
            <a href="">Anuncie sua propriedade<br></a>
        </div>

        <div id="negocios">
            <strong>Entre em contato<br></strong>
            <a href="https://www.instagram.com/">@asa_azul<br></a>
            <a>(35) 98765 4321<br></a>
            <a>asazul@gmail.com</a>
        </div>
    </section>

    <section class="container-margem  p-2 border-top border-secondary border-1 d-flex justify-content-center"
        id="direitos">
        <p class="mb-0 text-secondary">2026 - Todos os direitos reservados</p>
    </section>

    <?php
    if (isset($_SESSION['usuario_id']) && ($_SESSION['usuario_tipo'] ?? 'cliente') === 'cliente') {
        include __DIR__ . '/modalsejaguia.php';
    }
    ?>
</footer>