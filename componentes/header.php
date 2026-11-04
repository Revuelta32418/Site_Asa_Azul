<header>
    <div class="nav-topo container-margem mx-auto">
        <a href="<?= $base ?>index.php" class="nav-logo">
            <img src="<?= $base ?>imagens/logo-principal.png" alt="logo Asa Azul">
        </a>

        <button class="menu-toggle btn btn-outline-primary me-2">
            <i class="bi bi-list"></i>
        </button>

        <div class="nav-suporte-group" id="navbarNav">
            <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'administrador'): ?>
                <a href="<?= $base ?>paginas/minhasviagens.php" class="nav-suporte">
                    <i class="bi bi-luggage-fill me-1"></i> Minhas viagens
                </a>
                <a href="<?= $base ?>paginas/admin.php" class="nav-suporte">
                    <i class="bi bi-gear me-1"></i> Central de administração
                </a>

            <?php elseif (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'guia'): ?>
                <a href="<?= $base ?>paginas/minhasviagens.php" class="nav-suporte">
                    <i class="bi bi-luggage-fill me-1"></i> Minhas viagens
                </a>
                <a href="<?= $base ?>paginas/cadastrar.php" class="nav-suporte">
                    <i class="bi bi-journal-plus me-1"></i> Criar roteiro
                </a>

            <?php else: ?>
                <a href="#" class="nav-suporte">
                    <i class="bi bi-compass me-1"></i> Seja um guia
                </a>
                <a href="<?= $base ?>paginas/minhasviagens.php" class="nav-suporte">
                    <i class="bi bi-luggage-fill me-1"></i> Minhas viagens
                </a>
            <?php endif; ?>

            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <div class="caixa-usuario d-flex align-items-center gap-2 p-2 rounded-pill ms-1">
                    <div class="usuario-avatar rounded-circle d-flex align-items-center justify-content-center small fw-bold">
                        <?= strtoupper(substr($_SESSION['usuario_nome'], 0, 1)) ?>
                    </div>
                    <span class="usuario-nome">
                        <?= htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]) ?>
                    </span>
                    <form action="<?= $base ?>php/funcoes.php" method="POST" class="d-inline">
                        <button type="submit" name="logout"
                            class="btn-logout d-flex align-items-center justify-content-center small ms-1"
                            title="Sair">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <button class="login-btn rounded-pill p-2 text-nowrap border-0 text-white d-flex gap-2" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    <i class="bi bi-person-circle"></i> Login
                </button>
            <?php endif; ?>
        </div>
    </div>
</header>