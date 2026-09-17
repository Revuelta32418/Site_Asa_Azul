<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul | Rio de Janeiro</title>
    <link rel="shortcut icon" href="../imagens/arara_com_circulo.png">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilopaginapadraoviagens.css">
    <link rel="stylesheet" type="text/css" href="../css/estilogeral.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php
    $base = '../'; //aqui, definimos o caminho até a origem da pasta, isso altera para cada arquivo
    $hideHeader = true;

    if (file_exists('../componentes/header.php')) {
        include '../componentes/header.php';
    }

    if (file_exists('../componentes/modallogin.php')) {
        include '../componentes/modallogin.php';
    }
    ?>

    <!------------------main----------------->
    <main style="margin-top: 100px;">

        <!-----Galeria de fotos que abre------->
        <section class="viagem-hero-galeria container-margem pb-3">
            <h1 class="titulo mb-4">Rio de Janeiro</h1>
            <div class="hero-galeria-grid">
                <img src="../imagens/rio_de_janeiro.jpg">
                <img src="../imagens/rio1.jpg">
                <img src="../imagens/rio2.jpg">
                <img src="../imagens/rio3.jpg">
            </div>
        </section>

        <!------ Barra de info rapida ----->
        <section class="container-margem my-5">
            <div class="viagem-infobar">
                <div>
                    <span class="viagem-label">A partir de</span>
                    <span class="viagem-valor">R$ 890</span>
                </div>
                <div>
                    <span class="viagem-label">Duração sugerida</span>
                    <span class="viagem-valor">4 dias</span>
                </div>
                <div>
                    <span class="viagem-label">Melhor época</span>
                    <span class="viagem-valor">Set a Mar</span>
                </div>
                <a href="#" class="btn-reservar">
                    Reservar viagem <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </section>

        <section class="detalhes container-margem">
            <nav class="viagem-abas d-flex justify-content-center mb-4">
                <button class="viagem-aba-btn active" data-aba="visao-geral">Visão geral</button>
                <button class="viagem-aba-btn" data-aba="costumes">Costumes do povo</button>
                <button class="viagem-aba-btn" data-aba="impacto">Impacto local</button>
                <button class="viagem-aba-btn" data-aba="avaliacoes">Avaliações</button>
            </nav>


        </section>

        <!-- CTA final -->
        <section class="viagem-cta">
            <div class="container-margem">
                <h3>Pronto para conhecer o Rio de Janeiro?</h3>
                <p>Garanta sua passagem e viva essa experiência cultural completa.</p>
                <a href="#" class="btn-reservar btn-reservar-claro">
                    Reservar agora <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </section>

        <?php
        if (file_exists('../componentes/carrossel.php')) {
            include '../componentes/carrossel.php';
        }
        ?>
    </main>

    <?php
    if (file_exists('../componentes/faq.php')) {
        include '../componentes/faq.php';
    }

    if (file_exists('../componentes/footer.php')) {
        include '../componentes/footer.php';
    }
    ?>

    <script src="../js/bootstrap.js"></script>
    <script src="../js/jsgeral.js"></script>
    <script src="../js/jspaginaspadrao.js"></script>
</body>

</html>