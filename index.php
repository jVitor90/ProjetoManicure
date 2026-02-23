<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?err=usuario_sessao_invalida");
    exit();
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
        <div class="container-fluid px-4 position-relative">

            <!-- LOGO centralizado -->
            <div class="text-center py-3">
                <a href="./index.php" class="logo fw-bold d-inline-block">Nail Pro</a>
            </div>

            <!-- Ações à direita (Agendar + Dashboard + Dropdown) -->
            <div class="header-right position-absolute top-50 end-0 translate-middle-y d-flex align-items-center gap-2">

                <a href="./Agendamento/index.php" class="btn btn-agendar">Agendar</a>

                <?php if (isset($_SESSION['usuario']['id_tipo']) && $_SESSION['usuario']['id_tipo'] == 1): ?>
                    <a href="./Dashboard/index.php" class="btn btn-agendar">Dashboard</a>
                <?php endif; ?>


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

        <!-- MENU inferior centralizado -->
        <div class="bottom-bar border-top">
            <nav class="py-2">
                <ul class="nav justify-content-center gap-4 mb-0">
                    <li class="nav-item">
                        <a class="nav-link link-nav px-3" href="./Servicos/index.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-nav px-3" href="./Contato/index.php">Contato</a>
                    </li>
                </ul>
            </nav>
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
                        <a href="./Agendamento/index.php" class="btn btn-lg btn-primary btn-schedule">Agendar Horário</a>
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

    <script>
        // Script para preencher o modal de perfil com os dados do usuário
        document.addEventListener('DOMContentLoaded', function() {
            const perfilModal = document.getElementById('perfilModal');

            perfilModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const nome = button.getAttribute('data-nome');
                const sobrenome = button.getAttribute('data-sobrenome');
                const email = button.getAttribute('data-email');
                const telefone = button.getAttribute('data-telefone');
                const ultimoAgendamento = button.getAttribute('data-ultimo-agendamento');
                const criadoEm = button.getAttribute('data-criado-em');

                document.getElementById('modal-nome').textContent = nome + ' ' + sobrenome;
                document.getElementById('modal-email').textContent = email || '—';
                document.getElementById('modal-telefone').textContent = telefone || '—';
                document.getElementById('modal-ultimo-agendamento').textContent = ultimoAgendamento || 'Nenhum agendamento';
                document.getElementById('modal-criado-em').textContent = criadoEm ? new Date(criadoEm).toLocaleDateString('pt-BR') : '—';
            });
        });
    </script>
</body>

</html>