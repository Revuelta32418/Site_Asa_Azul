<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '../';
require_once($base . "banco/conexao.php");
require_once($base . "banco/viagensDAO.php");

// Proteção: Apenas administradores
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'administrador') {
    header("Location: " . $base . "index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin.php");
    exit();
}

$viagem = buscarViagemPorId($conexao, $id);
if (!$viagem) {
    header("Location: admin.php");
    exit();
}

$hideHeader = true;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul | Editar Viagem</title>
    <link rel="shortcut icon" href="../imagens/arara_com_circulo.png">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilogeral.css">
    <link rel="stylesheet" href="../css/estilocadastrar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        .foto-preview-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .foto-preview-img {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #E0E0E0;
        }
    </style>
</head>

<body>
    <?php
    if (file_exists('../componentes/header.php')) {
        include '../componentes/header.php';
    }
    ?>

    <main>
        <section class="container-margem pagina-cadastro">
            <div class="d-flex justify-content-center align-items-center">
                <h1 class="titulo text-center" style="margin-bottom: 1rem;">Editar Viagem</h1>
            </div>

            <form class="form-cadastro mx-auto rounded-4 p-5" method="POST" action="<?= $base ?>php/funcoes.php" enctype="multipart/form-data">

                <!-- ID da viagem (Oculto) -->
                <input type="hidden" name="viagem_id" value="<?= $viagem['id'] ?>">

                <div class="bloco-form">
                    <h2>Nome da viagem</h2>
                    <div class="campo-grupo">
                        <input type="text" name="nome_viagem" id="nome_viagem" value="<?= htmlspecialchars($viagem['nome']) ?>" required>
                    </div>
                </div>

                <!-- Fotos da viagem com Preview -->
                <div class="bloco-form">
                    <h2>Fotos da viagem (Envie uma nova para substituir)</h2>
                    <div class="grid-fotos">
                        <?php for ($f = 1; $f <= 4; $f++): ?>
                            <?php
                            $fotoAtual = $viagem["foto{$f}"] ?? ($viagem['fotos'][$f - 1] ?? '');
                            ?>
                            <div class="campo-foto">
                                <label for="foto<?= $f ?>">Foto <?= $f ?></label>

                                <?php if (!empty($fotoAtual)): ?>
                                    <div class="foto-preview-container my-2">
                                        <img src="<?= $base . $fotoAtual ?>" class="foto-preview-img" alt="Foto <?= $f ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                    </div>
                                <?php endif; ?>

                                <input type="file" name="foto<?= $f ?>" id="foto<?= $f ?>" accept="image/*">
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Preço, dias, época -->
                <div class="bloco-form">
                    <h2>Preço, dias e época</h2>
                    <div class="linha-3">
                        <div class="campo-grupo">
                            <label for="preco">Preço (R$)</label>
                            <input type="number" step="0.01" name="preco" id="preco" value="<?= $viagem['preco'] ?>" required>
                        </div>
                        <div class="campo-grupo">
                            <label for="dias_sugeridos">Dias sugeridos</label>
                            <input type="number" name="dias_sugeridos" id="dias_sugeridos" value="<?= htmlspecialchars($viagem['dias_sugeridos'] ?? '') ?>">
                        </div>
                        <div class="campo-grupo">
                            <label for="melhor_epoca">Melhor época</label>
                            <input type="text" name="melhor_epoca" id="melhor_epoca" value="<?= htmlspecialchars($viagem['melhor_epoca'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="bloco-form">
                    <h2>Descrição da viagem</h2>
                    <div class="campo-grupo">
                        <textarea name="descricao" id="descricao"><?= htmlspecialchars($viagem['descricao']) ?></textarea>
                    </div>
                </div>

                <!-- Pontos culturais -->
                <div class="bloco-form">
                    <h2>Turistando</h2>

                    <?php for ($p = 1; $p <= 4; $p++): ?>
                        <?php $ponto = $viagem['pontos'][$p - 1] ?? []; ?>
                        <div class="campo-grupo mb-4">
                            <h3 class="h6">Ponto <?= $p ?></h3>

                            <?php if (!empty($ponto['foto'])): ?>
                                <div class="foto-preview-container my-2">
                                    <img src="<?= $base . $ponto['foto'] ?>" class="foto-preview-img" alt="Ponto <?= $p ?>">
                                </div>
                            <?php endif; ?>

                            <label for="ponto<?= $p ?>_foto">Foto (envie uma nova para substituir)</label>
                            <input type="file" name="ponto<?= $p ?>_foto" id="ponto<?= $p ?>_foto" accept="image/*">

                            <label for="ponto<?= $p ?>_categoria">Categoria</label>
                            <input type="text" name="ponto<?= $p ?>_categoria" id="ponto<?= $p ?>_categoria"
                                value="<?= htmlspecialchars($ponto['categoria'] ?? '') ?>">

                            <label for="ponto<?= $p ?>_titulo">Título</label>
                            <input type="text" name="ponto<?= $p ?>_titulo" id="ponto<?= $p ?>_titulo"
                                value="<?= htmlspecialchars($ponto['titulo'] ?? '') ?>">

                            <label for="ponto<?= $p ?>_descricao">Descrição</label>
                            <textarea name="ponto<?= $p ?>_descricao" id="ponto<?= $p ?>_descricao"><?= htmlspecialchars($ponto['descricao'] ?? '') ?></textarea>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Impacto Positivo -->
                <div class="bloco-form">
                    <h2>Impacto Positivo</h2>
                    <div class="campo-foto">
                        <label for="impacto_foto">Foto</label>

                        <div class="foto-preview-container my-2">
                            <img src="<?= $base . $viagem['impacto_foto'] ?>" class="foto-preview-img" alt="Impacto Foto" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                        </div>

                        <input type="file" name="impacto_foto" id="impacto_foto" accept="image/*">
                    </div>

                    <label for="impacto_positivo">Descrição </label>
                    <textarea name="impacto_positivo" id="impacto_positivo"><?= htmlspecialchars($viagem['impacto_positivo']) ?></textarea>

                    <label for="todos-topicos">Tópicos de Impacto Positivo</h2>
                        <div class="campo-grupo topicos">
                            <div id="todos-topicos">
                                <?php for ($t = 1; $t <= 4; $t++): ?>
                                    <input type="text" name="topico<?= $t ?>" id="topico<?= $t ?>"
                                        value="<?= htmlspecialchars($viagem['impacto_topicos'][$t - 1] ?? '') ?>"
                                        placeholder="Tópico <?= $t ?>">
                                <?php endfor; ?>
                            </div>
                        </div>
                </div>

                <!-- Ações do Formulário -->
                <div class="form-cadastro-acoes d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn-cadastro" name="atualizar_viagem">
                        <i class="bi bi-check-circle-fill"></i> Salvar alterações
                    </button>
                </div>
            </form>
        </section>
    </main>

    <?php
    if (file_exists('../componentes/footer.php')) {
        include '../componentes/footer.php';
    }
    ?>
</body>

</html>