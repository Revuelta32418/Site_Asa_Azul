<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Modal Reservar Viagem -->
<div class="modal fade" id="modalReservar" tabindex="-1" aria-labelledby="modalReservarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">

            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <div>
                    <h3 class="modal-title fw-bold text-primary mb-1" id="modalReservarLabel">Reservar Viagem</h3>
                    <p class="text-muted small m-0">Destino: <strong id="reservaLocal"><?= htmlspecialchars($viagem['nome'] ?? 'Rio de Janeiro') ?></strong></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body p-4">
                <form action="<?= $base ?>php/funcoes.php" method="POST" id="formReserva">
                    <input type="hidden" name="viagem_id" id="reservaViagemId" value="<?= $viagem['id'] ?? '' ?>">

                    <!-- Datas de Ida e Volta -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="reservaIda" class="form-label fw-semibold">Ida</label>
                            <input type="date" class="form-control rounded-3" id="reservaIda" name="ida" required>
                        </div>
                        <div class="col-6">
                            <label for="reservaVolta" class="form-label fw-semibold">Volta</label>
                            <input type="date" class="form-control rounded-3" id="reservaVolta" name="volta" required>
                        </div>
                    </div>

                    <!-- Nº Pessoas / Crianças / Idade / Idosos -->
                    <div class="row g-2 mb-3">
                        <div class="col-3">
                            <label for="numPessoas" class="form-label fw-semibold text-truncate small" title="Nº Pessoas">Nº Pessoas</label>
                            <input type="number" class="form-control rounded-3 text-center" id="numPessoas" name="num_pessoas" min="1" value="1" required>
                        </div>
                        <div class="col-3">
                            <label for="numCrianças" class="form-label fw-semibold text-truncate small" title="Nº Crianças">Nº Crianças</label>
                            <input type="number" class="form-control rounded-3 text-center" id="numCrianças" name="num_criancas" min="0" value="0">
                        </div>
                        <div class="col-3">
                            <label for="idadeCriancas" class="form-label fw-semibold text-truncate small" title="Idade Crianças">Idade Crianças</label>
                            <input type="text" class="form-control rounded-3 text-center" id="idadeCriancas" name="idade_criancas" placeholder="Ex: 5, 8">
                        </div>
                        <div class="col-3">
                            <label for="numIdosos" class="form-label fw-semibold text-truncate small" title="Nº Idosos">Nº Idosos</label>
                            <input type="number" class="form-control rounded-3 text-center" id="numIdosos" name="num_idosos" min="0" value="0">
                        </div>
                    </div>

                    <!-- Estilo Viajante -->
                    <div class="mb-3">
                        <label for="estiloViajante" class="form-label fw-semibold">Estilo Viajante</label>
                        <select class="form-select rounded-3" id="estiloViajante" name="estilo_viajante" required>
                            <option value="" selected disabled>Selecione o estilo...</option>
                            <option value="Mochilão">Mochilão</option>
                            <option value="AirBnB">AirBnB</option>
                            <option value="Tradicional">Tradicional</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>

                    <!-- Nome Completo -->
                    <div class="mb-3">
                        <label for="reservaNome" class="form-label fw-semibold">Nome Completo</label>
                        <input type="text" class="form-control rounded-3" id="reservaNome" name="nome"
                            value="<?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?>" required placeholder="Digite seu nome completo">
                    </div>

                    <!-- CPF e Telefone -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="reservaCpf" class="form-label fw-semibold">CPF</label>
                            <input type="text" class="form-control rounded-3" id="reservaCpf" name="cpf" required placeholder="000.000.000-00">
                        </div>
                        <div class="col-6">
                            <label for="reservaTelefone" class="form-label fw-semibold">Telefone</label>
                            <input type="tel" class="form-control rounded-3" id="reservaTelefone" name="telefone" required placeholder="(00) 00000-0000">
                        </div>
                    </div>

                    <!-- Ato que quer gastar / Observações -->
                    <div class="mb-3">
                        <label for="reservaObservacao" class="form-label fw-semibold">Ato que quer gastar / Observações</label>
                        <textarea class="form-control rounded-3" id="reservaObservacao" name="observacoes" rows="2" placeholder="Ex: orçamento pretendido, preferências ou detalhes especiais..."></textarea>
                    </div>

                    <!-- Valor Total e Botão Reservar -->
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <div>
                            <span class="text-muted small d-block">Valor Estimado</span>
                            <h4 class="fw-bold text-success mb-0">R$ <span id="reservaPrecoFormatado"><?= number_format($viagem['preco'] ?? 690, 2, ',', '.') ?></span></h4>
                        </div>
                        <button type="submit" name="confirmar_reserva" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">
                            Reservar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>