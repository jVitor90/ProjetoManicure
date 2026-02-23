<?php
/* =============================================================
 *  AUTENTICAÇÃO — Verifica se o usuário está logado
 * ============================================================= */
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?err=usuario_sessao_invaliada");
    exit();
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
    <div class="container-fluid px-4 position-relative">

        <!-- Logo centralizado -->
        <div class="text-center py-3">
            <a href="../index.php" class="logo fw-bold d-inline-block">Nail Pro</a>
        </div>

        <!-- Ações à direita: Agendar, Dashboard (admin) e dropdown do usuário -->
        <div class="header-right position-absolute top-50 end-0 translate-middle-y d-flex align-items-center gap-2">
            <a href="../Agendamento/index.php" class="btn btn-agendar">Agendar</a>

            <!-- Botão Dashboard visível apenas para administradores -->
            <?php if (isset($_SESSION['usuario']['id_tipo']) && $_SESSION['usuario']['id_tipo'] == 1): ?>
                <a href="./Dashboard/index.php" class="btn btn-agendar">Dashboard</a>
            <?php endif; ?>

            <!-- Dropdown do usuário logado -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                    Olá, <?= $_SESSION['usuario']['nome'] ?>!
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <!-- Abre o modal de perfil com dados da sessão via data-attributes -->
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
                        <a class="dropdown-item d-flex align-items-center" href="../admin/sair.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Menu de navegação inferior centralizado -->
    <div class="bottom-bar border-top">
        <nav class="py-2">
            <ul class="nav justify-content-center gap-4 mb-0">
                <li class="nav-item"><a class="nav-link link-nav px-3" href="../Servicos/index.php">Serviços</a></li>
                <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>
            </ul>
        </nav>
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
            <input type="hidden" name="servico_id"   id="servico_id">
            <input type="hidden" name="servico_nome" id="servico_nome">
            <input type="hidden" name="preco"        id="preco">
            <input type="hidden" name="duracao"      id="duracao">
            <input type="hidden" name="data"         id="data_hidden">
            <input type="hidden" name="horario"      id="horario_hidden">

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

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Data</label>
                    <input type="date" class="form-control"
                           id="data-agendamento" name="data_visivel"
                           onchange="obterHorarios()">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Horário</label>
                    <!-- Preenchido dinamicamente via AJAX ao selecionar a data -->
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
    erro_ao_agendar:         'Ocorreu um erro ao realizar o agendamento. Tente novamente.',
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
document.addEventListener('DOMContentLoaded', function () {
    const perfilModal = document.getElementById('perfilModal');

    perfilModal.addEventListener('show.bs.modal', function (event) {
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
 *  SERVIÇOS — Seleção de card de serviço
 * ============================================================= */
document.querySelectorAll('.card-servico.selecionavel').forEach(card => {
    card.addEventListener('click', function () {
        // Remove seleção anterior e marca o card clicado
        document.querySelectorAll('.card-servico.selecionavel').forEach(c => c.classList.remove('selecionado'));
        this.classList.add('selecionado');

        // Preenche os campos hidden com os dados do serviço selecionado
        document.getElementById('servico_id').value   = this.dataset.id;
        document.getElementById('servico_nome').value = this.dataset.servico;
        document.getElementById('preco').value        = this.dataset.preco;
        document.getElementById('duracao').value      = this.dataset.tempo;
    });
});


/* =============================================================
 *  HORÁRIOS — Carrega horários disponíveis via AJAX ao mudar data
 * ============================================================= */
function obterHorarios() {
    const dataSelecionada = document.getElementById('data-agendamento').value;
    const horariosDiv     = document.getElementById('horarios');

    horariosDiv.innerHTML = '';
    if (!dataSelecionada) return;

    // Sincroniza o campo hidden com a data visível
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
                btn.type      = 'button';
                btn.classList.add('horario-btn', 'btn');
                btn.textContent = horario.horario.slice(0, 5);
                btn.dataset.id  = horario.id;

                // Ao clicar, seleciona o horário e preenche o campo hidden
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


/* =============================================================
 *  AGENDAMENTO — Validação + confirmação SweetAlert + envio
 * ============================================================= */
document.getElementById('form-agendamento').addEventListener('submit', function (e) {
    e.preventDefault();

    const servicoId   = document.getElementById('servico_id').value.trim();
    const data        = document.getElementById('data_hidden').value.trim();
    const horarioId   = document.getElementById('horario_hidden').value.trim();
    const servicoNome = document.getElementById('servico_nome').value.trim();
    const horarioText = document.querySelector('.horario-btn.selected')?.textContent || '';

    // Validação: serviço selecionado
    if (!servicoId) {
        return Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Selecione um serviço antes de continuar.', confirmButtonColor: '#EB6B9C' });
    }
    // Validação: data selecionada
    if (!data) {
        return Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Escolha uma data válida.', confirmButtonColor: '#EB6B9C' });
    }
    // Validação: horário selecionado
    if (!horarioId) {
        return Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Selecione um horário disponível.', confirmButtonColor: '#EB6B9C' });
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
</script>

</body>
</html>