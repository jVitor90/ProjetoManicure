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
    <link rel="stylesheet" href="./css/login.css">

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