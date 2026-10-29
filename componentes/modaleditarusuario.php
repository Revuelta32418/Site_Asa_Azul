<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            <div class="login-modal-header">
                <img src="<?= $base ?>imagens/logo-principal.png" alt="logo Asa Azul" class="login-logo">
                <h3 id="modalTitulo">Editar Usuário</h3>
                <p id="modalSubtitulo">Edite algumas informações sobre o usuário.</p>
            </div>

            <form class="login-form" action="<?= $base ?>php/funcoes.php" method="POST" id="formEditar">
                <input type="hidden" name="usuario_id" id="editId">

                <div class="mb-3">
                    <label for="editNome" class="form-label">Nome completo</label>
                    <input type="text" class="form-control" id="editNome" name="editNome" required>
                </div>

                <div class="mb-3">
                    <label for="editEmail" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="editEmail" name="editEmail" required>
                </div>

                <div class="mb-3">
                    <label for="editSenha" class="form-label">Nova senha</label>
                    <input type="password" class="form-control" id="editSenha" name="editSenha"
                        placeholder="Deixe em branco para manter a atual">
                </div>
                
                <?php if($_SESSION['usuario_tipo'] == "administrador"):?>
                <div class="mb-3">
                    <label for="editTipo" class="form-label">Tipo de usuário</label>
                    <select class="form-select" name="editTipo" id="editTipo">
                        <option value="cliente">Cliente</option>
                        <option value="guia">Guia</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
                <?php endif; ?>

                <button type="submit" name="editar_usuario" class="btn-entrar">Salvar alterações</button>
            </form>
        </div>
    </div>
</div>