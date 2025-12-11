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

    <style>
        body {
            background: linear-gradient(135deg, #fdf2f8 0%, #fceef5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-form {
            background: #ffffff;
            padding: 45px 40px;
            border-radius: 24px;
            border: 3px solid #f8b7d0;
            box-shadow: 0 20px 40px rgba(155, 249, 155, 0.25);
            max-width: 460px;
            width: 100%;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #titulo {
            color: #ba2d65;
            font-weight: 800;
            font-size: 2.6rem;
            margin-bottom: 2rem;
        }

        .form-label {
            color: #ba2d65;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 12px;
            border: 1.5px solid #e9b8d0;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #f99bb9;
            box-shadow: none !important;
        }

        .input-group-text {
            background: transparent;
            border: 1.5px solid #e9b8d0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #ba2d65;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0;
        }

        /* Botão do olho */
        .btn-pass {
            background-color: #f99bb9;
            border: 1.5px solid #e9b8d0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: white;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-pass:hover {
            background-color: #f970a8;
            color: white;
        }

        /* Sombra rosa no foco do grupo inteiro */
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(249, 155, 185, 0.4);
            border-radius: 12px;
        }

        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .btn-pass {
            border-color: #f99bb9;
        }

        .btn-custom {
            background-color: #f99bb9 !important;
            border-color: #f99bb9 !important;
            color: #fff !important;
            font-weight: 600;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #f970a8 !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 155, 185, 0.4);
        }

        .toggle-link {
            color: #f99bb9;
            font-weight: 700;
            text-decoration: none;
            font-size: 1.02rem;
        }

        .toggle-link:hover {
            color: #f970a8;
            text-decoration: underline;
        }

        .senha-error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 6px;
            display: none;
        }

        .form-container {
            position: relative;
            min-height: 500px;
        }

        .form-wrapper {
            position: absolute;
            top: 0; left: 0; right: 0;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease;
        }

        .form-wrapper.active {
            opacity: 1;
            visibility: visible;
            position: relative;
        }

        @media (max-width: 576px) {
            .card-form {
                margin: 15px;
                padding: 35px 25px;
            }
            #titulo { font-size: 2.3rem; }
        }
    </style>
</head>
<body>

<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">

            <div class="text-center mb-4">
                <h1 id="titulo">Login</h1>
            </div>

            <div class="card-form mx-auto">
                <div class="form-container">

                    <!-- LOGIN -->
                    <div class="form-wrapper active" id="loginForm">
                        <form id="formLogin" action="./actions/usuario_logar.php" method="POST" novalidate>
                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="senha" id="senhaLogin" required>
                                    <button type="button" class="btn-pass toggle-pass" data-target="senhaLogin">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-custom w-100 mb-4">Entrar</button>

                            <p class="text-center text-muted">
                                Não possui conta? <a href="#" class="toggle-link" id="mostrarCadastro">Cadastre-se agora</a>
                            </p>
                        </form>
                    </div>

                    <!-- CADASTRO -->
                    <div class="form-wrapper" id="cadastroForm">
                        <form id="formCadastro" action="./actions/usuario_cadastra.php" method="POST" novalidate>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" name="nome" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Sobrenome</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" class="form-control" name="sobrenome" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" id="telefoneCad" name="telefone" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="senha" id="senhaCad" minlength="6" required>
                                    <button type="button" class="btn-pass toggle-pass" data-target="senhaCad">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Confirmar Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="confirmaSenhaCad" required>
                                    <button type="button" class="btn-pass toggle-pass" data-target="confirmaSenhaCad">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div id="senhaError" class="senha-error">
                                    As senhas não coincidem.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-custom w-100 mb-4">Criar conta</button>

                            <p class="text-center text-muted">
                                Já possui conta? <a href="#" class="toggle-link" id="mostrarLogin">Entrar agora</a>
                            </p>
                        </form>
                    </div>

                </div>
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
        $("#titulo").fadeOut(200, function() {
            $(this).text("Cadastro").fadeIn(200);
        });
    });

    $("#mostrarLogin").click(function(e) {
        e.preventDefault();
        $("#cadastroForm").removeClass("active");
        $("#loginForm").addClass("active");
        $("#titulo").fadeOut(200, function() {
            $(this).text("Login").fadeIn(200);
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
    function validarSenhas() {
        const senha = $("#senhaCad").val();
        const confirma = $("#confirmaSenhaCad").val();

        if (senha === "" || confirma === "") {
            $("#senhaError").hide();
            $("#confirmaSenhaCad")[0].setCustomValidity("");
            return true;
        }

        if (senha !== confirma) {
            $("#senhaError").show();
            $("#confirmaSenhaCad")[0].setCustomValidity("Senhas não coincidem");
            return false;
        } else {
            $("#senhaError").hide();
            $("#confirmaSenhaCad")[0].setCustomValidity("");
            return true;
        }
    }

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