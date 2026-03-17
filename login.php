<?php
// session_start();
// if(!isset($_SESSION['usuario.logado'])){ header("Location: login.php?err=usuario_sessao_invalida"); exit(); }
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login / Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>

    <!--  PAINEL ESQUERDO-->
    <div class="panel-brand">
        <div class="brand-blob brand-blob-1"></div>
        <div class="brand-blob brand-blob-2"></div>

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
        </div>
    </div>

    <!-- PAINEL DIREITO -->
    <div class="panel-form">
        <div class="form-shell">
            <div class="form-head">
                <span class="form-eyebrow">Bem-vinda de volta</span>
                <h1 id="titulo">Entrar</h1>
            </div>

            <div class="form-container">

                <!-- LOGIN  -->
                <div class="form-wrapper active" id="loginForm">
                    <form id="formLogin" action="./actions/usuario_logar.php" method="POST" novalidate>

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

                        <div style="margin-bottom: 28px; margin-top: 8px; text-align: right;">
                            <a href="#" class="toggle-link" style="font-weight:500; font-size:13px;">Esqueci minha senha</a>
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

                <!--  CADASTRO  -->
                <div class="form-wrapper" id="cadastroForm">
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

                        <button type="submit" class="btn btn-custom mb-4">
                            Criar conta <i class="bi bi-arrow-right ms-2"></i>
                        </button>

                        <div class="form-divider">ou</div>

                        <p class="text-center" style="font-size:14px; color:var(--color-text-muted);">
                            Já tem uma conta?
                            <a href="#" class="toggle-link ms-1" id="mostrarLogin">Entrar agora</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/imask"></script>

    <script>
        $(document).ready(function() {

            // Troca entre login e cadastro
            $("#mostrarCadastro").click(function(e) {
                e.preventDefault();
                $("#loginForm").removeClass("active");
                $("#cadastroForm").addClass("active");
                $(".form-eyebrow").text("Crie sua conta gratuita");
                $("#titulo").fadeOut(200, function() {
                    $(this).text("Cadastro").fadeIn(200);
                });
            });

            $("#mostrarLogin").click(function(e) {
                e.preventDefault();
                $("#cadastroForm").removeClass("active");
                $("#loginForm").addClass("active");
                $(".form-eyebrow").text("Bem-vinda de volta");
                $("#titulo").fadeOut(200, function() {
                    $(this).text("Entrar").fadeIn(200);
                });
            });

            // Toggle senha (olho)
            $(".toggle-pass").click(function() {
                const targetId = $(this).data("target");
                const input = $("#" + targetId);
                const icon = $(this).find("i");

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    icon.removeClass("bi-eye").addClass("bi-eye-slash");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("bi-eye-slash").addClass("bi-eye");
                }
            });

            // Validação em tempo real das senhas
            $("#senhaCad, #confirmaSenhaCad").on("keyup blur", validarSenhas);

            $("#formCadastro").on("submit", function(e) {
                if (!validarSenhas()) {
                    e.preventDefault();
                    $("#confirmaSenhaCad").focus();
                }
            });

        });

        // Máscara de telefone
        document.addEventListener('DOMContentLoaded', function() {
            IMask(document.getElementById('telefoneCad'), {
                mask: '(00) 00000-0000'
            });
        });
    </script>

    <?php include_once './includes/alerts_includes.php'; ?>
</body>

</html>