<div class="modal fade" id="modalSejaGuia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            <div class="login-modal-header">
                <img src="<?= $base ?>imagens/logo-principal.png" alt="logo Asa Azul" class="login-logo">
                <h3>Seja um guia</h3>
                <p>Conte um pouco sobre você. Nossa equipe vai analisar o seu pedido.</p>
            </div>

            <form class="login-form" action="<?= $base ?>php/funcoes.php" method="POST">
                <div class="mb-3">
                    <label for="guiaTelefone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="guiaTelefone" name="guiaTelefone"
                        placeholder="(35) 99999-9999" required>
                </div>

                <div class="mb-3">
                    <label for="guiaRegiao" class="form-label">Cidade / região onde atua</label>
                    <input type="text" class="form-control" id="guiaRegiao" name="guiaRegiao"
                        placeholder="Ex.: Salvador - BA" required>
                </div>

                <div class="mb-3">
                    <label for="guiaEspecialidade" class="form-label">Especialidade</label>
                    <input type="text" class="form-control" id="guiaEspecialidade" name="guiaEspecialidade"
                        placeholder="Ex.: História e cultura afro-brasileira" required>
                </div>

                <div class="mb-3">
                    <label for="guiaExperiencia" class="form-label">Sua experiência</label>
                    <textarea class="form-control" id="guiaExperiencia" name="guiaExperiencia" rows="4"
                        placeholder="Conte como você conhece o lugar e o que pode mostrar aos viajantes" required></textarea>
                </div>

                <button type="submit" name="enviar_pedido_guia" class="btn-entrar">Enviar pedido</button>
            </form>
        </div>
    </div>
</div>