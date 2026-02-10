<?php
//Verifica se o usuario esta logado:
session_start();
if (!isset($_SESSION['usuario'])) {
    //Caso o usuario esteja logado, retorna ao login.php
    header("Location: login.php?err=usuario_sessao_invaliada");
    exit();
}
?>
<?php
require_once('../classes/servicos_class.php');
require_once('../classes/usuario_class.php');

// Buscar serviços do banco
$servicoObj = new Servicos();
$servicos = $servicoObj->ListarServicos();

$usuarios = new Usuario();
$usuarios_listados = $usuarios->ListarTodosUsuarios();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - Nail Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/indexdashboard.css">
    <link rel="stylesheet" href="../css/indexnovoservico.css">
</head>

<body class="bg-white">
    <header class="header-custom sticky-top bg-white">
        <div class="container-fluid px-4">

            <!-- Linha superior: left spacer / logo central / right actions -->
            <div class="header-top d-flex align-items-center justify-content-between py-3">
                <div class="header-left"></div>

                <div class="text-center">
                    <a href="./index.php" class="logo fw-bold d-inline-block">Nail Pro</a>
                </div>

                <div class="header-right d-flex align-items-center gap-2">


                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Olá, <?= $_SESSION['usuario']['nome'] ?>!
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Configurações</a></li>
                            <hr>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="./admin/sair.php">Sair</a>
                            </li>
                        </ul>
                    </div>

                    <!-- botao mobile (aparece só em <lg) -->
                    <button class="navbar-toggler d-lg-none border-0 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>

            <!-- Linha inferior: menu centralizado -->
            <div class="bottom-bar border-top">
                <nav class="py-2">
                    <ul class="nav justify-content-center gap-4 mb-0">
                        <li class="nav-item"><a class="nav-link link-nav px-3" href="#servicos">Serviços</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </header>
    <!-- Modal Lista de Clientes -->
    <div class="modal fade" id="modalListaClientes" tabindex="-1" aria-labelledby="modalListaClientesLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">

                <!-- Header -->
                <div class="modal-header border-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="modalListaClientesLabel">
                            <i class="bi bi-people-fill me-2 text-rosa"></i>Lista de Clientes
                        </h5>
                        <p class="text-muted small mb-0">
                            Visualize e gerencie seus clientes cadastrados
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body pt-0">

                    <!-- Barra superior -->
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">

                        <!-- Busca -->
                        <div class="input-group w-auto flex-grow-1" style="max-width: 320px;">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control" id="buscarCliente" placeholder="Buscar cliente...">
                        </div>

                    </div>

                    <!-- Tabela -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light small">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Último Atendimento</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php foreach ($usuarios_listados as $usuario): ?>
                                    <tr
                                        data-id="<?= htmlspecialchars($usuario['id']) ?>"
                                        data-nome="<?= htmlspecialchars($usuario['nome']) ?>"
                                        data-sobrenome="<?= htmlspecialchars($usuario['sobrenome']) ?>"
                                        data-email="<?= htmlspecialchars($usuario['email']) ?>"
                                        data-telefone="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>"
                                        data-id_tipo="<?= htmlspecialchars($usuario['id_tipo']) ?>">
                                        <td>
                                            <?= htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($usuario['telefone'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                                        <td><?= htmlspecialchars($usuario['data_ultimo_agendamento'] ?? '—') ?></td>

                                        <!-- Botões do form(Editar e excluir) -->
                                        <td class="text-end">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-light me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarCliente"
                                                data-id="<?= $usuario['id'] ?>"
                                                data-nome="<?= htmlspecialchars($usuario['nome']) ?>"
                                                data-sobrenome="<?= htmlspecialchars($usuario['sobrenome']) ?>"
                                                data-email="<?= htmlspecialchars($usuario['email']) ?>"
                                                data-telefone="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>">
                                                <i class="bi bi-pencil"></i> Editar
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-danger btnExcluirCliente"
                                                data-id="<?= $usuario['id'] ?>"
                                                data-nome="<?= htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']) ?>">
                                                <i class="bi bi-trash"></i> Excluir
                                            </button>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINAÇÃO -->
                    <div class="d-flex justify-content-center mt-3">
                        <nav>
                            <ul class="pagination pagination-sm" id="paginacaoClientes"></ul>
                        </nav>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Fechar
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal editar clientes -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header border-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="modalEditarClienteLabel">
                            <i class="bi bi-pencil-square me-2 text-rosa"></i>Editar Cliente
                        </h5>
                        <p class="text-muted small mb-0">
                            Altere as informações do cliente selecionado
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarCliente" method="POST" action="../actions/usuario_editar.php">

                        <input type="hidden" name="id" id="edit-id">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label for="edit-nome" class="form-label fw-medium">
                                    Nome <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit-nome" name="nome" required>
                            </div>

                            <div class="col-md-6">
                                <label for="edit-sobrenome" class="form-label fw-medium">
                                    Sobrenome <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit-sobrenome" name="sobrenome" required>
                            </div>

                            <div class="col-md-8">
                                <label for="edit-email" class="form-label fw-medium">
                                    E-mail <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="edit-email" name="email" required>
                            </div>

                            <div class="col-md-4">
                                <label for="edit-telefone" class="form-label fw-medium">Telefone</label>
                                <input type="text" class="form-control" id="edit-telefone" name="telefone"
                                    placeholder="(00) 00000-0000">
                            </div>

                            <div class="col-md-12">
                                <label for="edit-senha" class="form-label fw-medium">Nova senha</label>
                                <input type="password" class="form-control" id="edit-senha" name="senha"
                                    placeholder="Deixe em branco para não alterar" autocomplete="new-password">
                                <div class="form-text text-muted small mt-1">
                                    Mínimo 8 caracteres. Deixe vazio se não quiser alterar a senha atual.
                                </div>
                            </div>

                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                    Cancelar
                                </button>
                                <button type="submit" form="formEditarCliente" class="btn btn-rosa px-4">
                                    <i class="bi bi-save me-2"></i> Salvar Alterações
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Servicos -->
    <div class="modal fade" id="modalServicos" tabindex="-1" aria-labelledby="modalServicosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalServicosLabel">Meus Serviços</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body" style="min-height: 300px;">

                    <?php
                    require_once '../classes/servicos_class.php';

                    $servicoObj = new Servicos();
                    $lista = $servicoObj->ListarServicos();

                    if (empty($lista)):
                    ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-briefcase fs-1 mb-3 d-block"></i>
                            <p class="mb-1">Você ainda não cadastrou nenhum serviço.</p>
                            <small>Clique em "+ Novo Serviço" para adicionar o primeiro</small>
                        </div>

                    <?php else: ?>

                        <div class="list-group" id="listaServicos">
                            <?php foreach ($lista as $item):
                                $valor_formatado = number_format($item['valor'], 2, ',', '.');
                                $duracao_txt = $item['duracao'] >= 60
                                    ? floor($item['duracao'] / 60) . 'h' . ($item['duracao'] % 60 ? ' ' . ($item['duracao'] % 60) . 'min' : '')
                                    : $item['duracao'] . ' min';
                            ?>

                                <div class="list-group-item servico-item cursor-pointer"
                                    data-id="<?= $item['id'] ?>"
                                    data-nome="<?= htmlspecialchars($item['nome']) ?>"
                                    data-descricao="<?= htmlspecialchars($item['descricao'] ?? '') ?>"
                                    data-preco="<?= $item['valor'] ?>"
                                    data-duracao="<?= $item['duracao'] ?>">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?= htmlspecialchars($item['nome']) ?></h6>
                                            <small class="text-muted d-block">
                                                R$ <?= $valor_formatado ?> • <?= $duracao_txt ?>
                                            </small>
                                            <?php if (!empty($item['descricao'])): ?>
                                                <p class="mb-0 mt-1 small text-secondary">
                                                    <?= htmlspecialchars(substr($item['descricao'], 0, 100)) . (strlen($item['descricao']) > 100 ? '...' : '') ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Radio escondido (só para controle interno) -->
                                        <input type="radio" name="servicoSelecionado" class="d-none"
                                            id="radio_<?= $item['id'] ?>" value="<?= $item['id'] ?>">
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalNovoServico"
                        data-action="new">
                        Adicionar Serviço
                    </button>
                    <button type="button" class="btn btn-primary d-none" id="btnEditarSelecionado"
                        data-bs-toggle="modal"
                        data-bs-target="#modalNovoServico">
                        Editar Serviço
                    </button>
                    <button type="button" class="btn btn-outline-danger d-none" id="btnExcluirSelecionado">
                        Excluir Serviço
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- Novo serviço -->
    <div class="modal fade" id="modalNovoServico" tabindex="-1" aria-labelledby="modalNovoServicoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="modalNovoServicoLabel">Novo Serviço</h5>
                        <p class="text-muted mb-0" id="modalSubtitle" style="font-size: 14px;">Adicione um novo serviço ao seu catálogo</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form id="formNovoServico" method="POST" action="../actions/servicos_cadastrar.php">
                    <input type="hidden" name="id" id="editId" value="">

                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Nome do Serviço -->
                            <div class="col-md-8">
                                <label for="nomeServico" class="form-label">Nome do Serviço <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomeServico" name="nomeServico" placeholder="Ex: Manicure Francesa" required>
                            </div>

                            <!-- Descrição -->
                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Descreva os detalhes do serviço..."></textarea>
                            </div>

                            <!-- Preço -->
                            <div class="col-md-6">
                                <label for="preco" class="form-label">Preço <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0" required>
                                </div>
                            </div>

                            <!-- Duração -->
                            <div class="col-md-6">
                                <label for="duracao" class="form-label">Duração aproximada</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="duracao" name="duracao" min="1" required>
                                    <select class="form-select" id="unidadeDuracao" name="unidadeDuracao" style="max-width: 120px;">
                                        <option value="minutos" selected>minutos</option>
                                        <option value="horas">horas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalServicos"
                            data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSalvarServico">Salvar Serviço</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Novo Agendamento -->
    <div class="modal fade" id="modalNovoAgendamento" tabindex="-1" aria-labelledby="modalNovoAgendamentoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <!-- Header -->
                <div class="modal-header border-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="modalNovoAgendamentoLabel">
                            <i class="bi bi-calendar-plus me-2 text-rosa"></i>Novo Agendamento
                        </h5>
                        <p class="text-muted small mb-0">Preencha os dados para criar um agendamento</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form id="formNovoAgendamento" action="../admin/agenda_agendar.php" method="POST">

                        <!-- Campo Cliente com Datalist -->
                        <div class="mb-3">
                            <label for="clienteNome" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Cliente
                            </label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="clienteNome"
                                name="cliente_nome"
                                list="listaClientes"
                                placeholder="Digite o nome do cliente..."
                                required
                                autocomplete="off">

                            <!-- Datalist com sugestões -->
                            <datalist id="listaClientes">
                                <?php
                                // Carrega clientes do banco
                                $sqlClientes = "SELECT id, nome, sobrenome, email, telefone 
                                       FROM usuarios 
                                       WHERE id_tipo = 2 
                                       ORDER BY nome, sobrenome";

                                $banco = Banco::conectar();
                                $comando = $banco->prepare($sqlClientes);
                                $comando->execute();
                                $clientes = $comando->fetchAll(PDO::FETCH_ASSOC);
                                Banco::desconectar();

                                foreach ($clientes as $cliente) {
                                    $nomeCompleto = $cliente['nome'] . ' ' . $cliente['sobrenome'];
                                    echo '<option value="' . htmlspecialchars($nomeCompleto) . '">'
                                        . htmlspecialchars($nomeCompleto) . '</option>';
                                }
                                ?>
                            </datalist>

                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Comece a digitar e selecione um cliente da lista
                            </small>
                        </div>

                        <!-- Campo Data -->
                        <div class="mb-3">
                            <label for="dataAgendamento" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event me-1"></i>Data
                            </label>
                            <input
                                type="date"
                                class="form-control"
                                id="dataAgendamento"
                                name="data"
                                required
                                min="<?= date('Y-m-d') ?>">
                        </div>

                        <!-- Campo Serviço -->
                        <div class="mb-3">
                            <label for="servicoSelect" class="form-label fw-semibold">
                                <i class="bi bi-scissors me-1"></i>Serviço
                            </label>
                            <select class="form-select" id="servicoSelect" name="servico_id" required>
                                <option value="">Selecione um serviço</option>
                                <?php foreach ($servicos as $servico): ?>
                                    <option value="<?= $servico['id'] ?>">
                                        <?= htmlspecialchars($servico['nome']) ?> -
                                        R$ <?= number_format($servico['valor'], 2, ',', '.') ?>
                                        (<?= $servico['duracao'] ?> min)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Campo Horário -->
                        <div class="mb-4">
                            <label for="horarioSelect" class="form-label fw-semibold">
                                <i class="bi bi-clock me-1"></i>Horário
                            </label>
                            <select class="form-select" id="horarioSelect" name="horario" required>
                                <option value="">Selecione um horário</option>
                            </select>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg me-1"></i>Cancelar
                            </button>

                            <button type="button" id="btnConfirmarAgendamento" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Confirmar Agendamento
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <script>
            document.getElementById('dataAgendamento').addEventListener('change', carregarHorariosModal);

            function carregarHorariosModal() {
                const data = document.getElementById('dataAgendamento').value;
                const selectHorario = document.getElementById('horarioSelect');

                // Limpa horários antigos
                selectHorario.innerHTML = '<option value="">Carregando horários...</option>';

                if (!data) {
                    selectHorario.innerHTML = '<option value="">Selecione uma data</option>';
                    return;
                }

                fetch(`../actions/listar_horarios.php?data=${data}`)
                    .then(response => response.json())
                    .then(horarios => {
                        selectHorario.innerHTML = '<option value="">Selecione um horário</option>';

                        if (horarios.length === 0) {
                            selectHorario.innerHTML = '<option value="">Nenhum horário disponível</option>';
                            return;
                        }

                        horarios.forEach(h => {
                            const option = document.createElement('option');
                            option.value = h.id; // ID do horário
                            option.textContent = h.horario.slice(0, 5); // 09:00
                            selectHorario.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erro ao carregar horários:', error);
                        selectHorario.innerHTML = '<option value="">Erro ao carregar horários</option>';
                    });
            }

            // SweetAlert no botão Confirmar Agendamento
            document.getElementById('btnConfirmarAgendamento').addEventListener('click', function(e) {
                e.preventDefault();

                const form = document.getElementById('formNovoAgendamento');

                // Valida se o formulário está preenchido
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Pega os valores do formulário
                const clienteNome = document.getElementById('clienteNome').value;
                const data = document.getElementById('dataAgendamento').value;
                const servicoSelect = document.getElementById('servicoSelect');
                const servicoNome = servicoSelect.options[servicoSelect.selectedIndex].text;
                const horarioSelect = document.getElementById('horarioSelect');
                const horario = horarioSelect.options[horarioSelect.selectedIndex].text;

                // Formata a data
                const dataFormatada = new Date(data + 'T00:00:00').toLocaleDateString('pt-BR');

                Swal.fire({
                    title: 'Confirmar Agendamento?',
                    html: `
                    <div class="text-start p-3">
                        <p class="mb-2"><strong><i class="bi bi-person me-2"></i>Cliente:</strong> ${clienteNome}</p>
                        <p class="mb-2"><strong><i class="bi bi-calendar-event me-2"></i>Data:</strong> ${dataFormatada}</p>
                        <p class="mb-2"><strong><i class="bi bi-clock me-2"></i>Horário:</strong> ${horario}</p>
                        <p class="mb-0"><strong><i class="bi bi-scissors me-2"></i>Serviço:</strong> ${servicoNome}</p>
                    </div>
                `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#e91e63',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Sim, confirmar',
                    cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Cancelar',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-primary px-4',
                        cancelButton: 'btn btn-secondary px-4'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envia o formulário
                        form.submit();
                    }
                });
            });
        </script>

    </div>

    <!-- Modal Relatórios -->
    <div class="modal fade" id="modalRelatorios" tabindex="-1" aria-labelledby="modalRelatoriosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <div>
                        <a href="#" class="text-decoration-none text-muted small" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left me-1"></i> Voltar ao Dashboard
                        </a>
                        <h4 class="modal-title mt-2 d-flex align-items-center gap-2" id="modalRelatoriosLabel">
                            <i class="bi bi-bar-chart-fill text-rosa"></i>
                            Relatórios
                        </h4>
                        <p class="text-muted mb-0 small">Acompanhe o desempenho do seu negócio</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select form-select-g" style="width: auto;">
                            <option value="semana">Esta Semana</option>
                            <option value="mes" selected>Este Mês</option>
                            <option value="trimestre">Este Trimestre</option>
                        </select>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                </div>

                <div class="modal-body p-4">
                    <!-- Cards de Estatísticas -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-lg-3">
                            <div class="card-estatistica card-estatistica-rosa">
                                <p class="stat-label-rel mb-2">RECEITA MENSAL</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="valor-grande">R$ 6.450</span>
                                    <div class="icone-card icone-rosa">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card-estatistica">
                                <p class="stat-label-rel mb-2">ATENDIMENTOS</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="valor-grande valor-cinza">87</span>
                                    <div class="icone-card icone-cinza">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="card-estatistica">
                                <p class="stat-label-rel mb-2">CLIENTES NOVOS</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="valor-grande valor-cinza">12</span>
                                    <div class="icone-card icone-cinza">
                                        <i class="bi bi-person-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela Resumo -->
                <div class="card border rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4">Resumo dos Últimos 6 Meses</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr class="text-muted small">
                                        <th class="fw-semibold border-0 pb-3">Mês</th>
                                        <th class="fw-semibold border-0 pb-3">Receita</th>
                                        <th class="fw-semibold border-0 pb-3">Atendimentos</th>
                                        <th class="fw-semibold border-0 pb-3">Variação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-medium border-0 py-3">Janeiro</td>
                                        <td class="text-rosa fw-semibold border-0 py-3">R$ 6.450</td>
                                        <td class="border-0 py-3">87</td>
                                        <td class="border-0 py-3"><span class="badge badge-variacao-positiva">+5.7%</span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Agenda Completa -->
    <div class="modal fade" id="modalAgenda" tabindex="-1" aria-labelledby="modalAgendaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold titulo" id="modalAgendaLabel">
                            <i class="bi bi-calendar3 me-2 text-rosa"></i>Agenda Completa
                        </h5>
                        <p class="text-muted small mb-0">Visualize e gerencie todos os agendamentos</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body pt-4">
                    <!-- Filtros -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">Data</label>
                            <input type="date" class="form-control" value="2026-01-30">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">Status</label>
                            <select class="form-select">
                                <option value="">Todos</option>
                                <option value="confirmado">Confirmado</option>
                                <option value="pendente">Pendente</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">Serviço</label>
                            <select class="form-select">
                                <option value="">Todos</option>
                                <option value="manicure">Manicure</option>
                                <option value="pedicure">Pedicure</option>
                                <option value="unhas-gel">Unhas em Gel</option>
                                <option value="combo">Combo</option>
                                <option value="nail-art">Nail Art</option>
                            </select>
                        </div>
                    </div>

                    <!-- Lista de Agendamentos -->
                    <div class="list-group list-group-flush">
                        <!-- Agendamento 1 -->
                        <div class="list-group-item border rounded-3 mb-2 p-3">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="rounded-circle bg-rosa text-white d-flex align-items-center justify-content-center fw-semibold avatar">MS</span>
                                    <div>
                                        <span class="fw-semibold d-block">Mariana Silva</span>
                                        <span class="text-muted small">Manicure em Gel</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="text-end">
                                        <span class="d-block fw-medium">10:00 - 11:00</span>
                                        <span class="text-rosa fw-semibold">R$ 80</span>
                                    </div>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">Confirmado</span>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-1"></i>Editar</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-check-circle me-1"></i>Finalizar</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Cancelar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>
    <main class="container-fluid px-4 py-5">

        <!-- Seção de Título -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <span class="badge badge-admin">DASHBOARD ADMIN</span>
                <h1 class="title-welcome mt-3">Bem-vinda,<?= $_SESSION['usuario']['nome'] ?></h1>
                <p class="text-muted subtitle">Aqui está o resumo do seu negócio hoje.</p>
            </div>

        </div>

        <!-- Cards de Estatísticas -->
        <div class="row g-4 mb-5">
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <p class="stat-label">Hoje</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="stat-value">R$ 120</h3>
                        <div class="icon-stat-gold"><i class="bi bi-currency-dollar"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <p class="stat-label">Esta semana</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="stat-value">R$ 1580</h3>
                        <div class="icon-stat-pink"><i class="bi bi-graph-up-arrow"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <p class="stat-label">Agendamentos</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="stat-value">4</h3>
                            <small class="text-muted">hoje</small>
                        </div>
                        <div class="icon-stat-gray"><i class="bi bi-calendar3"></i></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Conteúdo Principal: Agenda + Sidebar -->
        <div class="row g-4">

            <!-- Coluna Esquerda: Agenda -->
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <div>
                            <h5 class="card-title">Agenda de Hoje</h5>
                            <p class="card-subtitle">quinta-feira, 11 de dezembro</p>
                        </div>
                        <a
                            href="#"
                            class="link-view-all"
                            data-bs-toggle="modal"
                            data-bs-target="#modalAgenda">
                            Ver tudo
                        </a>

                    </div>

                    <div class="card-body-custom">
                        <!-- Agendamento 1 -->
                        <div class="appointment-card">
                            <div class="d-flex align-items-center gap-4 w-100">

                                <div class="avatar avatar-pink">MS</div>

                                <div class="flex-grow-1">
                                    <div class="appointment-name">Mariana Silva</div>
                                    <div class="appointment-service">Manicure em Gel</div>
                                </div>

                                <div class="text-end me-3">
                                    <div class="appointment-time">10:00</div>
                                    <div class="appointment-price">R$ 80</div>
                                </div>

                                <!-- AÇÕES -->
                                <div class="appointment-actions">
                                    <button class="btn-action confirm" title="Confirmar">
                                        <i class="bi bi-check-lg"></i>
                                    </button>

                                    <button
                                        class="btn-action cancel btn-cancelar-agenda"
                                        data-id="1">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                </div>

                            </div>
                        </div>
                        <script>
                            // BOTÃO CANCELAR
                            document.querySelectorAll('.btn-cancelar-agenda').forEach(button => {
                                button.addEventListener('click', function() {
                                    const agendamentoId = this.getAttribute('data-id');
                                    const appointmentCard = this.closest('.appointment-card');
                                    const nomeCliente = appointmentCard.querySelector('.appointment-name').textContent;

                                    Swal.fire({
                                        title: 'Cancelar Agendamento?',
                                        html: `Deseja realmente cancelar o agendamento de <strong>${nomeCliente}</strong>?`,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#dc3545',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: '<i class="bi bi-check-lg"></i> Sim, cancelar',
                                        cancelButtonText: '<i class="bi bi-x-lg"></i> Não',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            Swal.fire({
                                                title: 'Cancelado!',
                                                text: 'O agendamento foi cancelado com sucesso.',
                                                icon: 'success',
                                                confirmButtonColor: '#28a745',
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => {
                                                appointmentCard.remove();
                                            });
                                        }
                                    });
                                });
                            });

                            // BOTÃO CONFIRMAR
                            document.querySelectorAll('.btn-action.confirm').forEach(button => {
                                button.addEventListener('click', function() {
                                    const appointmentCard = this.closest('.appointment-card');
                                    const nomeCliente = appointmentCard.querySelector('.appointment-name').textContent;
                                    const servicoCliente = appointmentCard.querySelector('.appointment-service').textContent;
                                    const horarioCliente = appointmentCard.querySelector('.appointment-time').textContent;

                                    Swal.fire({
                                        title: 'Confirmar Agendamento?',
                                        html: `
                        <div class="text-start">
                            <p class="mb-2"><strong>Cliente:</strong> ${nomeCliente}</p>
                            <p class="mb-2"><strong>Serviço:</strong> ${servicoCliente}</p>
                            <p class="mb-0"><strong>Horário:</strong> ${horarioCliente}</p>
                        </div>
                    `,
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#28a745',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: '<i class="bi bi-check-lg"></i> Sim, confirmar',
                                        cancelButtonText: '<i class="bi bi-x-lg"></i> Cancelar',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {


                                            Swal.fire({
                                                title: 'Confirmado!',
                                                text: 'O agendamento foi confirmado com sucesso.',
                                                icon: 'success',
                                                confirmButtonColor: '#28a745',
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => {
                                                // Adiciona badge de confirmado ou muda o estilo do card
                                                appointmentCard.style.borderLeft = '4px solid #28a745';
                                                appointmentCard.style.backgroundColor = '#f8f9fa';

                                                // Remove os botões de ação
                                                const actionsDiv = appointmentCard.querySelector('.appointment-actions');
                                                actionsDiv.innerHTML = '<span class="badge bg-success">Confirmado</span>';
                                            });
                                        }
                                    });
                                });
                            });
                        </script>

                        <!-- Agendamento 2 -->
                        <div class="appointment-card">
                            <div class="d-flex align-items-center gap-3 w-100">

                                <div class="avatar avatar-purple">CS</div>

                                <div class="flex-grow-1">
                                    <div class="appointment-name">Camila Santos</div>
                                    <div class="appointment-service">Combo Mani + Pedi</div>
                                </div>

                                <div class="text-end me-3">
                                    <div class="appointment-time">14:00</div>
                                    <div class="appointment-price">R$ 90</div>
                                </div>

                                <!-- AÇÕES -->
                                <div class="appointment-actions">
                                    <button class="btn-action confirm">
                                        <i class="bi bi-check-lg"></i>
                                    </button>

                                    <button
                                        class="btn-action cancel btn-cancelar-agenda"
                                        data-id="1">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Coluna Direita: Ações Rápidas -->
            <div class="col-lg-4">
                <!-- Card Ações Rápidas -->
                <div class="card-custom mb-4">
                    <div class="card-body-custom-sidebar">
                        <h6 class="sidebar-title">Ações Rápidas</h6>
                        <div class="d-grid gap-3 mt-4">
                            <a href="#"
                                class="action-button d-flex align-items-center gap-2"
                                data-bs-toggle="modal"
                                data-bs-target="#modalServicos">
                                <i class="bi bi-briefcase"></i> Gerenciar Serviços
                            </a>
                            <a
                                href="#"
                                class="action-button"
                                data-bs-toggle="modal"
                                data-bs-target="#modalListaClientes">
                                <i class="bi bi-people"></i> Lista de Clientes
                            </a>

                            <a
                                href="#"
                                class="action-button"
                                data-bs-toggle="modal"
                                data-bs-target="#modalNovoAgendamento">
                                <i class="bi bi-plus-lg"></i> Novo Agendamento
                            </a>

                            <a href="#" class="action-button d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalRelatorios">
                                <i class="bi bi-bar-chart"></i>
                                <span>Relatórios</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer-custom mt-5">
        <div class="container-fluid px-4">
            <div class="row py-5">
                <div class="col-md-4 mb-4">
                    <h5 class="logo footer-logo">Nail Pro</h5>
                    <p class="footer-text">Cuidando da sua beleza com carinho, qualidade e dedicação.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">Contato</h5>
                    <ul class="footer-list">
                        <li>(11) 90000-0000</li>
                        <li>Rua Exemplo, 123</li>
                        <li>Seg-Sáb: 9h às 19h</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">Redes Sociais</h5>
                    <a href="#" class="footer-link">Instagram</a>
                    <a href="#" class="footer-link">WhatsApp</a>
                </div>
            </div>
            <div class="footer-bottom">
                2025 Nail Pro - Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!--  EDITAR SERVIÇOS -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Variável global para guardar o ID selecionado
        let servicoSelecionadoId = null;

        document.addEventListener('DOMContentLoaded', function() {
            const lista = document.getElementById('listaServicos');
            const btnEditar = document.getElementById('btnEditarSelecionado');
            const btnExcluir = document.getElementById('btnExcluirSelecionado');


            if (lista) {
                lista.addEventListener('click', function(e) {
                    const item = e.target.closest('.servico-item');
                    if (!item) return;

                    // Remove seleção anterior
                    document.querySelectorAll('.servico-item').forEach(el => el.classList.remove('active'));
                    // Marca o atual
                    item.classList.add('active');

                    // Pega o ID
                    servicoSelecionadoId = item.getAttribute('data-id');

                    // Mostra o botão editar
                    btnEditar.classList.remove('d-none');
                    // Mostra o botão excluir
                    btnExcluir.classList.remove('d-none');

                });
            }


            if (btnExcluir) {
                btnExcluir.addEventListener('click', function() {
                    if (!servicoSelecionadoId) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Atenção',
                            text: 'Nenhum serviço selecionado.',
                            confirmButtonColor: '#0d6efd'
                        });
                        return;
                    }

                    const itemSelecionado = document.querySelector(`.servico-item[data-id="${servicoSelecionadoId}"]`);
                    const nomeServico = itemSelecionado ? itemSelecionado.dataset.nome : 'este serviço';

                    Swal.fire({
                        title: 'Excluir Serviço',
                        html: `Tem certeza que deseja excluir <strong>"${nomeServico}"</strong>?<br><small class="text-muted">Esta ação não pode ser desfeita.</small>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#eb6b9b',
                        cancelButtonColor: '#aaaaaaff',
                        confirmButtonText: 'Sim, excluir',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true,
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '../actions/excluir_servico.php';

                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'id';
                            inputId.value = servicoSelecionadoId;

                            form.appendChild(inputId);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }
            // Quando o modal de edição abrir
            const modalNovo = document.getElementById('modalNovoServico');
            modalNovo.addEventListener('show.bs.modal', function(event) {
                const trigger = event.relatedTarget;
                const title = document.getElementById('modalNovoServicoLabel');
                const subtitle = document.getElementById('modalSubtitle');
                const btnSalvar = document.getElementById('btnSalvarServico');
                const form = document.getElementById('formNovoServico');

                // Reset padrão (novo serviço)
                form.reset();
                document.getElementById('editId').value = '';
                title.textContent = 'Novo Serviço';
                subtitle.textContent = 'Adicione um novo serviço ao seu catálogo';
                btnSalvar.textContent = 'Salvar Serviço';

                // Se veio do botão Editar Selecionado
                if (trigger && trigger.id === 'btnEditarSelecionado' && servicoSelecionadoId) {
                    // Encontra o elemento com o ID selecionado
                    const itemSelecionado = document.querySelector(`.servico-item[data-id="${servicoSelecionadoId}"]`);
                    if (itemSelecionado) {
                        title.textContent = 'Editar Serviço';
                        subtitle.textContent = 'Altere as informações do serviço selecionado';
                        btnSalvar.textContent = 'Salvar Alterações';

                        document.getElementById('editId').value = servicoSelecionadoId;
                        document.getElementById('nomeServico').value = itemSelecionado.dataset.nome;
                        document.getElementById('descricao').value = itemSelecionado.dataset.descricao;
                        document.getElementById('preco').value = itemSelecionado.dataset.preco;

                        let duracaoMin = parseInt(itemSelecionado.dataset.duracao) || 0;
                        let valor = duracaoMin;
                        let unidade = 'minutos';

                        if (duracaoMin >= 60) {
                            valor = Math.floor(duracaoMin / 60);
                            unidade = 'horas';
                        }

                        document.getElementById('duracao').value = valor;
                        document.getElementById('unidadeDuracao').value = unidade;
                    }
                }
            });
        });
    </script>

    <script>
        // Verificar mensagens de sucesso/erro na URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const success = urlParams.get('success');
            const error = urlParams.get('error');

            // Mensagens de SUCESSO
            if (success === 'novo_servico') {
                Swal.fire({
                    title: 'Serviço Cadastrado!',
                    text: 'O serviço foi adicionado com sucesso.',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Remove o parâmetro da URL para não mostrar novamente
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            } else if (success === 'servico_editado') {
                Swal.fire({
                    title: 'Serviço Atualizado!',
                    text: 'As alterações foram salvas com sucesso.',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            } else if (success === 'servico_excluido') {
                Swal.fire({
                    title: 'Serviço Excluído!',
                    text: 'O serviço foi removido com sucesso.',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            }

            // Mensagens de ERRO
            else if (error === 'falha_cadastro') {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Não foi possível cadastrar o serviço. Tente novamente.',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            } else if (error === 'falha_edicao') {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Não foi possível editar o serviço. Tente novamente.',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            } else if (error === 'id_invalido') {
                Swal.fire({
                    title: 'Erro!',
                    text: 'ID do serviço inválido.',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            } else if (error === 'servico_exclusao_falha') {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Não foi possível excluir o serviço. Tente novamente.',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            }
        });

        // ===== SCRIPT PARA ABRIR MODAL DE EDIÇÃO =====
        const modalEditCliente = document.getElementById('modalEditarCliente')
        if (modalEditCliente) {
            modalEditCliente.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const idcliente = button.getAttribute('data-id')
                const nome = button.getAttribute('data-nome')
                const sobrenome = button.getAttribute('data-sobrenome')
                const email = button.getAttribute('data-email')
                const telefone = button.getAttribute('data-telefone')

                // Preenche os campos do formulário
                modalEditCliente.querySelector('#edit-nome').value = nome
                modalEditCliente.querySelector('#edit-sobrenome').value = sobrenome
                modalEditCliente.querySelector('#edit-email').value = email
                modalEditCliente.querySelector('#edit-telefone').value = telefone
                modalEditCliente.querySelector('#edit-id').value = idcliente
            })
        }

        // ===== SWEETALERT NO BOTÃO DE SALVAR ALTERAÇÕES =====
        const formEditarCliente = document.getElementById('formEditarCliente');

        if (formEditarCliente) {
            formEditarCliente.addEventListener('submit', function(e) {
                e.preventDefault(); // Impede o envio automático do formulário

                // Mostra o SweetAlert de confirmação
                Swal.fire({
                    title: "Deseja salvar as alterações?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Sim, salvar",
                    denyButtonText: "Não salvar",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#EB6B9C",
                    denyButtonColor: "#6c757d",
                    cancelButtonColor: "#adb5bd"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Se confirmou, mostra loading e envia o formulário
                        Swal.fire({
                            title: "Salvando...",
                            text: "Aguarde um momento",
                            icon: "info",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Envia o formulário
                        formEditarCliente.submit();

                    } else if (result.isDenied) {
                        // Se negou, mostra mensagem
                        Swal.fire({
                            title: "Alterações não salvas",
                            text: "Os dados não foram modificados",
                            icon: "info",
                            confirmButtonColor: "#EB6B9C"
                        });
                    }
                    // Se cancelou, não faz nada
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Usa delegação de eventos no elemento pai (tbody) 
            const tbody = document.querySelector('#modalListaClientes tbody');

            if (tbody) {
                tbody.addEventListener('click', function(e) {
                    // Verifica se o clique foi no botão de excluir 
                    const botaoExcluir = e.target.closest('.btnExcluirCliente');

                    if (botaoExcluir) {
                        e.preventDefault();
                        e.stopPropagation();

                        const id = botaoExcluir.getAttribute('data-id');
                        const nome = botaoExcluir.getAttribute('data-nome');

                        // SweetAlert de confirmação de exclusão
                        Swal.fire({
                            title: "Tem certeza?",
                            text: `Deseja realmente excluir ${nome}? Esta ação não pode ser desfeita!`,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#6c757d",
                            confirmButtonText: "Sim, excluir!",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Cria formulário para enviar via POST
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '../actions/usuario_excluir.php';

                                const inputId = document.createElement('input');
                                inputId.type = 'hidden';
                                inputId.name = 'id';
                                inputId.value = id;

                                form.appendChild(inputId);
                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    }
                });
            }
        });


        // ===== SCRIPT PARA FILTRAR CLIENTES E PAGINAÇÃO =====
        document.addEventListener('DOMContentLoaded', () => {
            const inputBusca = document.getElementById('buscarCliente');
            const linhas = Array.from(document.querySelectorAll('#modalListaClientes tbody tr'));
            const paginacao = document.getElementById('paginacaoClientes');

            const itensPorPagina = 10;
            let paginaAtual = 1;
            let linhasFiltradas = [...linhas];

            function renderizarTabela() {
                const inicio = (paginaAtual - 1) * itensPorPagina;
                const fim = inicio + itensPorPagina;

                linhas.forEach(linha => linha.style.display = 'none');

                linhasFiltradas.slice(inicio, fim).forEach(linha => {
                    linha.style.display = '';
                });
            }

            function renderizarPaginacao() {
                paginacao.innerHTML = '';
                const totalPaginas = Math.ceil(linhasFiltradas.length / itensPorPagina);

                for (let i = 1; i <= totalPaginas; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === paginaAtual ? 'active' : ''}`;

                    const a = document.createElement('a');
                    a.className = 'page-link';
                    a.href = '#';
                    a.textContent = i;

                    a.addEventListener('click', e => {
                        e.preventDefault();
                        paginaAtual = i;
                        renderizarTabela();
                        renderizarPaginacao();
                    });

                    li.appendChild(a);
                    paginacao.appendChild(li);
                }
            }

            function filtrarClientes() {
                const termo = inputBusca.value.toLowerCase().trim();

                linhasFiltradas = linhas.filter(linha => {
                    const nome = linha.dataset.nome.toLowerCase();
                    const sobrenome = linha.dataset.sobrenome.toLowerCase();
                    const nomeCompleto = `${nome} ${sobrenome}`;

                    return nomeCompleto.includes(termo);
                });

                paginaAtual = 1;
                renderizarTabela();
                renderizarPaginacao();
            }

            inputBusca.addEventListener('input', filtrarClientes);

            // inicial
            renderizarTabela();
            renderizarPaginacao();
        });
    </script>




</body>

</html>