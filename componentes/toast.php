<?php
$msg  = $_SESSION['mensagem'] ?? null;
$tipo = $_SESSION['mensagem_tipo'] ?? 'danger';
$abrirModal = $_SESSION['abrir_modal'] ?? null;
unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo'], $_SESSION['abrir_modal']);
?>

<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 2000;">
    <div id="toastAviso" class="toast align-items-center text-bg-<?= htmlspecialchars($tipo) ?> border-0"
        role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><?= htmlspecialchars($msg ?? '') ?></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Fechar"></button>
        </div>
    </div>
</div>

<?php if ($msg): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // mostra o toast
        bootstrap.Toast.getOrCreateInstance(
            document.getElementById('toastAviso'), { delay: 4000 }
        ).show();

        <?php if ($abrirModal): ?>
        // reabre o modal (login ou cadastro)
        var modalEl = document.getElementById('modalLogin');
        if (modalEl) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
            <?php if ($abrirModal === 'cadastro'): ?>
            var link = document.getElementById('linkIrCadastro');
            if (link) link.click();
            <?php endif; ?>
        }
        <?php endif; ?>
    });
</script>
<?php endif; ?>