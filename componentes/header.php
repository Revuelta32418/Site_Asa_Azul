<header>
    <div class="nav-topo container-margem mx-auto">
        <a href="<?= $base ?>index.php" class="nav-logo">
            <img src="<?= $base ?>imagens/logo-principal.png" alt="logo Asa Azul">
        </a>

        <button class="menu-toggle btn btn-outline-primary me-2">
            <i class="bi bi-list"></i>
        </button>

        <div class="nav-suporte-group" id="navbarNav">
            <a href="<?= $base ?>paginas/admin.php" class="nav-suporte">
                <i class="bi bi-compass me-1"></i> Seja um guia
            </a>
            <a href="#" class="nav-suporte">
                <i class="bi bi-luggage-fill me-1"></i> Minhas viagens
            </a>
            <a href="#" class="nav-suporte">
                <i class="bi bi-question-circle me-1"></i> Ajuda
            </a>
            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <div class="caixa-usuario d-flex align-items-center gap-2 p-2 rounded-pill ms-1">
                    <div class="usuario-avatar rounded-circle d-flex align-items-center justify-content-center small fw-bold">
                        <?= strtoupper(substr($_SESSION['usuario_nome'], 0, 1)) ?>
                    </div>
                    <span class="usuario-nome">
                        <?= htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]) ?>
                    </span>
                    <a href="<?= $base ?>php/logout.php" class="btn-logout d-flex align-items-center justify-content-center small ms-1 text-decoration-none" title="Sair">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
            <?php else: ?>
                <button class="login-btn rounded-pill p-2 text-nowrap border-0 text-white d-flex gap-2" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    <i class="bi bi-person-circle"></i> Login
                </button>
            <?php endif; ?>
        </div>
    </div>


    <div class="nav-abas-wrap" style="display: <?= $hideHeader === true ? 'none' : '' ?>;">
        <nav class="nav-menu-group container-margem mx-auto">
            <a class="nav-menu <?= $nav === 'passagens' ? 'active' : '' ?>" href="<?= $base ?>index.php">
                <i class="bi bi-airplane-fill"></i> Passagens
            </a>
            <a class="nav-menu <?= $nav === 'viagens-digitais' ? 'active' : '' ?>">
                <i class="bi bi-laptop me-1"></i> Viagens digitais
            </a>
            <a class="nav-menu <?= $nav === 'ofertas' ? 'active' : '' ?>">
                <i class="bi bi-tags me-1"></i> Ofertas
            </a>
        </nav>
    </div>
</header>