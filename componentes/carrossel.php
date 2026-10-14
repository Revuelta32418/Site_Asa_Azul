<?php
if(file_exists($base . "banco/conexao.php")) {
    require_once($base . "banco/conexao.php");
}

if (file_exists($base . "banco/viagensDAO.php")) {
    require_once($base . "banco/viagensDAO.php");
}

$excluirId = $excluirId ?? 0; // na index essa variável não existe, então vira 0
$viagensCarrossel = listarViagens($conexao, 10, $excluirId);
?>

<?php if (!empty($viagensCarrossel)): ?>
<section id="carrossel-cards" class="container-margem my-5">
    <h2 class="titulo mb-4">
        <?= htmlspecialchars($texto) ?>
    </h2>

    <div class="container-carrossel">
        <button class="carrossel-btn anterior">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="carrossel-tunel">
            <div class="carrossel-vagoes">

                <?php foreach ($viagensCarrossel as $v): ?>
                    <div class="cardCarrossel">
                        <div class="cardCarrossel-imagem">
                            <img src="<?= $base . $v['foto1'] ?>" alt="<?= htmlspecialchars($v['nome']) ?>">
                            <span class="cardCarrossel-preco">
                                <small>a partir de</small>
                                R$ <?= number_format($v['preco'], 0, ',', '.') ?>
                            </span>
                        </div>
                        <div class="conteudoCard">
                            <div class="cardCarrossel-topo">
                                <h4><?= htmlspecialchars($v['nome']) ?></h4>
                            </div>
                            <p><?= htmlspecialchars(mb_strimwidth($v['descricao'], 0, 110, '...')) ?></p>
                            <a href="<?= $base ?>paginas/paginapadraoviagens.php?viagem=<?= urlencode($v['slug']) ?>"
                                class="btn btn-primary">Ver destino</a>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <button class="carrossel-btn proximo">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</section>
<?php endif; ?>