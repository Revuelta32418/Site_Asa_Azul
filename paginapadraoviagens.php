<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul | Rio de Janeiro</title>
    <link rel="shortcut icon" href="../imagens/arara_com_circulo.png">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilogeral.css">
    <link rel="stylesheet" type="text/css" href="../css/estilopaginapadraoviagens.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php
    $base = '../'; //aqui, definimos o caminho até a origem da pasta, isso altera para cada arquivo

    if (file_exists('../componentes/header.php')) {
        include '../componentes/header.php';
    }

    if (file_exists('../componentes/modallogin.php')) {
        include '../componentes/modallogin.php';
    }
    ?>

    <!------------------main----------------->
    <main>

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

        <!-- Carrossel de outras viagens -->
        <section id="carrossel-cards" class="container-margem my-5">
            <h2 class="titulo mb-4">
                Você também vai gostar
            </h2>

            <div class="container-carrossel">
                <button class="carrossel-btn anterior">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="carrossel-tunel">
                    <div class="carrossel-vagoes">

                        <div class="cardCarrossel">
                            <img src="../imagens/florianopolis.jpg" alt="Florianópolis">
                            <div class="conteudoCard">
                                <h4>Florianópolis</h4>
                                <p>Descubra praias paradisíacas, gastronomia e muita natureza.</p>
                                <a href="viagemflorianopolis.html" class="btn btn-primary">Ver destino</a>
                            </div>
                        </div>

                        <div class="cardCarrossel">
                            <img src="../imagens/porto-seguro.png" alt="Porto Seguro">
                            <div class="conteudoCard">
                                <h4>Porto Seguro</h4>
                                <p>História, cultura e praias incríveis para toda a família.</p>
                                <a href="viagemportoseguro.html" class="btn btn-primary">Ver destino</a>
                            </div>
                        </div>

                        <div class="cardCarrossel">
                            <img src="../imagens/maceio.jpg" alt="Maceió">
                            <div class="conteudoCard">
                                <h4>Maceió</h4>
                                <p>Piscinas naturais, mar cristalino e paisagens inesquecíveis.</p>
                                <a href="viagemmaceio.html" class="btn btn-primary">Ver destino</a>
                            </div>
                        </div>

                        <div class="cardCarrossel">
                            <img src="../imagens/foto5.jpg" alt="Bonito">
                            <div class="conteudoCard">
                                <h4>Bonito</h4>
                                <p>Mergulhos, rios transparentes e aventuras em meio à natureza.</p>
                                <a href="viagembonito.html" class="btn btn-primary">Ver destino</a>
                            </div>
                        </div>

                        <div class="cardCarrossel">
                            <img src="../imagens/foto6.jpg" alt="Fernando de Noronha">
                            <div class="conteudoCard">
                                <h4>Fernando de Noronha</h4>
                                <p>Um dos arquipélagos mais desejados do mundo.</p>
                                <a href="viagemnoronha.html" class="btn btn-primary">Ver destino</a>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="carrossel-btn proximo">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </section>

    </main>

    <?php
    if (file_exists('../componentes/faq.php')){
        include '../componentes/faq.php';
    }

    if (file_exists('../componentes/footer.php')){
        include '../componentes/footer.php';
    }
    ?>

    <script src="../js/bootstrap.js"></script>
    <script src="../js/jsindex.js"></script>
</body>

</html>