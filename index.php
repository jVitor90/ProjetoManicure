<?php
// Inicia a sessão
session_start();

/* =============================================================
 * DADOS DO USUÁRIO — Atualiza a data do último agendamento para o usuário logado
 * ============================================================= */
if (isset($_SESSION['usuario']['id'])) {
    require_once('classes/agendamento_class.php');

    $agendamento = new Agendamento();
    $_SESSION['usuario']['data_ultimo_agendamento'] = $agendamento->UltimoAgendamentoPorUsuario($_SESSION['usuario']['id']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nail Pro - Manicure Profissional em São Paulo</title>
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
</head>

<body>

    <header class="header-custom sticky-top bg-white border-bottom">
        <div class="container-fluid px-4">

            <!-- LINHA SUPERIOR -->
            <div class="d-flex align-items-center justify-content-between py-3 position-relative">

                <!-- Hamburger (só mobile) — estilo Bootstrap padrão -->
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- LOGO centralizado -->
                <a href="./index.php" class="logo fw-bold position-absolute start-50 translate-middle-x">Nail Pro</a>

                <!-- Ações à direita — apenas desktop -->
                <div class="ms-auto d-none d-lg-flex align-items-center gap-2">

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="./Agendamento/index.php" class="btn btn-agendar">Agendar</a>
                    <?php else: ?>
                        <a href="./Agendamento/index.php" class="btn btn-agendar sw-agendar"  id="btn-agendar-header">Agendar</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['usuario']['id_tipo']) && $_SESSION['usuario']['id_tipo'] == 1): ?>
                        <a href="./Dashboard/index.php" class="btn btn-agendar">Dashboard</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>!
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
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
                    <?php else: ?>
                        <a href="./login.php" class="btn btn-agendar">Login/Cadastre-se</a>
                    <?php endif; ?>

                </div>
            </div>

            <!-- COLLAPSE: menu mobile -->
            <div class="collapse d-lg-block border-top" id="navbarMenu">
                <nav class="py-2">
                    <ul class="nav justify-content-center gap-lg-4 mb-0 flex-column flex-lg-row">

                        <li class="nav-item">
                            <a class="nav-link link-nav px-3" href="./Servicos/index.php">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-nav px-3" href="./Contato/index.php">Contato</a>
                        </li>

                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link link-nav px-3" href="./Agendamento/index.php">Agendar</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link link-nav px-3" href="#" id="btn-agendar-mobile">Agendar</a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['usuario']['id_tipo']) && $_SESSION['usuario']['id_tipo'] == 1): ?>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link link-nav px-3" href="./Dashboard/index.php">Dashboard</a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link link-nav px-3" href="#"
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
                            <li class="nav-item d-lg-none">
                                <a class="nav-link link-nav px-3" href="./admin/sair.php">Sair</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link link-nav px-3" href="./login.php">Login/Cadastre-se</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>

        </div>
    </header>

    <!-- HERO -->
    <hero class="hero position-relative d-flex align-items-center">
        <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?w=1920" alt="Manicure" class="hero-img">
        <div class="hero-overlay"></div>

        <div class="container position-relative z-3">
            <div class="row">
                <div class="col-lg-6 hero-content">
                    <span class="badge badge-hero d-inline-block mb-4">5.0 · +500 clientes satisfeitas</span>

                    <h1 class="display-3 fw-bold mb-4">
                        Suas unhas merecem
                        <span class="text-gradient">cuidado especial</span>
                    </h1>

                    <p class="lead mb-5 text-muted">
                        Transforme suas unhas em verdadeiras obras de arte. Atendimento personalizado em São Paulo com os melhores produtos e técnicas do mercado.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-5">
                          <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="./Agendamento/index.php" class="btn btn-agendar">Agendar</a>
                    <?php else: ?>
                        <a href="./login.php" class="btn btn-lg btn-primary btn-schedule sw-agendar">Agendar Horário</a>
                    <?php endif; ?>
                        <a href="./Servicos/index.php" class="btn btn-lg btn-services">Ver Serviços</a>
                    </div>

                    <div class="d-flex gap-4 flex-wrap text-muted small">
                        <span class="indicator"><span class="dot"></span> Agendamento online</span>
                        <span class="indicator"><span class="dot"></span> Produtos premium</span>
                    </div>
                </div>
            </div>
        </div>
    </hero>

    <!-- FOOTER -->
    <footer class="bg-light border-top py-5">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
         /* =============================================================
         *  PERFIL — Preenche o modal com dados do usuário logado
         * ============================================================= */
        document.addEventListener('DOMContentLoaded', function () {
            const perfilModal = document.getElementById('perfilModal');

            if (perfilModal) {
                perfilModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;

                    const nome               = button.getAttribute('data-nome');
                    const sobrenome          = button.getAttribute('data-sobrenome');
                    const email              = button.getAttribute('data-email');
                    const telefone           = button.getAttribute('data-telefone');
                    const ultimoAgendamento  = button.getAttribute('data-ultimo-agendamento');
                    const criadoEm           = button.getAttribute('data-criado-em');

                    document.getElementById('modal-nome').textContent = nome + ' ' + sobrenome;
                    document.getElementById('modal-email').textContent = email || '—';
                    document.getElementById('modal-telefone').textContent = telefone || '—';

                    // CORREÇÃO 1: formata a data corretamente, adicionando 'T00:00:00'
                    // para evitar que o JS interprete a data como UTC e subtraia um dia
                    if (ultimoAgendamento) {
                        const dataFormatada = new Date(ultimoAgendamento + 'T00:00:00')
                            .toLocaleDateString('pt-BR');
                        document.getElementById('modal-ultimo-agendamento').textContent = dataFormatada;
                    } else {
                        document.getElementById('modal-ultimo-agendamento').textContent = 'Nenhum agendamento';
                    }

                    document.getElementById('modal-criado-em').textContent = criadoEm
                        ? new Date(criadoEm).toLocaleDateString('pt-BR')
                        : '—';
                });
                }

            

            //sweetAlert para botões de agendar sem login, seleciona os dois possíveis botões (header e hero) de uma vez
            const botoesAgendar = document.querySelectorAll('#btn-agendar-header, #btn-agendar-hero');

            botoesAgendar.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault(); // impede a navegação imediata

                    Swal.fire({
                        icon: 'info',
                        title: 'Faça login primeiro',
                        text: 'Você precisa estar logado para fazer um agendamento.',
                        confirmButtonText: 'Fazer Login',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#eb6b9b',
                        cancelButtonColor: '#aaa',
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            window.location.href = './login.php';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>