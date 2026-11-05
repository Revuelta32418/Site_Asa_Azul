<div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center border-0 rounded-4 shadow-lg overflow-hidden">
            
            <div class="modal-header border-0 bg-light justify-content-center pt-4 pb-2">
                <div class="icone-logout-wrapper d-flex align-items-center justify-content-center rounded-circle bg-danger-subtle text-danger mb-2" style="width: 60px; height: 60px;">
                    <i class="bi bi-box-arrow-right fs-2"></i>
                </div>
            </div>

            <div class="modal-body px-4 py-2">
                <h5 class="modal-title fw-bold text-dark mb-2" id="modalLogoutLabel">Sair da conta</h5>
                <p class="text-muted small mb-0">Tem certeza de que deseja encerrar sua sessão?</p>
            </div>

            <div class="modal-footer border-0 d-flex flex-column gap-2 p-4 pt-3">
                <!-- Formulário que envia 'logout' para o funcoes.php -->
                <form action="<?= $base ?>php/funcoes.php" method="POST" class="w-100">
                    <button type="submit" name="logout" value="1" class="btn btn-danger w-100 rounded-pill fw-semibold py-2">
                        Sim, sair
                    </button>
                </form>
                
                <button type="button" class="btn btn-outline-secondary w-100 rounded-pill fw-semibold py-2" data-bs-dismiss="modal">
                    Cancelar
                </button>
            </div>

        </div>
    </div>
</div>