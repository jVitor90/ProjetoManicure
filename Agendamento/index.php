<?php
/* =============================================================
 *  AUTENTICAÇÃO — Verifica se o usuário está logado
 * ============================================================= */
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php?err=usuario_sessao_invaliada");
    exit();
}

/* =============================================================
 * DADOS DO USUÁRIO — Atualiza a data do último agendamento para o usuário logado
 * ============================================================= */
if (isset($_SESSION['usuario']['id'])) {
    require_once('../classes/agendamento_class.php');

    $agendamento = new Agendamento();
    $_SESSION['usuario']['data_ultimo_agendamento'] = $agendamento->UltimoAgendamentoPorUsuario($_SESSION['usuario']['id']);
}

/* =============================================================
 *  DEPENDÊNCIAS — Carrega a classe de serviços
 * ============================================================= */
require_once('../classes/servicos_class.php');

$servicosObj = new Servicos();
$servicos    = $servicosObj->listarServicos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<!-- ============================================================
     HEAD — Meta, título e dependências CSS/JS
============================================================ -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transforme suas unhas em obras de arte. Manicure profissional em São Paulo com atendimento personalizado e produtos premium.">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <!-- Estilos customizados -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
     SEÇÃO DE AGENDAMENTO — Formulário de escolha de serviço, data e horário
============================================================ -->
    <hero>
        <form action="../actions/agenda_agendar.php" method="POST"
            id="form-agendamento" class="container my-5">

            <div class="section-box">

                <!-- Campos ocultos: preenchidos via JavaScript -->
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
                                    data-servico="<?= htmlspecialchars($servico['nome']) ?>"
                                    data-preco="<?= $servico['valor'] ?>"
                                    data-tempo="<?= htmlspecialchars($servico['duracao']) ?>"
                                    data-id="<?= $servico['id'] ?>">

                                    <div class="d-flex justify-content-between">
                                        <strong><?= htmlspecialchars($servico['nome']) ?></strong>
                                        <span class="preco">R$ <?= number_format($servico['valor'], 2, ',', '.') ?></span>
                                    </div>
                                    <small><?= htmlspecialchars($servico['duracao']) ?> min</small>

                                    <?php if (!empty($servico['descricao'])): ?>
                                        <p class="mb-0 mt-2" style="font-size: 13px; color: #666;">
                                            <?= htmlspecialchars($servico['descricao']) ?>
                                        </p>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Escolha a data e horário -->
                <h3 class="section-title">
                    <i class="bi bi-calendar-event"></i>
                    Escolha a data e horário
                </h3>

                <!-- Campo de Data com calendário customizado -->
                <div class="row g-4 mb-4" style="align-items:flex-start;">
                    <div class="col-md-6" style="position:relative;">
                        <label class="form-label">Data</label>

                        <!-- Trigger -->
                        <div id="agd-cal-trigger" onclick="agdToggleCal()" role="button" tabindex="0"
                            onkeydown="if(event.key==='Enter'||event.key===' ')agdToggleCal()">
                            <i class="bi bi-calendar3" id="agd-cal-icon"></i>
                            <span id="agd-cal-texto">Selecione uma data</span>
                            <i class="bi bi-chevron-down ms-auto" id="agd-cal-chevron"></i>
                        </div>

                        <!-- Dropdown do calendário -->
                        <div id="agd-cal-dropdown">
                            <div id="agd-cal-nav">
                                <button type="button" id="agd-cal-prev" onclick="agdNavMes(-1)">&#8249;</button>
                                <span id="agd-cal-mesano"></span>
                                <button type="button" id="agd-cal-next" onclick="agdNavMes(1)">&#8250;</button>
                            </div>
                            <div id="agd-cal-grade"></div>
                            <div id="agd-cal-footer">
                                <button type="button" onclick="agdLimparData()">Limpar</button>
                                <button type="button" onclick="agdIrHoje()">Hoje</button>
                            </div>
                        </div>
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

            </div>
        </form>
    </hero>
    <!-- /SEÇÃO DE AGENDAMENTO -->


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

    <script>
        /* =============================================================
         *  URL — Lê os parâmetros de retorno ANTES de limpar a URL
         * ============================================================= */
        const cleanUrl = new URL(window.location.href);
        const msgParam = cleanUrl.searchParams.get('msg');
        const errParam = cleanUrl.searchParams.get('err');

        // Limpa os parâmetros da URL sem recarregar a página
        cleanUrl.searchParams.delete('msg');
        cleanUrl.searchParams.delete('err');
        window.history.replaceState({}, '', cleanUrl);

        // Mapeamento de mensagens de erro
        const erros = {
            servico_nao_selecionado: 'Nenhum serviço foi selecionado.',
            horario_nao_selecionado: 'Nenhum horário foi selecionado.',
            erro_ao_agendar: 'Ocorreu um erro ao realizar o agendamento. Tente novamente.',
        };

        // Dispara o SweetAlert conforme o parâmetro recebido
        if (msgParam === 'sucesso') {
            Swal.fire({
                icon: 'success',
                title: 'Agendamento confirmado!',
                text: 'Seu horário foi reservado com sucesso.',
                confirmButtonColor: '#EB6B9C'
            });
        } else if (errParam && erros[errParam]) {
            Swal.fire({
                icon: 'error',
                title: 'Atenção',
                text: erros[errParam],
                confirmButtonColor: '#EB6B9C'
            });
        }


        /* =============================================================
         *  PERFIL — Preenche o modal com dados do usuário logado
         * ============================================================= */
        document.addEventListener('DOMContentLoaded', function() {
            const perfilModal = document.getElementById('perfilModal');

            if (perfilModal) {
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

                    // CORREÇÃO 1: formata a data corretamente, adicionando 'T00:00:00'
                    // para evitar que o JS interprete a data como UTC e subtraia um dia
                    if (ultimoAgendamento) {
                        const dataFormatada = new Date(ultimoAgendamento + 'T00:00:00')
                            .toLocaleDateString('pt-BR');
                        document.getElementById('modal-ultimo-agendamento').textContent = dataFormatada;
                    } else {
                        document.getElementById('modal-ultimo-agendamento').textContent = 'Nenhum agendamento';
                    }

                    document.getElementById('modal-criado-em').textContent = criadoEm ?
                        new Date(criadoEm).toLocaleDateString('pt-BR') :
                        '—';
                });
            }
        });



        /* =============================================================
         *  SERVIÇOS — Seleção de card de serviço
         * ============================================================= */
        document.querySelectorAll('.card-servico.selecionavel').forEach(card => {
            card.addEventListener('click', function() {
                // Remove seleção anterior e marca o card clicado
                document.querySelectorAll('.card-servico.selecionavel').forEach(c => c.classList.remove('selecionado'));
                this.classList.add('selecionado');

                // Preenche os campos hidden com os dados do serviço selecionado
                document.getElementById('servico_id').value = this.dataset.id;
                document.getElementById('servico_nome').value = this.dataset.servico;
                document.getElementById('preco').value = this.dataset.preco;
                document.getElementById('duracao').value = this.dataset.tempo;
            });
        });


        /* =============================================================
         *  AGENDAMENTO — Validação + confirmação SweetAlert + envio
         * ============================================================= */
        document.getElementById('form-agendamento').addEventListener('submit', function(e) {
            e.preventDefault();

            const servicoId = document.getElementById('servico_id').value.trim();
            const data = document.getElementById('data_hidden').value.trim();
            const horarioId = document.getElementById('horario_hidden').value.trim();
            const servicoNome = document.getElementById('servico_nome').value.trim();
            const horarioText = document.querySelector('.horario-btn.selected')?.textContent || '';

            // Validações
            if (!servicoId) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Atenção',
                    text: 'Selecione um serviço antes de continuar.',
                    confirmButtonColor: '#EB6B9C'
                });
            }
            if (!data) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Atenção',
                    text: 'Escolha uma data válida.',
                    confirmButtonColor: '#EB6B9C'
                });
            }
            if (!horarioId) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Atenção',
                    text: 'Selecione um horário disponível.',
                    confirmButtonColor: '#EB6B9C'
                });
            }

            // Confirmação com resumo do agendamento
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

                // Loading enquanto processa
                Swal.fire({
                    title: 'Processando...',
                    text: 'Aguarde enquanto confirmamos seu agendamento',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });

                this.submit();
            });
        });


        /* =============================================================
         *  CALENDÁRIO — Picker customizado de data + carregamento de horários
         * ============================================================= */
        (function() {

            // Nomes dos meses e letras dos dias da semana
            const MESES = [
                'Janeiro', 'Fevereiro', 'Março', 'Abril',
                'Maio', 'Junho', 'Julho', 'Agosto',
                'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ];
            const DIAS_SEMANA = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];

            // Estado atual do calendário
            const hoje = new Date();
            let mesSel = hoje.getMonth();
            let anoSel = hoje.getFullYear();
            let dataSel = null; // string "YYYY-MM-DD"
            let aberto = false;

            // Formata número com zero à esquerda: 9 → "09"
            function pad(n) {
                return String(n).padStart(2, '0');
            }

            // Monta string ISO a partir de ano, mês (0-based) e dia
            function toISO(ano, mes, dia) {
                return `${ano}-${pad(mes + 1)}-${pad(dia)}`;
            }

            // Retorna a data de hoje no formato ISO
            function hojeISO() {
                return toISO(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
            }

            // Verifica se uma data já passou (anterior a hoje)
            function ehPassado(ano, mes, dia) {
                const data = new Date(ano, mes, dia);
                const agora = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
                return data < agora;
            }

            // Desenha o calendário na tela
            function renderizarCalendario() {
                const grade = document.getElementById('agd-cal-grade');
                if (!grade) return;
                grade.innerHTML = '';

                // Cabeçalho: letras dos dias da semana
                DIAS_SEMANA.forEach(letra => {
                    const cel = document.createElement('div');
                    cel.className = 'agd-dia-sem';
                    cel.textContent = letra;
                    grade.appendChild(cel);
                });

                // Células em branco antes do 1º dia do mês
                const primeiroDia = new Date(anoSel, mesSel, 1).getDay();
                for (let i = 0; i < primeiroDia; i++) {
                    grade.appendChild(document.createElement('div'));
                }

                // Botão para cada dia do mês
                const totalDias = new Date(anoSel, mesSel + 1, 0).getDate();
                for (let dia = 1; dia <= totalDias; dia++) {
                    const iso = toISO(anoSel, mesSel, dia);
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'agd-dia';
                    btn.textContent = dia;

                    const passado = ehPassado(anoSel, mesSel, dia);
                    if (passado) btn.classList.add('agd-dia-passado');
                    if (iso === hojeISO()) btn.classList.add('agd-dia-hoje');
                    if (iso === dataSel) btn.classList.add('agd-dia-sel');

                    btn.addEventListener('click', function() {
                        if (passado) return;
                        selecionarData(iso);
                    });

                    grade.appendChild(btn);
                }

                // Atualiza o título: "Março 2026"
                document.getElementById('agd-cal-mesano').textContent = `${MESES[mesSel]} ${anoSel}`;
            }

            // Marca uma data como selecionada e dispara o carregamento de horários
            function selecionarData(iso) {
                dataSel = iso;

                // Sincroniza os campos hidden do formulário
                const inputLegado = document.getElementById('data-agendamento');
                if (inputLegado) inputLegado.value = iso;
                document.getElementById('data_hidden').value = iso;

                // Exibe a data formatada no trigger: "09/03/2026"
                const [ano, mes, dia] = iso.split('-');
                document.getElementById('agd-cal-texto').textContent = `${dia}/${mes}/${ano}`;
                document.getElementById('agd-cal-trigger').classList.add('com-data');

                fecharCalendario();
                renderizarCalendario();
                carregarHorarios(iso);
            }

            // Abre ou fecha o dropdown do calendário
            window.agdToggleCal = function() {
                aberto = !aberto;
                document.getElementById('agd-cal-dropdown').classList.toggle('visivel', aberto);
                document.getElementById('agd-cal-trigger').classList.toggle('aberto', aberto);
                if (aberto) renderizarCalendario();
            };

            // Fecha o dropdown
            function fecharCalendario() {
                aberto = false;
                document.getElementById('agd-cal-dropdown').classList.remove('visivel');
                document.getElementById('agd-cal-trigger').classList.remove('aberto');
            }

            // Fecha ao clicar fora do calendário
            document.addEventListener('click', function(e) {
                if (!aberto) return;
                const trigger = document.getElementById('agd-cal-trigger');
                const dropdown = document.getElementById('agd-cal-dropdown');
                if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                    fecharCalendario();
                }
            });

            // Avança ou volta um mês (direcao: +1 ou -1)
            window.agdNavMes = function(direcao) {
                mesSel += direcao;
                if (mesSel < 0) {
                    mesSel = 11;
                    anoSel--;
                }
                if (mesSel > 11) {
                    mesSel = 0;
                    anoSel++;
                }
                renderizarCalendario();
            };

            // Limpa a data selecionada e os horários
            window.agdLimparData = function() {
                dataSel = null;

                const inputLegado = document.getElementById('data-agendamento');
                if (inputLegado) inputLegado.value = '';
                document.getElementById('data_hidden').value = '';
                document.getElementById('agd-cal-texto').textContent = 'Selecione uma data';
                document.getElementById('agd-cal-trigger').classList.remove('com-data');
                document.getElementById('horarios').innerHTML = '';

                renderizarCalendario();
            };

            // Navega para o mês atual e seleciona hoje
            window.agdIrHoje = function() {
                mesSel = hoje.getMonth();
                anoSel = hoje.getFullYear();
                renderizarCalendario();
                selecionarData(hojeISO());
            };

            // Busca os horários disponíveis para a data via AJAX e monta os botões
            function carregarHorarios(data) {
                const container = document.getElementById('horarios');
                container.innerHTML = '';

                fetch(`../actions/listar_horarios.php?data=${data}`)
                    .then(res => res.json())
                    .then(lista => {
                        if (!lista.length || lista.error) {
                            container.innerHTML = '<p class="text-muted small">Nenhum horário disponível para esta data.</p>';
                            return;
                        }

                        lista.forEach(item => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.textContent = item.horario.slice(0, 5);
                            btn.dataset.id = item.id;
                            btn.classList.add('horario-btn', 'btn');

                            btn.addEventListener('click', () => {
                                document.querySelectorAll('.horario-btn').forEach(b => b.classList.remove('selected'));
                                btn.classList.add('selected');
                                document.getElementById('horario_hidden').value = btn.dataset.id;
                            });

                            container.appendChild(btn);
                        });
                    })
                    .catch(() => {
                        container.innerHTML = '<p class="text-danger small">Erro ao carregar horários.</p>';
                    });
            }

            // Inicializa o calendário assim que o DOM estiver pronto
            document.addEventListener('DOMContentLoaded', renderizarCalendario);

        })();
    </script>

</body>

</html>