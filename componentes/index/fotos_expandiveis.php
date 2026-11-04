<section id="galeria" class="container-margem justify-content-center d-flex my-4">
    <div class="galeria">

        <?php if (!empty($viagens)): ?>
            <?php foreach ($viagens as $v): ?>
                <?php 
                    $partesNome = explode(' - ', $v['nome']);
                    $nomeCidade = trim($partesNome[0]);
                ?>
                <a href="<?= $base ?>paginas/paginapadraoviagens.php?id=<?= $v['id'] ?>" class="cardGaleria text-decoration-none">
                    <img src="<?= !empty($v['foto1']) ? $base . $v['foto1'] : $base . 'imagens/padrao-viagem.jpg' ?>" 
                         alt="<?= htmlspecialchars($nomeCidade) ?>">
                    <div class="info">
                        <h2><?= htmlspecialchars($nomeCidade) ?></h2>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center py-4">Nenhuma viagem cadastrada no momento.</p>
        <?php endif; ?>

    </div>
</section>