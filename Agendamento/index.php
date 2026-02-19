<?php
require_once('../classes/servicos_class.php');

$servicosObj = new Servicos();
$servicos = $servicosObj->listarServicos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="header-custom sticky-top bg-white border-bottom">
        <div class="container-fluid px-4 position-relative">
            <div class="text-center py-3">
                <a href="../index.php" class="logo fw-bold d-inline-block">Nail Pro</a>
            </div>
            <div class="header-right position-absolute top-50 end-0 translate-middle-y d-flex align-items-center gap-2">
                <a href="../Agendamento/index.php" class="btn btn-agendar">Agendar</a>
                <a href="../Dashboard/index.php" class="btn btn-agendar">Dashboard</a>
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
        <div class="bottom-bar border-top">
            <nav class="py-2">
                <ul class="nav justify-content-center gap-4 mb-0">
                    <li class="nav-item"><a class="nav-link link-nav px-3" href="../Servicos/index.php">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- SEÇÃO DE AGENDAMENTO -->
    <section>
        <form action="../actions/agenda_agendar.php" method="POST" id="form-agendamento" class="container my-5">

            <section class="section-box">

                <!-- Campos Hidden -->
                <input type="hidden" name="servico_id" id="servico_id">
                <input type="hidden" name="servico_nome" id="servico_nome">
                <input type="hidden" name="preco" id="preco">
                <input type="hidden" name="duracao" id="duracao">
                <input type="hidden" name="data" id="data_hidden">
                <input type="hidden" name="horario" id="horario_hidden">

                <!-- Escolha o serviço -->
                <div class="section-box">
                    <h3 class="section-title">
                        <i class="bi bi-brush"></i>
                        Escolha o serviço
                    </h3>
                    <div class="row g-3">
                        <?php foreach ($servicos as $servico): ?>
                            <div class="col-md-6">
                                <div class="card-servico selecionavel"
                                    data-servico="<?php echo htmlspecialchars($servico['nome']); ?>"
                                    data-preco="<?php echo $servico['valor']; ?>"
                                    data-tempo="<?php echo htmlspecialchars($servico['duracao']); ?>"
                                    data-id="<?php echo $servico['id']; ?>">
                                    <div class="d-flex justify-content-between">
                                        <strong><?php echo htmlspecialchars($servico['nome']); ?></strong>
                                        <span class="preco">R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?></span>
                                    </div>
                                    <small><?php echo htmlspecialchars($servico['duracao']); ?> min</small>
                                    <?php if (!empty($servico['descricao'])): ?>
                                        <p class="mb-0 mt-2" style="font-size: 13px; color: #666;">
                                            <?php echo htmlspecialchars($servico['descricao']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                        <input type="date" class="form-control" onchange="obterHorarios()" id="data-agendamento" name="data_visivel">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Horário</label>
                        <div id="horarios" class="d-flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <!-- Botão Confirmar -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-confirmar">
                        <i class="bi bi-check-circle me-2"></i>
                        Confirmar Agendamento
                    </button>
                </div>

            </section>
        </form>
    </section>

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
    <script>
        // SELEÇÃO DE SERVIÇO
        document.querySelectorAll('.card-servico.selecionavel').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.card-servico.selecionavel').forEach(c => c.classList.remove('selecionado'));
                this.classList.add('selecionado');
                document.getElementById('servico_id').value   = this.dataset.id;
                document.getElementById('servico_nome').value = this.dataset.servico;
                document.getElementById('preco').value        = this.dataset.preco;
                document.getElementById('duracao').value      = this.dataset.tempo;
            });
        });

        // CARREGAR HORÁRIOS DISPONÍVEIS
        function obterHorarios() {
            const dataSelecionada = document.getElementById('data-agendamento').value;
            const horariosDiv = document.getElementById('horarios');
            horariosDiv.innerHTML = '';
            if (!dataSelecionada) return;
            document.getElementById('data_hidden').value = dataSelecionada;

            fetch(`../actions/listar_horarios.php?data=${dataSelecionada}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0 || data.error) {
                        horariosDiv.innerHTML = '<p class="text-muted">Nenhum horário disponível para esta data.</p>';
                        return;
                    }
                    data.forEach(horario => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.classList.add('horario-btn', 'btn');
                        btn.textContent = horario.horario.slice(0, 5);
                        btn.dataset.id = horario.id;
                        btn.addEventListener('click', () => {
                            document.querySelectorAll('.horario-btn').forEach(b => b.classList.remove('selected'));
                            btn.classList.add('selected');
                            document.getElementById('horario_hidden').value = btn.dataset.id;
                        });
                        horariosDiv.appendChild(btn);
                    });
                })
                .catch(() => {
                    horariosDiv.innerHTML = '<p class="text-danger">Erro ao carregar horários.</p>';
                });
        }

        // VALIDAÇÃO + CONFIRMAÇÃO + ENVIO COM SWEETALERT
        document.getElementById('form-agendamento').addEventListener('submit', function(e) {
            e.preventDefault();
            const servicoId   = document.getElementById('servico_id').value.trim();
            const data        = document.getElementById('data_hidden').value.trim();
            const horarioId   = document.getElementById('horario_hidden').value.trim();
            const servicoNome = document.getElementById('servico_nome').value.trim();
            const horarioText = document.querySelector('.horario-btn.selected')?.textContent || '';

            if (!servicoId) return Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Selecione um serviço antes de continuar.', confirmButtonColor: '#EB6B9C' });
            if (!data)      return Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Escolha uma data válida.', confirmButtonColor: '#EB6B9C' });
            if (!horarioId) return Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Selecione um horário disponível.', confirmButtonColor: '#EB6B9C' });

            Swal.fire({
                title: 'Confirmar agendamento?',
                html: `<div style="text-align:left; line-height:1.6;">
                    <strong>Serviço:</strong> ${servicoNome}<br>
                    <strong>Data:</strong> ${data.split('-').reverse().join('/')}<br>
                    <strong>Horário:</strong> ${horarioText}
                </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#EB6B9C',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, agendar!',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (!result.isConfirmed) return;
                Swal.fire({ title: 'Processando...', text: 'Aguarde enquanto confirmamos seu agendamento', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
                this.submit();
            });
        });

        // Limpa parâmetros da URL
        const cleanUrl = new URL(window.location.href);
        cleanUrl.searchParams.delete('msg');
        cleanUrl.searchParams.delete('err');
        window.history.replaceState({}, '', cleanUrl);
    </script>
</body>
</html>