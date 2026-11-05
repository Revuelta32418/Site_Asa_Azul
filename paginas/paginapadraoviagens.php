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

$categorias = [
    'historico'       => ['label' => 'Patrimônio histórico', 'icone' => 'bi-bank2'],
    'musical'         => ['label' => 'Tradição musical',     'icone' => 'bi-music-note-beamed'],
    'artesanato'      => ['label' => 'Artesanato local',     'icone' => 'bi-palette'],
    'gastronomia'     => ['label' => 'Gastronomia',          'icone' => 'bi-egg-fried'],
    'natureza'        => ['label' => 'Natureza',             'icone' => 'bi-tree'],
    'espiritualidade' => ['label' => 'Espiritualidade',      'icone' => 'bi-stars'],
];

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
            <div class="descricao px-md-5">
                <h2 class="titulo">Descrição</h2>
                <div class="texto-colapsavel" id="container-descricao">
                    <p class="text-center text-md-start"><?= $viagem['descricao'] ?></p>
                </div>
                <div class="text-center">
                    <button type="button" class="btn-ver-mais d-md-none" onclick="toggleVerMais(this, 'container-descricao')">
                        <span>Ver mais</span> <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>
            <div class="turistando my-5">
                <h2 class="titulo">Turistando</h2>
                <div class="cultura-cards"><?php if (!empty($viagem['pontos'])): ?>
                        <?php foreach ($viagem['pontos'] as $ponto): ?>
                            <div class="cultura-card">
                                <img src="<?= $base . $ponto['foto'] ?>" alt="<?= htmlspecialchars($ponto['titulo']) ?>">

                                <div class="cultura-info">
                                    <?php
                                                    $cat = $categorias[$ponto['categoria']]
                                                        ?? ['label' => ucfirst($ponto['categoria']), 'icone' => 'bi-geo-alt'];
                                    ?>
                                    <span class="cultura-tag">
                                        <i class="bi <?= $cat['icone'] ?>"></i> <?= htmlspecialchars($cat['label']) ?>
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

                            <div class="texto-colapsavel" id="container-impacto">
                                <p><?= $viagem['impacto_positivo'] ?></p>
                            </div>
                            <div>
                                <button type="button" class="btn-ver-mais d-md-none" onclick="toggleVerMais(this, 'container-impacto')">
                                    <span>Ver mais</span> <i class="bi bi-chevron-down"></i>
                                </button>
                            </div>

                            <ul class="impacto-lista mt-3">
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