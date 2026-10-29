<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '../'; //aqui, definimos o caminho até a origem da pasta, isso altera para cada arquivo
require_once($base . "banco/viagensDAO.php");
require_once($base . "banco/conexao.php");

$slug = $_GET['viagem'] ?? '';
$id = $_GET['id'] ?? '';

if ($slug) {
    $viagem = buscarViagemPorSlug($conexao, $slug);
} elseif ($id) {
    $viagem = buscarViagemPorId($conexao, $id);
} else {
    $viagem = buscarViagemPorId($conexao, 1); // caso não tenha slug nem id, mostra a viagem de id 1
}

if (!$viagem) {
    $_SESSION['mensagem'] = "Viagem não encontrada.";
    header("Location: " . $base . "index.php");
    exit();
}

$hideHeader = true;
$excluirId = $viagem['id']; // para o carrossel não sugerir a própria viagem


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul | <?= htmlspecialchars($viagem['nome']) ?></title>
    <link rel="shortcut icon" href="../imagens/arara_com_circulo.png">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilopaginapadraoviagens.css">
    <link rel="stylesheet" type="text/css" href="../css/estilogeral.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php
    if (file_exists('../componentes/header.php')) {
        include '../componentes/header.php';
    }

    if (file_exists('../componentes/modallogin.php')) {
        include '../componentes/modallogin.php';
    }

    if (file_exists('../componentes/toast.php')) {
        include '../componentes/toast.php';
    }

    if (file_exists('../componentes/modalreservar.php')) {
        include '../componentes/modalreservar.php';
    }
    ?>

    <!------------------main----------------->
    <main class="pagina-viagem-main">

        <!-----Galeria de fotos que abre------->
        <section class="viagem-hero-galeria container-margem pb-3">

            <h1 class="titulo mb-4"><?php echo $viagem['nome']; ?></h1>
            <div class="hero-galeria-grid">
                <img src="<?php echo $base . $viagem['foto1']; ?>" alt="Foto 1 da viagem">
                <img src="<?php echo $base . $viagem['foto2']; ?>" alt="Foto 2 da viagem">
                <img src="<?php echo $base . $viagem['foto3']; ?>" alt="Foto 3 da viagem">
                <img src="<?php echo $base . $viagem['foto4']; ?>" alt="Foto 4 da viagem">
            </div>
        </section>

        <!------ Barra de info rapida ----->
        <section class="container-margem my-5">
            <div class="viagem-infobar">
                <div>
                    <span class="viagem-label">A partir de</span>
                    <span class="viagem-valor"><?= $viagem['preco'] ?></span>
                </div>
                <div>
                    <span class="viagem-label">Duração sugerida</span>
                    <span class="viagem-valor"><?= $viagem['dias_sugeridos'] ?></span>
                </div>
                <div>
                    <span class="viagem-label">Melhor época</span>
                    <span class="viagem-valor"><?= $viagem['melhor_epoca'] ?></span>
                </div>
                <button type="button" class="btn btn-reservar" data-bs-toggle="modal" data-bs-target="#modalReservar">
                    Reservar Agora
                </button>
            </div>
        </section>

        <section class="detalhes container-margem">
            <div class="descricao px-5">
                <h2 class="titulo">Descrição</h2>
                <p class="text-center"><?= $viagem['descricao'] ?></p>
            </div>
            <div class="turistando my-5">
                <h2 class="titulo">Turistando</h2>
                <div class="cultura-cards"><?php if (!empty($viagem['pontos'])): ?>
                        <?php foreach ($viagem['pontos'] as $ponto): ?>
                            <div class="cultura-card">
                                <img src="<?= $base . $ponto['foto'] ?>" alt="<?= htmlspecialchars($ponto['titulo']) ?>">

                                <div class="cultura-info">
                                    <span class="cultura-tag">
                                        <i class="bi bi-bank2"></i> <?= htmlspecialchars($ponto['categoria']) ?>
                                    </span>

                                    <h4><?= htmlspecialchars($ponto['titulo']) ?></h4>

                                    <p><?= htmlspecialchars($ponto['descricao']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="impacto">
                <div class="viagem-impacto secao-detalhes" id="impacto">
                    <div class="impacto-card">
                        <div class="impacto-texto">
                            <span class="impacto-selo"><i class="bi bi-leaf-fill"></i> Turismo de impacto positivo</span>
                            <h2>Sua viagem também transforma quem vive aqui</h2>
                            <p>
                                <?= $viagem['impacto_positivo'] ?>
                            </p>
                            <ul class="impacto-lista">
                                <?php if (!empty($viagem['impacto_topicos'])): ?>
                                    <?php foreach ($viagem['impacto_topicos'] as $topico): ?>
                                        <li><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($topico) ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="impacto-imagem">
                            <img src="<?= $base . $viagem['impacto_foto'] ?>" alt="Imagem de impacto positivo">
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
                <h3>Pronto para conhecer <?= $viagem['nome'] ?>?</h3>
                <p>Garanta sua passagem e viva essa experiência cultural completa.</p>
                <button type="button" class="btn-reservar btn-reservar-claro" data-bs-toggle="modal" data-bs-target="#modalReservar">
                    Reservar Agora
                </button>
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