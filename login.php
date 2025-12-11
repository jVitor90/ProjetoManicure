<?php
//Verificar se o usuario esta logado:
    // session_start();
    // if(!isset($_SESSION['usuario.logado'])){
        // Caso o usuario esteja Logado, retorna ao login.php
        // header("Location: login.php?err=usuario_sessao_invalida");
        // exit();
    // }
?>
<!doctype html>
<html lang="pt-br">
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login / Cadastro</title>
 
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
 
    <style>
        body {
            background: linear-gradient(135deg, #f5d3e0 0%, #fce8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
 
        .card-form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            border: 3px solid #F99BB9;
            box-shadow: 0 15px 35px rgba(249, 155, 185, 0.4);
            max-width: 420px;
            width: 100%;
        }
 
        .btn-custom {
            background-color: #F99BB9 !important;
            border-color: #F99BB9 !important;
            color: #000 !important;
            font-weight: 600;
        }
 
        .btn-custom:hover {
            background-color: #f76d9b !important;
            transform: translateY(-2px);
        }
 
        #titulo {
            color: #000;
            font-weight: 800;
        }
 
        .senha-error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
            display: none;
        }
 
        .form-container {
            position: relative;
            min-height: 400px;
        }
 
        .form-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease-in-out;
        }
 
        .form-wrapper.active {
            opacity: 1;
            visibility: visible;
            position: relative;
        }
 
        a.toggle-link {
            color: #F99BB9;
            font-weight: 600;
        }
 
        a.toggle-link:hover {
            color: #f76d9b;
            text-decoration: underline !important;
        }
    </style>
</head>
 
<body>
 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
 
                <div class="text-center mb-4">
                    <h1 class="display-5" id="titulo">Login</h1>
                </div>
 
                <div class="card-form mx-auto">
 
                    <div class="form-container">
 
                        <!-- Formulário de Login -->
                        <div class="form-wrapper active" id="loginForm">
                            <form id="formLogin" action="./actions/usuario_logar.php" method="POST" novalidate>
                                <div class="mb-3">
                                    <label for="emailLogin" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="emailLogin" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="senhaLogin" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="senhaLogin" name="senha" required>
                                </div>
 
                                <button type="submit" class="btn btn-custom w-100 mb-3">Entrar</button>
 
                                <p class="text-center mb-0">
                                    Não possui conta? <a href="#" class="toggle-link" id="mostrarCadastro">Cadastre-se</a>
                                </p>
                            </form>
                        </div>
 
                        <!-- Formulário de Cadastro -->
                        <div class="form-wrapper" id="cadastroForm">
                            <form id="formCadastro" action="./actions/usuario_cadastra.php" method="POST" novalidate>
                                <div class="mb-3">
                                    <label for="nomeCad" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nomeCad" name="nome" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sobrenomeCad" class="form-label">Sobrenome</label>
                                    <input type="text" class="form-control" id="sobrenomeCad" name="sobrenome" required>
                                </div>
 
                                <div class="mb-3">
                                    <label for="emailCad" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="emailCad" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefoneCad" class="form-label">Telefone</label>
                                    <input type="tel" class="form-control" id="telefoneCad" name="telefone" required pattern="[0-9]{11}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)">
                                </div>
                                <div class="mb-3">
                                    <label for="senhaCad" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="senhaCad" name="senha" required minlength="6">
                                </div>
 
                                <div class="mb-3">
                                    <label for="confirmaSenhaCad" class="form-label">Confirmar Senha</label>
                                    <input type="password" class="form-control" id="confirmaSenhaCad" required>
                                    <div id="senhaError" class="senha-error">
                                        As senhas não coincidem. Por favor, digite novamente.
                                    </div>
                                </div>
 
                                <button type="submit" class="btn btn-custom w-100 mb-3" id="btnCadastrar">Cadastrar</button>
 
                                <p class="text-center mb-0">
                                    Já possui conta? <a href="#" class="toggle-link" id="mostrarLogin">Entrar</a>
                                </p>
                            </form>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
 
    <script>
        $(document).ready(function() {
 
            // Troca entre os formulários
            $("#mostrarCadastro").on("click", function(e) {
                e.preventDefault();
                $("#loginForm").removeClass("active");
                $("#cadastroForm").addClass("active");
                $("#titulo").fadeOut(200, function() {
                    $(this).text("Cadastro").fadeIn(200);
                });
            });
 
            $("#mostrarLogin").on("click", function(e) {
                e.preventDefault();
                $("#cadastroForm").removeClass("active");
                $("#loginForm").addClass("active");
                $("#titulo").fadeOut(200, function() {
                    $(this).text("Login").fadeIn(200);
                });
            });
 
            // Validação em tempo real das senhas no cadastro
            const $senhaCad = $("#senhaCad");
            const $confirmaSenhaCad = $("#confirmaSenhaCad");
            const $erroSenha = $("#senhaError");
 
            function validarSenhas() {
                if ($senhaCad.val() === "" || $confirmaSenhaCad.val() === "") {
                    $erroSenha.hide();
                    $confirmaSenhaCad[0].setCustomValidity("");
                    return true;
                }
 
                if ($senhaCad.val() !== $confirmaSenhaCad.val()) {
                    $erroSenha.show();
                    $confirmaSenhaCad[0].setCustomValidity("Senhas não coincidem");
                    return false;
                } else {
                    $erroSenha.hide();
                    $confirmaSenhaCad[0].setCustomValidity("");
                    return true;
                    return true;
                }
            }
 
            $senhaCad.on("keyup blur", validarSenhas);
            $confirmaSenhaCad.on("keyup blur", validarSenhas);
 
            // Impede envio se as senhas não coincidirem
            $("#formCadastro").on("submit", function(e) {
                if (!validarSenhas()) {
                    e.preventDefault();
                    $confirmaSenhaCad.focus();
                }
            });
        });
    </script>
    <?php
    // Inclusão do arquivo de alertas:
    include_once './includes/alerts_includes.php'
    ?>
 
</body>
 
</html>
 
 