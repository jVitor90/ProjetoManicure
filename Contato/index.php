<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="header-custom sticky-top bg-white border-bottom">
    <div class="container-fluid px-4 position-relative">
        <div class="text-center py-3">
            <a href="../index.php" class="logo fw-bold d-inline-block">Nail Pro</a>
        </div>
        <div class="header-right position-absolute top-50 end-0 translate-middle-y d-flex align-items-center gap-2">

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
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>!
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
                            <a class="dropdown-item" href="../admin/sair.php">Sair</a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="../login.php" class="btn btn-agendar">Login/Cadastre-se</a>
            <?php endif; ?>

        </div>
    </div>
    <div class="bottom-bar border-top">
        <nav class="py-2">
            <ul class="nav justify-content-center gap-4 mb-0">
                <li class="nav-item"><a class="nav-link link-nav px-3" href="../Servicos/index.php">Serviços</a></li>
                <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="py-5 bg-light" id="localizacao-contato">
    <div class="container">
        <h3 class="text-center mb-5 fw-bold">
            <span class="text-dark">Meus</span> <span style="color:#EB6B9C;">Contatos</span>
        </h3>
        <div class="row g-5 align-items-start">

            <!-- Mapa — Prefeitura de Moreira César -->
            <div class="col-lg-7">
                <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden">
                    <iframe
                        src="https://maps.google.com/maps?q=Av.+Jos%C3%A9+Augusto+Mesquita,+170,+Moreira+C%C3%A9sar,+Pindamonhangaba,+SP&output=embed"
                        style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Cards de contato -->
            <div class="col-lg-5">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="info-card text-center text-md-start">
                            <div class="icon mx-auto mx-md-0"><i class="bi bi-geo-alt-fill"></i></div>
                            <h5>Endereço</h5>
                            <p class="mb-0 text-muted small">
                                Av. José Augusto Mesquita, 170 - Centro<br>
                                Moreira César - Pindamonhangaba - SP, 12440-010
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-card text-center text-md-start">
                            <div class="icon mx-auto mx-md-0"><i class="bi bi-telephone-fill"></i></div>
                            <h5>Telefone / WhatsApp</h5>
                            <p class="mb-0 text-muted">
                                <a href="tel:+5512999999999" class="text-decoration-none">(12) 99999-9999</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-card text-center text-md-start">
                            <div class="icon mx-auto mx-md-0"><i class="bi bi-clock-fill"></i></div>
                            <h5>Horário de Funcionamento</h5>
                            <p class="mb-0 text-muted small">
                                Segunda a Sábado: 9h às 19h<br>
                                <span class="text-danger">Domingo: Fechado</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="https://wa.me/5512999999999" target="_blank" class="btn-contato-wa">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://instagram.com/seu_perfil" target="_blank" class="btn-contato-ig">
                        <i class="bi bi-instagram"></i> Instagram
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const btnAgendar = document.getElementById('btn-agendar-header');
    if (btnAgendar) {
        btnAgendar.addEventListener('click', function (e) {
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
            }).then(function (result) {
                if (result.isConfirmed) window.location.href = '../login.php';
            });
        });
    }

    const perfilModal = document.getElementById('perfilModal');
    if (perfilModal) {
        perfilModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('modal-nome').textContent =
                btn.getAttribute('data-nome') + ' ' + btn.getAttribute('data-sobrenome');
            document.getElementById('modal-email').textContent =
                btn.getAttribute('data-email') || '—';
            document.getElementById('modal-telefone').textContent =
                btn.getAttribute('data-telefone') || '—';
            document.getElementById('modal-ultimo-agendamento').textContent =
                btn.getAttribute('data-ultimo-agendamento') || 'Nenhum agendamento';
            const criadoEm = btn.getAttribute('data-criado-em');
            document.getElementById('modal-criado-em').textContent =
                criadoEm ? new Date(criadoEm).toLocaleDateString('pt-BR') : '—';
        });
    }

});
</script>

</body>
</html>