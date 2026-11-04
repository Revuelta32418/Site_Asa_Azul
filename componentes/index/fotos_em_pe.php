<section id="top" class="container-margem">
    <h2 class="titulo">Top 4 viagens preferidas</h2>
    <div class="galeriaTop">

        <?php if (!empty($topViagens)): ?>
            <?php foreach ($topViagens as $v): ?>
                <?php 
                    // Extrai apenas o nome da cidade antes do hífen
                    $partesNome = explode(' - ', $v['nome']);
                    $nomeCidade = trim($partesNome[0]);
                ?>
                <a href="<?= $base ?>paginas/paginapadraoviagens.php?id=<?= $v['id'] ?>" class="cardTop text-decoration-none">
                    <img src="<?= !empty($v['foto1']) ? $base . $v['foto1'] : $base . 'imagens/padrao-viagem.jpg' ?>" 
                         alt="<?= htmlspecialchars($nomeCidade) ?>">
                    <div class="hero-foto-overlay">
                        <span><?= htmlspecialchars($nomeCidade) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center py-4 w-100">Nenhuma viagem em destaque no momento.</p>
        <?php endif; ?>

    </div>
</section>