<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/indexagendamento.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;900&display=swap%22 rel=" stylesheet">
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

    <section>
        <section class="section-box">

            <!-- Escolha o serviço -->
            <h3 class="section-title">
                <i class="bi bi-stars"></i>
                Escolha o serviço
            </h3>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card-servico">
                        <div class="d-flex justify-content-between">
                            <strong>Mãos</strong>
                            <span class="preco">R$ 35</span>
                        </div>
                        <small>1h 30min</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-servico">
                        <div class="d-flex justify-content-between">
                            <strong>Pés</strong>
                            <span class="preco">R$ 35</span>
                        </div>
                        <small>1h 30min</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-servico">
                        <div class="d-flex justify-content-between">
                            <strong>Mãos e Pés</strong>
                            <span class="preco">R$ 60</span>
                        </div>
                        <small>2h 30min</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-servico">
                        <div class="d-flex justify-content-between">
                            <strong>Blindagem</strong>
                            <span class="preco">R$ 70</span>
                        </div>
                        <small>1h</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-servico">
                        <div class="d-flex justify-content-between">
                            <strong>Esmaltação em Gel</strong>
                            <span class="preco">R$ 70</span>
                        </div>
                        <small>1h</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-servico">
                        <div class="d-flex justify-content-between">
                            <strong>Blindagem e Esmaltação em Gel</strong>
                            <span class="preco">R$ 120</span>
                        </div>
                        <small>2h</small>
                    </div>
                </div>
            </div>

            <!-- Escolha data e horário -->
            <h3 class="section-title">
                <i class="bi bi-calendar-event"></i>
                Escolha a data e horário
            </h3>

            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <label class="form-label">Data</label>
                    <input type="date" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Horário</label>

                    <div class="d-flex flex-wrap gap-2">
                        <div class="horario-btn">08:00</div>
                        <div class="horario-btn">10:00</div>
                        <div class="horario-btn">14:00</div>
                        <div class="horario-btn">16:00</div>
                        <div class="horario-btn">18:00</div>
                        <div class="horario-btn">20:00</div>

                    </div>
                </div>
            </div>

            <!-- Seus dados -->
            <h3 class="section-title">
                <i class="bi bi-person"></i>
                Seus dados
            </h3>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome completo</label>
                    <input type="text" class="form-control" placeholder="Digite seu nome">
                </div>

                <div class="col-md-6">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" class="form-control" placeholder="(11) 99999-9999">
                </div>
            </div>

            <!-- Botão de confirmar agendamento -->
            <div class="botao-confirmar mt-4">
                <button class="btn btn-primary btn-confirmar">Confirmar Agendamento</button>
            </div>

        </section>

        <!-- Para usar os ícones do Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </section>

    <section></section>


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