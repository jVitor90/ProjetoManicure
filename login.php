<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login / Cadastro — Nail Pro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="auth-card">
        <div class="auth-wrapper" id="authWrapper">

            <!-- FORMULÁRIO LOGIN (lado direito por padrão) -->
            <div class="panel-form panel-login">
                <div class="form-shell">
                    <div class="form-head">
                        <span class="form-eyebrow">Bem-vinda de volta</span>
                        <h1 class="form-title">Entrar</h1>
                    </div>

                    <form action="./actions/usuario_logar.php" method="POST" novalidate>

                        <div class="field-group">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="seu@email.com" required>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="form-label">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="senha" id="senhaLogin" placeholder="••••••••" required>
                                <button type="button" class="btn-pass toggle-pass" data-target="senhaLogin">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="field-group" style="text-align: right;">
                            <a href="#" class="toggle-link" style="font-weight: 500; font-size: 13px;">Esqueci minha senha</a>
                        </div>

                        <button type="submit" class="btn btn-custom mb-4">
                            Entrar <i class="bi bi-arrow-right ms-2"></i>
                        </button>

                        <div class="form-divider">ou</div>

                        <p class="text-center" style="font-size:14px; color:var(--color-text-muted);">
                            Ainda não tem conta?
                            <a href="#" class="toggle-link ms-1" id="mostrarCadastro">Criar conta grátis</a>
                        </p>
                    </form>
                </div>
            </div>

            <!-- FORMULÁRIO CADASTRO (lado esquerdo por padrão) -->
            <div class="panel-form panel-cadastro">
                <div class="form-shell">
                    <div class="form-head">
                        <span class="form-eyebrow">Crie sua conta gratuita</span>
                        <h1 class="form-title">Cadastro</h1>
                    </div>

                    <form id="formCadastro" action="./actions/usuario_cadastra.php" method="POST" novalidate>

                        <div class="row g-3 mb-0">
                            <div class="col-6">
                                <div class="field-group-sm">
                                    <label class="form-label">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" name="nome" placeholder="Ana" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="field-group-sm">
                                    <label class="form-label">Sobrenome</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" class="form-control" name="sobrenome" placeholder="Silva" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field-group-sm">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="seu@email.com" required>
                            </div>
                        </div>

                        <div class="field-group-sm">
                            <label class="form-label">Telefone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="tel" class="form-control" id="telefoneCad" name="telefone" placeholder="(00) 00000-0000" required>
                            </div>
                        </div>

                        <div class="field-group-sm">
                            <label class="form-label">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="senha" id="senhaCad" placeholder="Mínimo 6 caracteres" minlength="6" required>
                                <button type="button" class="btn-pass toggle-pass" data-target="senhaCad">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="form-label">Confirmar Senha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="confirmaSenhaCad" placeholder="Repita a senha" required>
                                <button type="button" class="btn-pass toggle-pass" data-target="confirmaSenhaCad">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div id="senhaError" class="senha-error">
                                <i class="bi bi-exclamation-circle me-1"></i>As senhas não coincidem.
                            </div>
                        </div>

                        <div class="form-divider">ou</div>

                        <p class="text-center" style="font-size:14px; color:var(--color-text-muted);">
                            já tem conta?
                            <a href="#" class="toggle-link ms-1" id="mostrarCadastro">Entrar agora</a>
                        </p>

                        <!-- <button type="submit" class="btn btn-custom mb-4">
                            Criar conta <i class="bi bi-arrow-right ms-2"></i>
                        </button> -->
                    </form>
                </div>
            </div>

            <!-- PAINEL ROSA DESLIZANTE -->
            <div class="panel-brand">
                <div class="brand-blob brand-blob-1"></div>
                <div class="brand-blob brand-blob-2"></div>

                <!-- Exibido no modo LOGIN -->
                <div class="brand-content for-login">
                    <div class="brand-logo">Nail Pro</div>
                    <div class="brand-divider"></div>
                    <p class="brand-tagline">Beleza nas<br>pontas dos dedos.</p>
                    <p class="brand-sub">Agende seu horário, gerencie seus serviços e acompanhe tudo em um só lugar.</p>
                    <div class="brand-features">
                        <div class="brand-feature">
                            <div class="brand-feature-icon"><i class="bi bi-calendar-check"></i></div>
                            Agendamento fácil e rápido
                        </div>
                        <div class="brand-feature">
                            <div class="brand-feature-icon"><i class="bi bi-stars"></i></div>
                            Serviços personalizados
                        </div>
                        <div class="brand-feature">
                            <div class="brand-feature-icon"><i class="bi bi-shield-check"></i></div>
                            Dados protegidos e seguros
                        </div>
                        <p class="brand-cta-text">Não tem uma conta?</p>
                        <button class="brand-cta-btn js-para-cadastro">Cadastre-se agora</button>
                    </div>
                </div>

                <!-- Exibido no modo CADASTRO -->
                <div class="brand-content for-cadastro">
                    <div class="brand-logo">Nail Pro</div>
                    <div class="brand-divider"></div>
                    <p class="brand-tagline">Já faz parte<br>da família?</p>
                    <p class="brand-sub">Acesse sua conta e continue gerenciando sua agenda com praticidade.</p>
                    <br>
                    <p class="brand-cta-text">Já tem uma conta?</p>
                    <button class="brand-cta-btn js-para-login">Entrar agora</button>
                </div>
            </div>

        </div><!-- /auth-wrapper -->
    </div><!-- /auth-card -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script>
        // ── Alternância entre Login e Cadastro ──────────────────────────
        const wrapper = document.getElementById('authWrapper');

        function irParaCadastro() {
            wrapper.classList.add('modo-cadastro');
        }

        function irParaLogin() {
            wrapper.classList.remove('modo-cadastro');
        }

        document.querySelectorAll('.js-para-cadastro').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                irParaCadastro();
            });
        });

        document.querySelectorAll('.js-para-login').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                irParaLogin();
            });
        });

        // ── Toggle visibilidade da senha (botão olho) ────────────────────
        document.querySelectorAll('.toggle-pass').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = document.getElementById(this.dataset.target);
                var icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        });

        // ── Validação de confirmação de senha ────────────────────────────
        function validarSenhas() {
            var s1 = document.getElementById('senhaCad').value;
            var s2 = document.getElementById('confirmaSenhaCad').value;
            var err = document.getElementById('senhaError');

            if (s2 && s1 !== s2) {
                err.style.display = 'block';
                return false;
            }

            err.style.display = 'none';
            return true;
        }

        document.getElementById('senhaCad').addEventListener('keyup', validarSenhas);
        document.getElementById('confirmaSenhaCad').addEventListener('keyup', validarSenhas);
        document.getElementById('confirmaSenhaCad').addEventListener('blur', validarSenhas);

        document.getElementById('formCadastro').addEventListener('submit', function(e) {
            if (!validarSenhas()) {
                e.preventDefault();
                document.getElementById('confirmaSenhaCad').focus();
            }
        });

        // ── Máscara de telefone ──────────────────────────────────────────
        IMask(document.getElementById('telefoneCad'), {
            mask: '(00) 00000-0000'
        });
    </script>

    <?php include_once './includes/alerts_includes.php'; ?>
</body>

</html>