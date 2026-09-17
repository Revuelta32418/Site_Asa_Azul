<div class="modal fade" id="modalLogin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            <div class="login-modal-header">
                <img src="<?= $base ?>imagens/logo-principal.png" alt="logo Asa Azul" class="login-logo">
                <h3 id="modalTitulo">Bem-vindo de volta</h3>
                <p id="modalSubtitulo">Entre para acompanhar suas viagens</p>
            </div>

            <form class="login-form" id="formLogin">
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="loginEmail" placeholder="seuemail@exemplo.com"
                        required>
                </div>

                <div class="mb-3">
                    <label for="loginSenha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="loginSenha" placeholder="••••••••" required>
                </div>

                <div class="login-opcoes">
                    <label class="lembrar">
                        <input type="checkbox"> Lembrar de mim
                    </label>
                    <a href="#" class="esqueci">Esqueci minha senha</a>
                </div>

                <button type="submit" class="btn-entrar">Entrar</button>

                <p class="login-cadastro">
                    Ainda não tem conta? <a href="#" id="linkIrCadastro">Cadastre-se</a>
                </p>
            </form>

            <form class="login-form" id="formCadastro" style="display:none;">
                <div class="mb-3">
                    <label for="cadNome" class="form-label">Nome completo</label>
                    <input type="text" class="form-control" id="cadNome" placeholder="Seu nome" required>
                </div>

                <div class="mb-3">
                    <label for="cadEmail" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="cadEmail" placeholder="seuemail@exemplo.com"
                        required>
                </div>

                <div class="mb-3">
                    <label for="cadSenha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="cadSenha" placeholder="••••••••" required>
                </div>

                <div class="mb-3">
                    <label for="cadConfirmarSenha" class="form-label">Confirmar senha</label>
                    <input type="password" class="form-control" id="cadConfirmarSenha" placeholder="••••••••"
                        required>
                </div>

                <button type="submit" class="btn-entrar">Criar conta</button>

                <p class="login-cadastro">
                    Já tem conta? <a href="#" id="linkVoltarLogin">Entrar</a>
                </p>
            </form>

        </div>
    </div>
</div>