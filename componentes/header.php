<header>
        <div class="nav-topo container-margem mx-auto">
            <a href="<?= $base ?>index.php" class="nav-logo">
                <img src="<?=  $base ?>imagens/logo-principal.png" alt="logo Asa Azul">
            </a>

            <button class="menu-toggle btn btn-outline-primary me-2">
                <i class="bi bi-list"></i>
            </button>

            <div class="nav-suporte-group" id="navbarNav">
                <a href="#" class="nav-suporte">
                    <i class="bi bi-compass me-1"></i> Seja um guia
                </a>
                <a href="#" class="nav-suporte">
                    <i class="bi bi-luggage-fill me-1"></i> Minhas viagens
                </a>
                <a href="#" class="nav-suporte">
                    <i class="bi bi-question-circle me-1"></i> Ajuda
                </a>
                <button class="login-btn" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    <i class="bi bi-person-circle"></i> Login
                </button>
            </div>
        </div>


        <div class="nav-abas-wrap">
            <nav class="nav-menu-group container-margem mx-auto">
                <a class="nav-menu <?= $nav === 'passagens' ? 'active' : '' ?>" href="<?=  $base ?>index.php">
                    <i class="bi bi-airplane-fill"></i> Passagens
                </a>
                <a class="nav-menu <?= $nav === 'viagens-curtas' ? 'active' : '' ?>" >
                    <i class="bi bi-car-front"></i> Viagens curtas
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