<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '../';
require_once($base . "banco/conexao.php");
require_once($base . "banco/viagensDAO.php");
require_once($base . "banco/usuariosDAO.php");

// Proteção da página: Apenas administradores podem acessar
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'administrador') {
    header("Location: " . $base . "index.php");
    exit();
}

$hideHeader = true;
$viagens = listarViagens($conexao);
$usuarios = listarUsuarios($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul | Central de administração</title>
    <link rel="shortcut icon" href="../imagens/arara_com_circulo.png">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilogeral.css">
    <link rel="stylesheet" href="../css/estiloadmin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    if (file_exists('../componentes/header.php')) {
        include '../componentes/header.php';
    }

    if (file_exists('../componentes/modaleditarusuario.php')) {
        include '../componentes/modaleditarusuario.php';
    }

    if (file_exists('../componentes/toast.php')) {
        include '../componentes/toast.php';
    }
    ?>

    <main class="admin-dashboard">
        <section class="container-margem">

            <!-- Cabeçalho do Painel -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h1 class="titulo text-start mb-1">Central de Administração</h1>
                    <p class="text-muted m-0">Gerencie viagens, solicitações de guias e roteiros cadastrados.</p>
                </div>
                <a href="cadastrar.php" class="btn-criar-viagem">
                    <i class="bi bi-plus-circle-fill"></i> Nova Viagem
                </a>
            </div>

            <!-- Cards de Métricas (KPIs) -->
            <div class="row g-3 mb-5">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="admin-card-kpi">
                        <div class="admin-card-icon">
                            <i class="bi bi-compass-fill"></i>
                        </div>
                        <div class="admin-kpi-info">
                            <h3><?= count($viagens) ?></h3>
                            <p>Viagens Ativas</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="admin-card-kpi">
                        <div class="admin-card-icon" style="background-color: #E8F5E9; color: #2E7D32;">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div class="admin-kpi-info">
                            <h3>2</h3>
                            <p>Pedidos para Guia</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="admin-card-kpi">
                        <div class="admin-card-icon" style="background-color: #FFF8E1; color: #F57F17;">
                            <i class="bi bi-map-fill"></i>
                        </div>
                        <div class="admin-kpi-info">
                            <h3>1</h3>
                            <p>Viagens Pendentes</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="admin-card-kpi">
                        <div class="admin-card-icon" style="background-color: #F3E5F5; color: #7B1FA2;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="admin-kpi-info">
                            <h3><?= count($usuarios) ?></h3>
                            <p>Usuários Totais</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navegação por Abas -->
            <ul class="nav admin-nav-tabs mb-4" id="adminTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="viagens-tab" data-bs-toggle="tab" data-bs-target="#tab-viagens" type="button">
                        <i class="bi bi-airplane-fill me-1"></i> Viagens
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="pedidos-guias-tab" data-bs-toggle="tab" data-bs-target="#tab-pedidos-guias" type="button">
                        <i class="bi bi-person-check-fill me-1"></i> Pedidos para Guia <span class="badge bg-danger ms-1">2</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="viagens-pendentes-tab" data-bs-toggle="tab" data-bs-target="#tab-viagens-pendentes" type="button">
                        <i class="bi bi-journal-text me-1"></i> Viagensn pendentes <span class="badge bg-warning text-dark ms-1">1</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#tab-usuarios" type="button">
                        <i class="bi bi-people-fill me-1"></i> Gerenciar Usuários
                    </button>
                </li>
            </ul>

            <!-- Conteúdo das Abas -->
            <div class="tab-content" id="adminTabsContent">

                <!-- Aba 1: Viagens -->
                <div class="tab-pane fade show active" id="tab-viagens">
                    <div class="admin-table-card">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Viagem</th>
                                        <th>Autor / Criador</th>
                                        <th>Preço</th>
                                        <th>Duração</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($viagens)): ?>
                                        <?php foreach ($viagens as $v): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <?php if (!empty($v['foto1'])): ?>
                                                            <img src="<?= $base . $v['foto1'] ?>" alt="<?= htmlspecialchars($v['nome']) ?>" style="width: 48px; height: 48px; border-radius: 10px; object-fit: cover;">
                                                        <?php endif; ?>
                                                        <div>
                                                            <strong style="color: var(--azul-escuro);"><?= htmlspecialchars($v['nome']) ?></strong>
                                                            <br>
                                                            <small class="text-muted">ID: #<?= $v['id'] ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($v['criado_por'] ?? 'Sistema') ?></td>
                                                <td><strong>R$ <?= number_format($v['preco'], 2, ',', '.') ?></strong></td>
                                                <td><?= htmlspecialchars($v['dias_sugeridos'] ?? 'N/A') ?> dias</td>
                                                <td class="text-end">
                                                    <a href="paginapadraoviagens.php?id=<?= $v['id'] ?>" class="btn-acao bg-light text-dark" title="Visualizar">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="editarviagem.php?id=<?= $v['id'] ?>" class="btn-acao bg-warning bg-opacity-25 text-warning" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="<?= $base ?>php/funcoes.php" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Excluir a viagem <?= htmlspecialchars($v['nome'], ENT_QUOTES) ?>? Essa ação não pode ser desfeita.');">
                                                        <input type="hidden" name="viagem_id" value="<?= $v['id'] ?>">
                                                        <button type="submit" name="excluir_viagem"
                                                            class="btn-acao bg-danger bg-opacity-10 text-danger" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                Nenhuma viagem cadastrada ainda.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Aba 2: Pedidos para virar Guia -->
                <div class="tab-pane fade" id="tab-pedidos-guias">
                    <div class="admin-table-card">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Solicitante</th>
                                        <th>E-mail</th>
                                        <th>Especialidade / Região</th>
                                        <th>Status</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Carlos Eduardo</strong></td>
                                        <td>carlos.guia@email.com</td>
                                        <td>História & Cultura (Salvador - BA)</td>
                                        <td><span class="badge-status badge-pendente">Pendente</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-success rounded-pill px-3 me-1">
                                                <i class="bi bi-check-lg"></i> Aprovar
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                Recusar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Aba 3: Aprovação de Roteiros de Guias -->
                <div class="tab-pane fade" id="tab-roteiros">
                    <div class="admin-table-card">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Título do Roteiro</th>
                                        <th>Guia Autor</th>
                                        <th>Destino</th>
                                        <th>Status</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Trilha Cultural do Pelourinho</strong></td>
                                        <td>Carlos Eduardo</td>
                                        <td>Salvador - BA</td>
                                        <td><span class="badge-status badge-pendente">Aguardando Revisão</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-primary rounded-pill px-3 me-1">
                                                <i class="bi bi-search"></i> Revisar
                                            </button>
                                            <button class="btn btn-sm btn-success rounded-pill px-3">
                                                Aprovar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Aba 4: Gerenciar Usuários -->
                <div class="tab-pane fade" id="tab-usuarios">
                    <div class="admin-table-card">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Tipo de Usuário</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($usuarios)): ?>
                                        <?php foreach ($usuarios as $u): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($u['nome']) ?></strong></td>
                                                <td><?= htmlspecialchars($u['email']) ?></td>
                                                <td>
                                                    <span class="badge-status badge-tipo">
                                                        <?= ucfirst(htmlspecialchars($u['tipo'] ?? 'cliente')) ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn-acao bg-warning bg-opacity-25 text-warning" title="Editar"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                                                        data-id="<?= $u['id'] ?>"
                                                        data-nome="<?= htmlspecialchars($u['nome']) ?>"
                                                        data-email="<?= htmlspecialchars($u['email']) ?>"
                                                        data-tipo="<?= htmlspecialchars($u['tipo'] ?? 'cliente') ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <?php if ($u['id'] != ($_SESSION['usuario_id'] ?? 0)): ?>
                                                        <form action="<?= $base ?>php/funcoes.php" method="POST" class="d-inline"
                                                            onsubmit="return confirm('Excluir o usuário <?= htmlspecialchars($u['nome'], ENT_QUOTES) ?>? Essa ação não pode ser desfeita.');">
                                                            <input type="hidden" name="usuario_id" value="<?= $u['id'] ?>">
                                                            <button type="submit" name="excluir_usuario"
                                                                class="btn-acao bg-danger bg-opacity-10 text-danger" title="Excluir">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Nenhum usuário encontrado.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <?php
    if (file_exists('../componentes/footer.php')) {
        include '../componentes/footer.php';
    }
    ?>

    <script src="../js/bootstrap.js"></script>
    <script src="../js/jsgeral.js"></script>
    <script>
        document.getElementById('modalEditarUsuario').addEventListener('show.bs.modal', function(event) {
            const botao = event.relatedTarget; // o botão que foi clicado
            document.getElementById('editId').value = botao.dataset.id;
            document.getElementById('editNome').value = botao.dataset.nome;
            document.getElementById('editEmail').value = botao.dataset.email;
            document.getElementById('editTipo').value = botao.dataset.tipo;
            document.getElementById('editSenha').value = '';
        });
    </script>
</body>

</html>