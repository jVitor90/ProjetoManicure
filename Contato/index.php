<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/indexcontato.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .text-rosa {
            color: #EB6B9C;
        }
    </style>
</head>

<body>
    
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
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown">
                    Login
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                    <li><a class="dropdown-item" href="#">Configurações</a></li>
                    <hr>
                    <li><a class="dropdown-item" href="#">Sair</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- MENU inferior 100% centralizado -->
    <div class="bottom-bar border-top">
        <nav class="py-2">
            <ul class="nav justify-content-center gap-4 mb-0">
                <li class="nav-item"><a class="nav-link link-nav px-3" href="#servicos">Serviços</a></li>      
                <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>
            </ul>
        </nav>
    </div>

</header>
    <!-- ===== SEÇÃO CONTATO  ===== -->
    <section class="py-5 bg-light" id="localizacao-contato">
        <div class="container">
            <h3 class="text-center mb-5 fw-bold">
                <span class="text-dark">Meus</span> <span style="color:#EB6B9C;">Contatos</span>
            </h3>

            <div class="row g-5 align-items-start">
                <!-- MAPA À ESQUERDA -->
                <div class="col-lg-7">
                    <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3675.224284880957!2d-45.38065532376405!3d-22.905096837812323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ccef4bf5496acb%3A0x1f02f159232d9787!2sAv.%20Waldemar%20Marini%2C%20203%20-%20Res.%20Liberdade%2C%20Pindamonhangaba%20-%20SP%2C%2012444-686!5e0!3m2!1spt-BR!2sbr!4v1765475909908!5m2!1spt-BR!2sbr"
                            style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>

                <!-- COLUNA DIREITA: CARDS + BOTÕES EMBAIXO -->
                <div class="col-lg-5">
                    <div class="row g-4">

                        <!-- Card Endereço -->
                        <div class="col-12">
                            <div class="info-card text-center text-md-start">
                                <div class="icon mx-auto mx-md-0">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <h5>Endereço</h5>
                                <p class="mb-0 text-muted small">
                                    Av. Waldemar Marini, 251 - Res. Liberdade<br>
                                    Pindamonhangaba - SP, 12444-699
                                </p>
                            </div>
                        </div>

                        <!-- Card Telefone -->
                        <div class="col-12">
                            <div class="info-card text-center text-md-start">
                                <div class="icon mx-auto mx-md-0">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <h5>Telefone / WhatsApp</h5>
                                <p class="mb-0 text-muted">
                                    <a href="tel:+5512999999999" class="text-decoration-none">(12) 99999-9999</a>
                                </p>
                            </div>
                        </div>

                        <!-- Card Horário -->
                        <div class="col-12">
                            <div class="info-card text-center text-md-start">
                                <div class="icon mx-auto mx-md-0">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <h5>Horário de Funcionamento</h5>
                                <p class="mb-0 text-muted small">
                                    Segunda a Sábado: 9h às 19h<br>
                                    <span class="text-danger">Domingo: Fechado</span>
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Botões logo abaixo dos cards -->
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