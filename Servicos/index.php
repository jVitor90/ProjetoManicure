<?php
/* =============================================================
 *  AUTENTICAÇÃO — Verifica se o usuário está logado
 * ============================================================= */
session_start();

/* =============================================================
 * DADOS DO USUÁRIO — Atualiza a data do último agendamento para o usuário logado
 * ============================================================= */
if (isset($_SESSION['usuario']['id'])) {
    require_once('../classes/agendamento_class.php');

    $agendamento = new Agendamento();
    $_SESSION['usuario']['data_ultimo_agendamento'] = $agendamento->UltimoAgendamentoPorUsuario($_SESSION['usuario']['id']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<!-- ============================================================
     HEAD — Meta, título e dependências CSS
============================================================ -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos customizados -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- ============================================================
     HEADER — Barra de navegação superior fixa
============================================================ -->
    <header class="header-custom sticky-top bg-white border-bottom">
        <div class="container-fluid px-4">

            <div class="d-flex align-items-center justify-content-between py-3 position-relative">

                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a href="../index.php" class="logo fw-bold position-absolute start-50 translate-middle-x">Nail Pro</a>

                <div class="ms-auto d-none d-lg-flex align-items-center gap-2">

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="../Agendamento/index.php" class="btn btn-agendar">Agendar</a>
                    <?php else: ?>
                        <a href="#" class="btn btn-agendar" id="btn-agendar-header">Agendar</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['usuario']['id_tipo']) && $_SESSION['usuario']['id_tipo'] == 1): ?>
                        <a href="../Dashboard/index.php" class="btn btn-agendar">Dashboard</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>!
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#"
                                        data-bs-toggle="modal" data-bs-target="#perfilModal"
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
                                <li><a class="dropdown-item" href="../admin/sair.php">Sair</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="../login.php" class="btn btn-agendar">Login/Cadastre-se</a>
                    <?php endif; ?>

                </div>
            </div>

            <div class="collapse d-lg-block border-top" id="navbarMenu">
                <nav class="py-2">
                    <ul class="nav justify-content-center gap-lg-4 mb-0 flex-column flex-lg-row">
                        <li class="nav-item"><a class="nav-link link-nav px-3" href="../Servicos/index.php">Serviços</a></li>
                        <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>

                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item d-lg-none"><a class="nav-link link-nav px-3" href="../Agendamento/index.php">Agendar</a></li>
                        <?php else: ?>
                            <li class="nav-item d-lg-none"><a class="nav-link link-nav px-3" href="#" id="btn-agendar-mobile">Agendar</a></li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['usuario']['id_tipo']) && $_SESSION['usuario']['id_tipo'] == 1): ?>
                            <li class="nav-item d-lg-none"><a class="nav-link link-nav px-3" href="../Dashboard/index.php">Dashboard</a></li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link link-nav px-3" href="#"
                                    data-bs-toggle="modal" data-bs-target="#perfilModal"
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
                            <li class="nav-item d-lg-none"><a class="nav-link link-nav px-3" href="../admin/sair.php">Sair</a></li>
                        <?php else: ?>
                            <li class="nav-item d-lg-none"><a class="nav-link link-nav px-3" href="../login.php">Login/Cadastre-se</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

        </div>
    </header>
    <!-- /HEADER -->


    <!-- ============================================================
     SEÇÃO SERVIÇOS — Galeria de trabalhos realizados
============================================================ -->
    <section class="portfolio-section py-5">

        <!-- Título da seção -->
        <div class="container text-center mb-5">
            <h2 class="fw-bold display-6">
                Nossos <span class="text-rosa">trabalhos</span>
            </h2>
            <p class="text-muted mt-3">
                Cada design é único e feito com carinho.
                Veja alguns dos nossos trabalhos.
            </p>
        </div>

        <!-- Grid de cards de portfólio -->
        <div class="container my-5">
            <div class="row g-4">

                <!-- Card 1: Manicure com esmaltação -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure em unhas naturais, esmaltação, francesinha decorada.jpg" alt="Manicure em unhas naturais com francesinha decorada">
                        <div class="legenda">
                            <span class="tag">Manicure com esmaltação</span>
                            <h3>Manicure em unhas naturais, esmaltação, francesinha decorada.</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Manicure tradicional -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure tradicional.jpg" alt="Manicure tradicional">
                        <div class="legenda">
                            <span class="tag">Manicure</span>
                            <h3>Manicure tradicional</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Manicure com esmaltação decorada -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure em unhas naturais e esmaltação decorada.jpg" alt="Manicure em unhas naturais e esmaltação decorada">
                        <div class="legenda">
                            <span class="tag">Manicure com esmaltação</span>
                            <h3>Manicure em unhas naturais e esmaltação decorada</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Efeito marmorizado -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure com esmaltação tradicional efeito marmorizado.jpg" alt="Manicure com esmaltação efeito marmorizado">
                        <div class="legenda">
                            <span class="tag">Manicure com esmaltação</span>
                            <h3>Manicure com esmaltação tradicional efeito marmorizado</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Decoração feita à mão -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure com decoração feita à mão.jpg" alt="Manicure com decoração feita à mão">
                        <div class="legenda">
                            <span class="tag">Manicure com decoração</span>
                            <h3>Manicure com decoração feita à mão</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 6: Nail Art -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Manicure com nail art.jpg" alt="Manicure com nail art">
                        <div class="legenda">
                            <span class="tag">Manicure com nail art</span>
                            <h3>Manicure com decoração (Nail art)</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 7: Blindagem em Gel -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Blindagem e esmaltação em gel em unhas naturais.jpg" alt="Blindagem e esmaltação em gel em unhas naturais">
                        <div class="legenda">
                            <span class="tag">Blindagem em Gel</span>
                            <h3>Blindagem e esmaltação em gel em unhas naturais</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 8: Blindagem em Gel com decoração -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Blindagem e esmaltação em gel com decoração.jpg" alt="Blindagem e esmaltação em gel com decoração">
                        <div class="legenda">
                            <span class="tag">Blindagem em Gel</span>
                            <h3>Blindagem e esmaltação em gel com decoração</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 9: Cuticulagem e esmaltação -->
                <div class="col-md-4">
                    <div class="card-unha">
                        <img src="../image/Cuticulagem de excelência ,esmaltação tradicional e decoração.jpg" alt="Cuticulagem de excelência, esmaltação tradicional e decoração">
                        <div class="legenda">
                            <span class="tag">Cuticulagem e esmaltação</span>
                            <h3>Cuticulagem de excelência, esmaltação tradicional e decoração</h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <!-- /SEÇÃO SERVIÇOS -->


    <!-- ============================================================
     FOOTER — Rodapé do site
============================================================ -->
    <footer class="bg-light border-top py-5">
        <div class="container">
            <div class="row">

                <!-- Sobre -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold logo text-gradient d-block mb-3">Nail Pro</h5>
                    <p class="text-muted mb-0 small">Cuidando da sua beleza com carinho, qualidade e dedicação.</p>
                </div>

                <!-- Contato -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Contato</h5>
                    <ul class="list-unstyled text-muted small">
                        <li>(11) 90000-0000</li>
                        <li>Rua Exemplo, 123</li>
                        <li>Seg–Sáb: 9h às 19h</li>
                    </ul>
                </div>

                <!-- Redes Sociais -->
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
    <!-- /FOOTER -->


    <!-- ============================================================
     MODAIS — Agrupados ao final do body
============================================================ -->


    <!-- ============================================================
     MODAL: Perfil do Usuário Logado
============================================================ -->
    <div class="modal fade" id="perfilModal" tabindex="-1"
        aria-labelledby="perfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="perfilModalLabel">Meu Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <p><strong>Nome:</strong> <span id="modal-nome"></span></p>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Telefone:</strong> <span id="modal-telefone"></span></p>
                    <p><strong>Último Agendamento:</strong> <span id="modal-ultimo-agendamento"></span></p>
                    <p><strong>Cadastro Criado em:</strong> <span id="modal-criado-em"></span></p>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- /MODAL: Perfil -->


    <!-- ============================================================
     SCRIPTS — Dependências e lógica JavaScript
============================================================ -->

    <!-- Bootstrap Bundle JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        /* =============================================================
         *  AGENDAR SEM LOGIN — SweetAlert para usuários não logados
         * ============================================================= */
        const btnAgendar = document.getElementById('btn-agendar-header');
        if (btnAgendar) {
            btnAgendar.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Faça login primeiro',
                    text: 'Você precisa estar logado para fazer um agendamento.',
                    confirmButtonText: 'Fazer Login',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#eb6b9b',
                    cancelButtonColor: '#aaa',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = '../login.php';
                    }
                });
            });
        }


        /* =============================================================
         *  PERFIL — Preenche o modal com dados do usuário logado
         * ============================================================= */
        document.addEventListener('DOMContentLoaded', function() {
            const perfilModal = document.getElementById('perfilModal');

            perfilModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                document.getElementById('modal-nome').textContent =
                    button.getAttribute('data-nome') + ' ' + button.getAttribute('data-sobrenome');
                document.getElementById('modal-email').textContent =
                    button.getAttribute('data-email') || '—';
                document.getElementById('modal-telefone').textContent =
                    button.getAttribute('data-telefone') || '—';
                document.getElementById('modal-ultimo-agendamento').textContent =
                    button.getAttribute('data-ultimo-agendamento') || 'Nenhum agendamento';

                const criadoEm = button.getAttribute('data-criado-em');
                document.getElementById('modal-criado-em').textContent =
                    criadoEm ? new Date(criadoEm).toLocaleDateString('pt-BR') : '—';
            });
        });


        /* =============================================================
         *  HORÁRIOS — Seleção de botão de horário (se aplicável)
         * ============================================================= */
        document.querySelectorAll('.horario-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove seleção anterior e marca o botão clicado
                document.querySelectorAll('.horario-btn').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    </script>

</body>

</html>