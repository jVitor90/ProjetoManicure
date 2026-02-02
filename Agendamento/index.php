<?php
require_once('../classes/servicos_class.php');

$servicosObj = new Servicos();
$servicos = $servicosObj->listarServicos();


// Mensagens de feedback
$mensagem = '';
$tipo_alerta = '';

if (isset($_GET['err'])) {
    $tipo_alerta = 'error';
    if ($_GET['err'] == 'servico_nao_selecionado') {
        $mensagem = 'Por favor, selecione um serviço!';
    } else if ($_GET['err'] == 'horario_nao_selecionado') {
        $mensagem = 'Por favor, selecione um horário!';
    } else if ($_GET['err'] == 'usuario_nao_logado') {
        $mensagem = 'Você precisa estar logado para agendar!';
    } else if ($_GET['err'] == 'horario_ja_agendado') {
        $mensagem = 'Este horário já foi agendado. Por favor, escolha outro.';
    } else if ($_GET['err'] == 'agendamento_falhou') {
        $mensagem = 'Erro ao realizar agendamento. Tente novamente!';
    }
} else if (isset($_GET['msg'])) {
    $tipo_alerta = 'success';
    if ($_GET['msg'] == 'agendamento_realizado') {
        $mensagem = 'Agendamento realizado com sucesso!';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/indexagendamento.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;900&display=swap%22 rel=" stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <li class="nav-item"><a class="nav-link link-nav px-3" href="../Servicos/index.php">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>
                </ul>
            </nav>
        </div>

    </header>

    <section>
        <form action="../actions/agenda_agendar.php" method="POST" id="form-agendamento" class="container my-5">

            <section class="section-box">

                <!-- Campos Hidden para enviar os dados -->
                <input type="hidden" name="servico_id" id="servico_id">
                <input type="hidden" name="servico_nome" id="servico_nome">
                <input type="hidden" name="preco" id="preco">
                <input type="hidden" name="duracao" id="duracao">
                <input type="hidden" name="data" id="data_hidden">
                <input type="hidden" name="horario" id="horario_hidden">

                <!-- Escolha o serviço -->
                <div class="section-box">
                    <h3 class="section-title">
                        <i class="bi bi-scissors"></i>
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

                <!-- Botão de Confirmar Agendamento -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-confirmar">
                        <i class="bi bi-check-circle me-2"></i>
                        Confirmar Agendamento
                    </button>
                </div>

            </section>
        </form>

        <!-- Para usar os ícones do Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"></script>

    <!-- SweetAlert -->
    <?php if (!empty($mensagem)): ?>
        <script>
            <?php if ($tipo_alerta == 'success'): ?>
                Swal.fire({
                    icon: "success",
                    title: "Agendamento Confirmado!",
                    text: "<?php echo $mensagem; ?>",
                    confirmButtonColor: "#EB6B9C",
                    confirmButtonText: "OK",
                    iconColor: "#28a745"
                });
                const url1 = new URL(window.location.href);
                url1.searchParams.delete('msg');
                window.history.replaceState({}, '', url1);
            <?php else: ?>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "<?php echo $mensagem; ?>",
                    confirmButtonColor: "#EB6B9C",
                    confirmButtonText: "Tentar novamente"
                });
                const url2 = new URL(window.location.href);
                url2.searchParams.delete('err');
                window.history.replaceState({}, '', url2);
            <?php endif; ?>
        </script>
    <?php endif; ?>


    <script>
        // ***** SEÇÃO DE SELECIONAR SERVIÇO *****

        // Script para selecionar serviço
        document.querySelectorAll('.card-servico.selecionavel').forEach(card => {
            card.addEventListener('click', function() {
                // Remove seleção anterior
                document.querySelectorAll('.card-servico.selecionavel').forEach(c => {
                    c.classList.remove('selecionado');
                });

                // Adiciona seleção ao card clicado
                this.classList.add('selecionado');

                // Pega os dados do serviço
                const servico = this.dataset.servico;
                const preco = this.dataset.preco;
                const tempo = this.dataset.tempo;
                const id = this.dataset.id;

                // Atualiza os campos hidden do formulário
                document.getElementById('servico_id').value = id;
                document.getElementById('servico_nome').value = servico;
                document.getElementById('preco').value = preco;
                document.getElementById('duracao').value = tempo;

                console.log('Serviço selecionado:', {
                    servico,
                    preco,
                    tempo,
                    id
                });
            });
        });

        // ***** SECÃO DE SELECIONAR HORÁRIO *****

        // Script para selecionar horário
        document.querySelectorAll('.horario-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // OPCIONAL: permitir apenas um horário selecionado
                document.querySelectorAll('.horario-btn').forEach(b => b.classList.remove('selected'));

                // adiciona a classe selecionado
                this.classList.add('selected');

                // Atualiza o campo hidden do horário
                document.getElementById('horario_hidden').value = this.textContent;
            });
        });

        // função para obter os horários disponíveis do servidor:
        function obterHorarios() {
            const horariosDiv = document.getElementById('horarios');
            horariosDiv.innerHTML = ''; // Limpa os horários anteriores

            // obter os horários do servidor joao-uc10/actions/listar_horarios.php?data=<data>
            const dataSelecionada = document.getElementById('data-agendamento').value;

            // Atualiza o campo hidden da data
            document.getElementById('data_hidden').value = dataSelecionada;

            fetch(`../actions/listar_horarios.php?data=${dataSelecionada}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        horariosDiv.innerHTML = '<p>Nenhum horário disponível para esta data.</p>';
                        return;
                    }
                    data.forEach(horario => {
                        const btn = document.createElement('div');
                        btn.classList.add('horario-btn');
                        btn.textContent = horario.horario.slice(0, 5);
                        btn.setAttribute("id-horario", horario.id);
                        btn.addEventListener('click', function() {
                            document.querySelectorAll('.horario-btn').forEach(b => b.classList.remove('selected'));
                            this.classList.add('selected');

                            // Atualiza o campo hidden do horário
                            document.getElementById('horario_hidden').value = this.getAttribute("id-horario");
                        });
                        horariosDiv.appendChild(btn);
                    });
                })
                .catch(error => {
                    console.error('Erro ao obter horários:', error);
                });
        }

        // ***** VALIDAÇÃO DO FORMULÁRIO ANTES DE ENVIAR *****
        document.getElementById('form-agendamento').addEventListener('submit', function(e) {
            // Pega os valores dos campos hidden
            const servicoId = document.getElementById('servico_id').value;
            const data = document.getElementById('data_hidden').value;
            const horario = document.getElementById('horario_hidden').value;

            // Validações
            if (!servicoId) {
                e.preventDefault();
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!",
                    text: "Por favor, selecione um serviço!",
                    confirmButtonColor: "#EB6B9C"
                });
                return false;
            }

            if (!data) {
                e.preventDefault();
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!",
                    text: "Por favor, selecione uma data!",
                    confirmButtonColor: "#EB6B9C"
                });
                return false;
            }

            if (!horario) {
                e.preventDefault();
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!",
                    text: "Por favor, selecione um horário!",
                    confirmButtonColor: "#EB6B9C"
                });
                return false;
            }

            // Se tudo estiver OK, o formulário será enviado
            return true;
        });
    </script>
</body>

</html>