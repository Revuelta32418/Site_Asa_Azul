<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
    <main class="pagina-viagem-main">

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
            <div class="descricao px-5">
                <h2 class="titulo">Descrição</h2>
                <p class="text-center">O Rio de Janeiro é uma cidade vibrante e cheia de vida, conhecida por suas praias deslumbrantes, paisagens icônicas e cultura rica. Com uma mistura única de natureza e urbanismo, o Rio oferece experiências inesquecíveis para todos os tipos de viajantes.</p>
            </div>
            <div class="turistando my-5">
                <h2 class="titulo">Turistando</h2>
                <div class="cultura-cards">
                    <div class="cultura-card">
                        <img src="../imagens/cristo.jpg" alt="Cristo Redentor">
                        <div class="cultura-info">
                            <span class="cultura-tag"><i class="bi bi-bank2"></i> Patrimônio histórico</span>
                            <h4>Cristo Redentor</h4>
                            <p>Uma das Sete Maravilhas do Mundo Moderno e símbolo da fé e da cultura carioca.</p>
                        </div>
                    </div>

                    <div class="cultura-card">
                        <img src="../imagens/samba.jpg" alt="Rodas de samba na Lapa">
                        <div class="cultura-info">
                            <span class="cultura-tag"><i class="bi bi-music-note-beamed"></i> Tradição musical</span>
                            <h4>Rodas de samba na Lapa</h4>
                            <p>Berço do samba carioca, com bares históricos e música ao vivo todas as noites.</p>
                        </div>
                    </div>

                    <div class="cultura-card">
                        <img src="../imagens/feira.jpg" alt="Feira de Ipanema">
                        <div class="cultura-info">
                            <span class="cultura-tag"><i class="bi bi-palette"></i> Artesanato local</span>
                            <h4>Feira de Ipanema</h4>
                            <p>Artesãos locais expõem peças únicas que carregam a identidade da cidade.</p>
                        </div>
                    </div>

                    <div class="cultura-card">
                        <img src="../imagens/culinaria.jpg" alt="Culinária carioca">
                        <div class="cultura-info">
                            <span class="cultura-tag"><i class="bi bi-cup-hot"></i> Gastronomia</span>
                            <h4>Culinária carioca</h4>
                            <p>Da feijoada aos botecos de esquina, sabores que contam a história da cidade.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="impacto">
                <div class="viagem-impacto secao-detalhes" id="impacto">
                    <div class="impacto-card">
                        <div class="impacto-texto">
                            <span class="impacto-selo"><i class="bi bi-leaf-fill"></i> Turismo de impacto positivo</span>
                            <h2>Sua viagem também transforma quem vive aqui</h2>
                            <p>
                                Parte da experiência no Rio de Janeiro é conduzida por guias e artesãos locais.
                                Ao viajar com a Asa Azul, você fortalece a economia da comunidade e ajuda a
                                preservar tradições que atravessam gerações.
                            </p>
                            <ul class="impacto-lista">
                                <li><i class="bi bi-check-circle-fill"></i> Parceria com artesãos da Feira de Ipanema</li>
                                <li><i class="bi bi-check-circle-fill"></i> Guias locais especializados em história carioca</li>
                                <li><i class="bi bi-check-circle-fill"></i> Parte da renda reinvestida em projetos culturais da região</li>
                            </ul>
                        </div>
                        <div class="impacto-imagem">
                            <img src="../imagens/rio3.jpg" alt="Comunidade local">
                        </div>
                    </div>
                </div>
            </div>

            <div class="avaliacoes my-5">
                <h2 class="titulo">Avaliações</h2>
                <div class="avaliacoes-cards d-flex gap-1 py-3 justify-content-center">
                    <div class="avaliacao-card p-3">
                        <div class="avaliacao-header">
                            <div class="align-items-center d-flex">
                                <i class="bi bi-person-circle me-2 fs-4"></i>
                                <h4>Mariana S.</h4>
                            </div>
                            <span class="nota"><i class="bi bi-star-fill"></i> 4.8</span>
                        </div>
                        <p>Uma experiência incrível! O Cristo Redentor é ainda mais impressionante pessoalmente. Recomendo!</p>
                    </div>

                    <div class="avaliacao-card p-3">
                        <div class="avaliacao-header">
                            <div class="align-items-center d-flex">
                                <i class="bi bi-person-circle me-2 fs-4"></i>
                                <h4>Lucas M.</h4>
                            </div>
                            <span class="nota"><i class="bi bi-star-fill"></i> 4.8</span>
                        </div>
                        <p>Amei as rodas de samba na Lapa! A música e a energia do lugar são contagiantes.</p>
                    </div>

                    <div class="avaliacao-card p-3">
                        <div class="avaliacao-header">
                            <div class="align-items-center d-flex">
                                <i class="bi bi-person-circle me-2 fs-4"></i>
                                <h4>Ana P.</h4>
                            </div>
                            <span class="nota"><i class="bi bi-star-fill"></i> 4.8</span>
                        </div>
                        <p>A Feira de Ipanema é um lugar encantador. Comprei lembranças únicas e conheci artesãos incríveis.</p>
                    </div>

                    <div class="avaliacao-card p-3">
                        <div class="avaliacao-header">
                            <div class="align-items-center d-flex">
                                <i class="bi bi-person-circle me-2 fs-4"></i>
                                <h4>Rafael T.</h4>
                            </div>
                            <span class="nota"><i class="bi bi-star-fill"></i> 4.8</span>
                        </div>
                        <p>A culinária carioca é deliciosa! Experimentei pratos típicos que nunca esquecerei.</p>
                    </div>
                </div>
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

        <?php
        if (file_exists('../componentes/carrossel.php')) {
            $texto = 'Talvez você também se interesse por:';
            include '../componentes/carrossel.php';
        }
        ?>
    </main>

    <?php
    if (file_exists('../componentes/footer.php')) {
        include '../componentes/footer.php';
    }
    ?>

    <script src="../js/bootstrap.js"></script>
    <script src="../js/jsgeral.js"></script>
    <script src="../js/jspaginapadrao.js"></script>
</body>

</html>