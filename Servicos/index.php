<?php
//Verifica se o usuario esta logado:
session_start();
if (!isset($_SESSION['usuario'])) {
    //Caso o usuario esteja logado, retorna ao login.php
    header("Location: login.php?err=usuario_sessao_invaliada");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>

    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header-custom sticky-top bg-white border-bottom">
        <div class="container-fluid px-4 position-relative">

            <!-- LOGO centralizado perfeitamente -->
            <div class="text-center py-3">
                <a href="../index.php" class="logo fw-bold d-inline-block">Nail Pro</a>
            </div>

            <!-- Ações à direita (Agendar + Login) -->
            <div class="header-right position-absolute top-50 end-0 translate-middle-y d-flex align-items-center gap-2">
                <a href="../Agendamento/index.php" class="btn btn-agendar">Agendar</a>
                <a href="../Dashboard/index.php" class="btn btn-agendar">Deshboard</a>


                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Olá, <?= $_SESSION['usuario']['nome'] ?>!
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#perfilModal"
                                data-id="<?= htmlspecialchars($_SESSION['usuario']['id']) ?>"
                                data-nome="<?= htmlspecialchars($_SESSION['usuario']['nome']) ?>"
                                data-sobrenome="<?= htmlspecialchars($_SESSION['usuario']['sobrenome'] ?? '') ?>"
                                data-email="<?= htmlspecialchars($_SESSION['usuario']['email']) ?>"
                                data-telefone="<?= htmlspecialchars($_SESSION['usuario']['telefone'] ?? '') ?>"
                                data-ultimo-agendamento="<?= htmlspecialchars($_SESSION['usuario']['data_ultimo_agendamento'] ?? '') ?>"
                                data-criado-em="<?= htmlspecialchars($_SESSION['usuario']['criado_em'] ?? '') ?>">
                                Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="./admin/sair.php">Sair</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <!-- MENU inferior 100% centralizado -->
        <div class="bottom-bar border-top">
            <nav class="py-2">
                <ul class="nav justify-content-center gap-4 mb-0">
                    <li class="nav-item"><a class="nav-link link-nav px-3" href="../Servicos/index.php">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>
                </ul>
            </nav>
        </div>
    </header>



    <!-- SECTION SERVIÇOS -->

    <section class="portfolio-section py-5">

        <div class="container text-center mb-5">
            <h2 class="fw-bold display-6">
                Nossos <span class="text-rosa">trabalhos</span>
            </h2>

            <p class="text-muted mt-3">
                Cada design é único e feito com carinho.
                Veja alguns dos nossos trabalhos.
            </p>
        </div>

        <!-- CARDS -->
        <div class="container my-5">
            <div class="row g-4">

                <!-- CARD 1 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure em unhas naturais, esmaltação, francesinha decorada.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Manicure com esmaltação</span>
                            <h3>Manicure em unhas naturais, esmaltação, francesinha decorada.</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure tradicional.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Manicure</span>
                            <h3>Manicure tradicional</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure em unhas naturais e esmaltação decorada.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Manicure com esmaltação</span>
                            <h3>Manicure em unhas naturais e esmaltação decorada</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 4 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure com esmaltação tradicional efeito marmorizado.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Manicure com esmaltação </span>
                            <h3>Manicure com esmaltação tradicional efeito marmorizado</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 5 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure com decoração feita à mão.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Manicure com decoração</span>
                            <h3>Manicure com decoração feita à mão</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 6 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure com nail art.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Manicure com nail art</span>
                            <h3>Manicure com decoração(Nail art)</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 7 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Blindagem e esmaltação em gel em unhas naturais.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Blindagem em Gel</span>
                            <h3>Blindagem e esmaltação em gel em unhas naturais</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 8 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Blindagem e esmaltação em gel com decoração.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Blindagem em Gel</span>
                            <h3>Blindagem e esmaltação em gel com decoração</h3>
                        </div>
                    </div>
                </div>

                <!-- CARD 9 -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Cuticulagem de excelência ,esmaltação tradicional e decoração.jpg" alt="">
                        <div class="legenda">
                            <span class="tag">Cuticulagem e esmaltação</span>
                            <h3>Cuticulagem de excelência ,esmaltação tradicional e decoração</h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- FOOTER -->
    <footer class=" bg-light border-top py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold logo text-gradient d-block mb-3">Nail Pro</h5>
                    <p class="text-muted mb-0 small">Cuidando da sua beleza com carinho, qualidade e dedicação.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Contato</h5>
                    <ul class="list-unstyled text-muted small">
                        <li>(11) 90000-0000</li>
                        <li>Rua Exemplo, 123</li>
                        <li>Seg–Sáb: 9h às 19h</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Redes Sociais</h5>
                    <a class="d-block text-muted mb-1" href="#">Instagram</a>
                    <a class="d-block text-muted" href="#">WhatsApp</a>
                </div>
            </div>
            <div class="text-center text-muted pt-3 border-top small">
                © 2025 Nail Pro — Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!-- Modal de Perfil -->
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perfilModalLabel">Meu Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nome:</strong> <span id="modal-nome"></span></p>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Telefone:</strong> <span id="modal-telefone"></span></p>
                    <p><strong>Último Agendamento:</strong> <span id="modal-ultimo-agendamento"></span></p>
                    <p><strong>Cadastro Criado em:</strong> <span id="modal-criado-em"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"></script>
    <script>
        document.querySelectorAll('.horario-btn').forEach(btn => {
            btn.addEventListener('click', function() {

                // OPCIONAL: permitir apenas um horário selecionado
                document.querySelectorAll('.horario-btn').forEach(b => b.classList.remove('selected'));

                // adiciona a classe selecionado
                this.classList.add('selected');
            });
        });
    </script>


</body>

</html>