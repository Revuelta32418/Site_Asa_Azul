<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '../';
require_once($base . "banco/conexao.php");
require_once($base . "banco/reservasDAO.php");

// Se o usuário não estiver logado, redireciona para a home ou exibe aviso
$usuarioId = $_SESSION['usuario_id'] ?? null;
$minhasReservas = $usuarioId ? listarReservasPorUsuario($conexao, $usuarioId) : [];

$hideHeader = true; // Mantém o padrão de exibição do header
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul | Minhas Viagens</title>
    <link rel="shortcut icon" href="<?= $base ?>imagens/arara_com_circulo.png">
    <link rel="stylesheet" href="<?= $base ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?= $base ?>css/estilogeral.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    if (file_exists($base . 'componentes/header.php')) {
        include $base . 'componentes/header.php';
    }
    if (file_exists($base . 'componentes/toast.php')) {
        include $base . 'componentes/toast.php';
    }
    ?>

    <main class="py-5" style="min-height: 75vh;">
        <section class="container-margem mx-auto px-3">
            
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h1 class="titulo text-start mb-1">Minhas Viagens</h1>
                    <p class="text-muted m-0">Acompanhe suas reservas ativas e itinerários agendados.</p>
                </div>
                <a href="<?= $base ?>index.php" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-compass"></i> Explorar mais destinos
                </a>
            </div>

            <?php if (!$usuarioId): ?>
                <!-- Caso o usuário não esteja logado -->
                <div class="card border-0 shadow-sm rounded-4 text-center p-5 my-4">
                    <i class="bi bi-person-lock text-primary display-4 mb-3"></i>
                    <h4 class="fw-bold text-dark">Acesso Restrito</h4>
                    <p class="text-muted">Você precisa estar conectado em uma conta para visualizar suas viagens reservadas.</p>
                    <div class="mt-2">
                        <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalLogin">
                            Fazer Login
                        </button>
                    </div>
                </div>

            <?php elseif (empty($minhasReservas)): ?>
                <!-- Caso o usuário não possua reservas salvas -->
                <div class="card border-0 shadow-sm rounded-4 text-center p-5 my-4">
                    <i class="bi bi-luggage text-muted display-4 mb-3"></i>
                    <h4 class="fw-bold text-secondary">Nenhuma viagem encontrada</h4>
                    <p class="text-muted">Você ainda não reservou nenhuma viagem. Que tal escolher o seu próximo destino?</p>
                    <div class="mt-2">
                        <a href="<?= $base ?>index.php#destaques" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                            Ver Viagens Disponíveis
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- Grid com os Cards das Reservas do Usuário -->
                <div class="row g-4">
                    <?php foreach ($minhasReservas as $reserva): ?>
                        <?php
                            $badgeClass = 'bg-warning text-dark';
                            if ($reserva['status'] === 'confirmada') {
                                $badgeClass = 'bg-success text-white';
                            } elseif ($reserva['status'] === 'cancelada') {
                                $badgeClass = 'bg-danger text-white';
                            }
                        ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                
                                <div class="position-relative">
                                    <img src="<?= !empty($reserva['foto1']) ? $base . $reserva['foto1'] : $base . 'imagens/padrao-viagem.jpg' ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($reserva['nome_viagem']) ?>" 
                                         style="height: 200px; object-fit: cover;">
                                    
                                    <span class="badge position-absolute top-0 end-0 m-3 rounded-pill px-3 py-2 <?= $badgeClass ?>">
                                        <?= ucfirst(htmlspecialchars($reserva['status'])) ?>
                                    </span>
                                </div>

                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="fw-bold text-primary mb-3"><?= htmlspecialchars($reserva['nome_viagem']) ?></h5>
                                        
                                        <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                            <i class="bi bi-calendar-check text-primary"></i>
                                            <span>
                                                <strong>Ida:</strong> <?= date('d/m/Y', strtotime($reserva['ida'])) ?> | 
                                                <strong>Volta:</strong> <?= date('d/m/Y', strtotime($reserva['volta'])) ?>
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                            <i class="bi bi-people text-primary"></i>
                                            <span>
                                                <?= (int)$reserva['num_pessoas'] ?> Pessoa(s) &bull; Estilo: <strong><?= htmlspecialchars($reserva['estilo_viajante']) ?></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="pt-3 border-top d-flex align-items-center justify-content-between mt-3">
                                        <div>
                                            <span class="text-muted small d-block">Valor Estimado</span>
                                            <strong class="text-success fs-5">R$ <?= number_format($reserva['preco'], 2, ',', '.') ?></strong>
                                        </div>
                                        <a href="<?= $base ?>paginas/paginapadraoviagens.php?id=<?= $reserva['viagem_id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            Ver Destino
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </section>
    </main>

    <?php
    if (file_exists($base . 'componentes/footer.php')) {
        include $base . 'componentes/footer.php';
    }
    ?>

    <script src="<?= $base ?>js/bootstrap.js"></script>
    <script src="<?= $base ?>js/jsgeral.js"></script>
</body>

</html>