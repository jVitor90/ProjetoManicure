<?php
/* =============================================================
 *  AUTENTICAÇÃO — Verifica se o usuário está logado
 * ============================================================= */
session_start();
if (!isset($_SESSION['usuario'])) {
    // Redireciona para o login caso a sessão seja inválida
    header("Location: login.php?err=usuario_sessao_invaliada");
    exit();
}

/* =============================================================
 *  DEPENDÊNCIAS — Carrega as classes necessárias
 * ============================================================= */
require_once('../classes/servicos_class.php');
require_once('../classes/usuario_class.php');
require_once("../classes/relatorios_class.php");

/* =============================================================
 *  SERVIÇOS — Lista todos os serviços cadastrados
 * ============================================================= */
$servicoObj = new Servicos();
$servicos   = $servicoObj->ListarServicos();

/* =============================================================
 *  USUÁRIOS — Lista todos os usuários cadastrados
 * ============================================================= */
$usuarios         = new Usuario();
$usuarios_listados = $usuarios->ListarTodosUsuarios();

/* =============================================================
 *  RELATÓRIOS — Faturamento e dados por período
 * ============================================================= */
$relatorio         = new Relatorios();
$faturamento       = $relatorio->TotalHoje();
$faturamentoSemanal = $relatorio->FaturamentoSemanal();

// Período selecionado para o modal de Relatórios (padrão: mês)
$periodoSelecionado = isset($_GET['periodo']) ? $_GET['periodo'] : 'mes';

$relatorios        = new relatorios();
$dadosPeriodo      = $relatorios->getDadosPeriodo($periodoSelecionado);
$resumoMeses       = $relatorios->getResumoMeses();
$servicosPopulares = $relatorios->getServicosPopulares($periodoSelecionado);
$nomePeriodo       = $relatorios->getNomePeriodo($periodoSelecionado);

require_once('../classes/agendamento_class.php');
$listarPordata = new Agendamento();
$data = date('Y-m-d');
$listar = $listarPordata->ListarPorData($data)
?>

<!DOCTYPE html>
<html lang="pt-BR">

<!-- ============================================================
     HEAD — Meta, título e dependências CSS
============================================================ -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - Nail Pro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Estilos customizados -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- SweetAlert2 JS (carregado no head para disponibilidade imediata) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body class="bg-white">

<!-- ============================================================
     HEADER — Barra de navegação superior fixa
============================================================ -->
<header class="header-custom sticky-top bg-white">
    <div class="container-fluid px-4">

        <!-- Linha superior: espaço esquerdo / logo central / ações à direita -->
        <div class="header-top d-flex align-items-center justify-content-between py-3">
            <div class="header-left"></div>

            <!-- Logo central -->
            <div class="text-center">
                <a href="../index.php" class="logo fw-bold d-inline-block">Nail Pro</a>
            </div>

            <!-- Ações à direita: dropdown do usuário + toggler mobile -->
            <div class="header-right d-flex align-items-center gap-2">

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

                <!-- Botão hamburguer (visível apenas em telas < lg) -->
                <button class="navbar-toggler d-lg-none border-0 ms-2"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>
        </div>

    </div>
</header>
<!-- /HEADER -->


<!-- ============================================================
     MAIN — Conteúdo principal do dashboard
============================================================ -->
<main class="container-fluid px-4 py-5">

    <!-- Seção de Boas-Vindas -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <span class="badge badge-admin">DASHBOARD ADMIN</span>
            <h1 class="title-welcome mt-3">Olá,<?= $_SESSION['usuario']['nome'] ?></h1>
            <p class="text-muted subtitle">Aqui está o resumo do seu negócio hoje.</p>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-5">

        <!-- Card: Faturamento hoje -->
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <p class="stat-label">Hoje</p>
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="stat-value">R$ <?= $faturamento ?></h3>
                    <div class="icon-stat-gold"><i class="bi bi-currency-dollar"></i></div>
                </div>
            </div>
        </div>

        <!-- Card: Faturamento semanal -->
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <p class="stat-label">Esta semana</p>
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="stat-value">R$ <?= $faturamentoSemanal ?></h3>
                    <div class="icon-stat-pink"><i class="bi bi-graph-up-arrow"></i></div>
                </div>
            </div>
        </div>

        <!-- Card: Agendamentos do dia -->
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
    <!-- /Cards de Estatísticas -->

    <!-- Conteúdo Principal: Agenda + Sidebar -->
    <div class="row g-4">

        <!-- Coluna Esquerda: Agenda do dia -->
        <div class="col-lg-8">
            <div class="card-custom">
                <div class="card-header-custom">
                    <div>
                        <h5 class="card-title">Agenda de Hoje</h5>
                        <p class="card-subtitle">quinta-feira, 11 de dezembro</p>
                    </div>
                    <a href="#" class="link-view-all"
                        data-bs-toggle="modal" data-bs-target="#modalAgenda">
                        Ver tudo
                    </a>
                </div>
                
                 <?php foreach($listar as $l) {?>

                    <!-- Agendamento 1 -->
                    <div class="appointment-card">
                        <div class="d-flex align-items-center gap-4 w-100">

                            <div class="avatar avatar-pink">MS</div>

                            <div class="flex-grow-1">
                                <div class="appointment-name"><?= $l['usuario_nome'] ?></div>
                                <div class="appointment-service"><?= $l['servico_nome'] ?></div>
                            </div>

                            <div class="text-end me-3">
                                <div class="appointment-time"><?= $l['horario'] ?></div>
                                <div class="appointment-price"><?= $l['valor'] ?></div>
                            </div>

                            <!-- Ações do agendamento -->
                            <div class="appointment-actions">
                                <button class="btn-action confirm" title="Confirmar">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <button class="btn-action cancel btn-cancelar-agenda" data-id="1">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <?php } ?>
                
            </div>
        </div>
        <!-- /Coluna Esquerda -->

        <!-- Coluna Direita: Ações Rápidas -->
        <div class="col-lg-4">
            <div class="card-custom mb-4">
                <div class="card-body-custom-sidebar">
                    <h6 class="sidebar-title">Ações Rápidas</h6>
                    <div class="d-grid gap-3 mt-4">

                        <!-- Ação: Gerenciar Serviços -->
                        <a href="#" class="action-button d-flex align-items-center gap-2"
                           data-bs-toggle="modal" data-bs-target="#modalServicos">
                            <i class="bi bi-briefcase"></i> Gerenciar Serviços
                        </a>

                        <!-- Ação: Lista de Clientes -->
                        <a href="#" class="action-button"
                           data-bs-toggle="modal" data-bs-target="#modalListaClientes">
                            <i class="bi bi-people"></i> Lista de Clientes
                        </a>

                        <!-- Ação: Novo Agendamento -->
                        <a href="#" class="action-button"
                           data-bs-toggle="modal" data-bs-target="#modalNovoAgendamento">
                            <i class="bi bi-plus-lg"></i> Novo Agendamento
                        </a>

                        <!-- Ação: Relatórios -->
                        <a href="#" class="action-button d-flex align-items-center gap-2"
                           data-bs-toggle="modal" data-bs-target="#modalRelatorios">
                            <i class="bi bi-bar-chart"></i>
                            <span>Relatórios</span>
                        </a>

                        <!-- Ação: Cadastrar Horários -->
                        <a href="#" class="action-button d-flex align-items-center gap-2"
                           data-bs-toggle="modal" data-bs-target="#modalCadastrarHorarios">
                            <i class="bi bi-clock"></i>
                            <span>Cadastrar Horários</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <!-- /Coluna Direita -->

    </div>
    <!-- /Conteúdo Principal -->

</main>



<!-- ============================================================
     FOOTER — Rodapé do site
============================================================ -->
<footer class="footer-custom mt-5">
    <div class="container-fluid px-4">
        <div class="row py-5">

            <!-- Sobre -->
            <div class="col-md-4 mb-4">
                <h5 class="logo footer-logo">Nail Pro</h5>
                <p class="footer-text">Cuidando da sua beleza com carinho, qualidade e dedicação.</p>
            </div>

            <!-- Contato -->
            <div class="col-md-4 mb-4">
                <h5 class="footer-title">Contato</h5>
                <ul class="footer-list">
                    <li>(11) 90000-0000</li>
                    <li>Rua Exemplo, 123</li>
                    <li>Seg-Sáb: 9h às 19h</li>
                </ul>
            </div>

            <!-- Redes Sociais -->
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
<!-- /FOOTER -->


<!-- ============================================================
     MODAIS — Todos os modais agrupados ao final do body
============================================================ -->


<!-- ============================================================
     MODAL: Lista de Clientes
============================================================ -->
<div class="modal fade" id="modalListaClientes" tabindex="-1"
     aria-labelledby="modalListaClientesLabel" aria-hidden="true">
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

                <!-- Barra de busca -->
                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                    <div class="input-group w-auto flex-grow-1" style="max-width: 320px;">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" id="buscarCliente" placeholder="Buscar cliente...">
                    </div>
                </div>

                <!-- Tabela de clientes -->
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

                                    <td><?= htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']) ?></td>
                                    <td><?= htmlspecialchars($usuario['telefone'] ?? '—') ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= htmlspecialchars($usuario['data_ultimo_agendamento'] ?? '—') ?></td>

                                    <!-- Ações: Editar e Excluir -->
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

                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-3">
                    <nav>
                        <ul class="pagination pagination-sm" id="paginacaoClientes"></ul>
                    </nav>
                </div>

            </div>
            <!-- /Body -->

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
            </div>

        </div>
    </div>
</div>
<!-- /MODAL: Lista de Clientes -->


<!-- ============================================================
     MODAL: Editar Cliente
============================================================ -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1"
     aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <!-- Header -->
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

            <!-- Body -->
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
            <!-- /Body -->

        </div>
    </div>
</div>
<!-- /MODAL: Editar Cliente -->


<!-- ============================================================
     MODAL: Serviços (listagem)
============================================================ -->
<div class="modal fade" id="modalServicos" tabindex="-1"
     aria-labelledby="modalServicosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalServicosLabel">Meus Serviços</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" style="min-height: 300px;">

                <?php
                require_once '../classes/servicos_class.php';

                $servicoObj = new Servicos();
                $lista      = $servicoObj->ListarServicos();

                if (empty($lista)):
                ?>
                    <!-- Estado vazio -->
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-briefcase fs-1 mb-3 d-block"></i>
                        <p class="mb-1">Você ainda não cadastrou nenhum serviço.</p>
                        <small>Clique em "+ Novo Serviço" para adicionar o primeiro</small>
                    </div>

                <?php else: ?>

                    <!-- Lista de serviços -->
                    <div class="list-group" id="listaServicos">
                        <?php foreach ($lista as $item):
                            $valor_formatado = number_format($item['valor'], 2, ',', '.');
                            $duracao_txt     = $item['duracao'] >= 60
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
                                    <!-- Radio escondido (para controle interno de seleção) -->
                                    <input type="radio" name="servicoSelecionado" class="d-none"
                                           id="radio_<?= $item['id'] ?>" value="<?= $item['id'] ?>">
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>

            </div>
            <!-- /Body -->

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#modalNovoServico" data-action="new">
                    Adicionar Serviço
                </button>
                <button type="button" class="btn btn-primary d-none" id="btnEditarSelecionado"
                        data-bs-toggle="modal" data-bs-target="#modalNovoServico">
                    Editar Serviço
                </button>
                <button type="button" class="btn btn-primary d-none" id="btnExcluirSelecionado">
                    Excluir Serviço
                </button>
            </div>

        </div>
    </div>
</div>
<!-- /MODAL: Serviços -->


<!-- ============================================================
     MODAL: Novo / Editar Serviço
============================================================ -->
<div class="modal fade" id="modalNovoServico" tabindex="-1"
     aria-labelledby="modalNovoServicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalNovoServicoLabel">Novo Serviço</h5>
                    <p class="text-muted mb-0" id="modalSubtitle" style="font-size: 14px;">
                        Adicione um novo serviço ao seu catálogo
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <!-- Body -->
            <form id="formNovoServico" method="POST" action="../actions/servicos_cadastrar.php">
                <input type="hidden" name="id" id="editId" value="">

                <div class="modal-body">
                    <div class="row g-4">

                        <!-- Nome do Serviço -->
                        <div class="col-md-8">
                            <label for="nomeServico" class="form-label">
                                Nome do Serviço <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nomeServico" name="nomeServico"
                                   placeholder="Ex: Manicure Francesa" required>
                        </div>

                        <!-- Descrição -->
                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"
                                      placeholder="Descreva os detalhes do serviço..."></textarea>
                        </div>

                        <!-- Preço -->
                        <div class="col-md-6">
                            <label for="preco" class="form-label">Preço <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" id="preco" name="preco"
                                       step="0.01" min="0" required>
                            </div>
                        </div>

                        <!-- Duração -->
                        <div class="col-md-6">
                            <label for="duracao" class="form-label">Duração aproximada</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="duracao" name="duracao"
                                       min="1" required>
                                <select class="form-select" id="unidadeDuracao" name="unidadeDuracao"
                                        style="max-width: 120px;">
                                    <option value="minutos" selected>minutos</option>
                                    <option value="horas">horas</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-toggle="modal" data-bs-target="#modalServicos" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSalvarServico">
                        Salvar Serviço
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- /MODAL: Novo / Editar Serviço -->


<!-- ============================================================
     MODAL: Novo Agendamento
============================================================ -->
<div class="modal fade" id="modalNovoAgendamento" tabindex="-1"
     aria-labelledby="modalNovoAgendamentoLabel" aria-hidden="true">
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

                        <!-- Sugestões de clientes do banco -->
                        <datalist id="listaClientes">
                            <?php
                            $sqlClientes = "SELECT id, nome, sobrenome, email, telefone 
                                           FROM usuarios 
                                           WHERE id_tipo = 2 
                                           ORDER BY nome, sobrenome";

                            $banco   = Banco::conectar();
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

                    <!-- Campo Horário (preenchido via AJAX) -->
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
            <!-- /Body -->

        </div>
    </div>
</div>
<!-- /MODAL: Novo Agendamento -->


<!-- ============================================================
     MODAL: Relatórios
============================================================ -->
<div class="modal fade" id="modalRelatorios" tabindex="-1"
     aria-labelledby="modalRelatoriosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
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

                <!-- Seletor de período + fechar -->
                <div class="d-flex align-items-center gap-2">
                    <form method="GET" action="" id="formPeriodo">
                        <input type="hidden" name="modal" value="relatorios">
                        <select
                            class="form-select form-select-g"
                            id="selectPeriodo"
                            name="periodo"
                            style="width: auto;"
                            onchange="this.form.submit()">
                            <option value="semana"    <?php echo $periodoSelecionado == 'semana'    ? 'selected' : ''; ?>>Semanal</option>
                            <option value="mes"       <?php echo $periodoSelecionado == 'mes'       ? 'selected' : ''; ?>>Mensal</option>
                            <option value="trimestre" <?php echo $periodoSelecionado == 'trimestre' ? 'selected' : ''; ?>>Semestral</option>
                            <option value="ano"       <?php echo $periodoSelecionado == 'ano'       ? 'selected' : ''; ?>>Anual</option>
                        </select>
                    </form>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">

                <!-- Cards de Estatísticas do período -->
                <div class="row g-3 mb-4">

                    <!-- Card: Receita -->
                    <div class="col-6 col-lg-4">
                        <div class="card-estatistica card-estatistica-rosa">
                            <p class="stat-label-rel mb-2" id="labelReceitaPeriodo">
                                RECEITA <?php echo strtoupper($nomePeriodo); ?>
                            </p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="valor-grande" id="valorReceita">
                                    R$ <?php echo $dadosPeriodo['receita']; ?>
                                </span>
                                <div class="icone-card icone-rosa">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Atendimentos -->
                    <div class="col-6 col-lg-4">
                        <div class="card-estatistica">
                            <p class="stat-label-rel mb-2">ATENDIMENTOS</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="valor-grande valor-cinza" id="valorAtendimentos">
                                    <?php echo $dadosPeriodo['atendimentos']; ?>
                                </span>
                                <div class="icone-card icone-cinza">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Clientes Novos -->
                    <div class="col-6 col-lg-4">
                        <div class="card-estatistica">
                            <p class="stat-label-rel mb-2">CLIENTES NOVOS</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="valor-grande valor-cinza" id="valorClientesNovos">
                                    <?php echo $dadosPeriodo['clientesNovos']; ?>
                                </span>
                                <div class="icone-card icone-cinza">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Cards de Estatísticas -->

                <!-- Tabela: Resumo dos últimos 6 meses -->
                <div class="card border rounded-4 mb-2" id="cardResumoMeses">
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
                                <tbody id="tbodyResumoMeses">
                                    <?php foreach ($resumoMeses as $mes): ?>
                                        <tr>
                                            <td class="fw-medium border-0 py-3"><?php echo $mes['mes']; ?></td>
                                            <td class="text-rosa fw-semibold border-0 py-3"><?php echo $mes['receita']; ?></td>
                                            <td class="border-0 py-3"><?php echo $mes['atendimentos']; ?></td>
                                            <td class="border-0 py-3">
                                                <?php if ($mes['variacao'] > 0): ?>
                                                    <span class="badge badge-variacao-positiva"><?php echo $mes['variacaoFormatada']; ?></span>
                                                <?php elseif ($mes['variacao'] < 0): ?>
                                                    <span class="badge badge-variacao-negativa"><?php echo $mes['variacaoFormatada']; ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-variacao-neutra">0%</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Tabela Resumo -->

            </div>
            <!-- /Body -->

        </div>
    </div>
</div>
<!-- /MODAL: Relatórios -->


<!-- ============================================================
     MODAL: Cadastrar / Gerenciar Horários Disponíveis
============================================================ -->
<div class="modal fade" id="modalCadastrarHorarios" tabindex="-1"
     aria-labelledby="modalCadastrarHorariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Header -->
            <div class="modal-header border-0 pb-0"
                 style="background: linear-gradient(135deg, #fff0f5 0%, #fff 100%);">
                <div>
                    <h5 class="modal-title fw-bold" id="modalCadastrarHorariosLabel">
                        <i class="bi bi-clock-fill me-2 text-rosa"></i>Gerenciar Horários Disponíveis
                    </h5>
                    <p class="text-muted small mb-0">
                        Selecione uma data no calendário e defina os horários que estarão disponíveis para agendamento
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <div class="row g-4">

                    <!-- Coluna Esquerda: Calendário -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">

                                <!-- Navegação de mês -->
                                <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                                    <button type="button" class="btn btn-sm btn-light rounded-circle"
                                            id="btnMesAnterior" style="width:34px;height:34px;">
                                        <i class="bi bi-chevron-left small"></i>
                                    </button>
                                    <h6 class="mb-0 fw-bold" id="mesAnoAtual" style="font-size:0.95rem;"></h6>
                                    <button type="button" class="btn btn-sm btn-light rounded-circle"
                                            id="btnProximoMes" style="width:34px;height:34px;">
                                        <i class="bi bi-chevron-right small"></i>
                                    </button>
                                </div>

                                <!-- Grade do calendário (dias da semana + células geradas via JS) -->
                                <div class="grade-calendario" id="gradeCalendario">
                                    <div class="dia-semana-header">Dom</div>
                                    <div class="dia-semana-header">Seg</div>
                                    <div class="dia-semana-header">Ter</div>
                                    <div class="dia-semana-header">Qua</div>
                                    <div class="dia-semana-header">Qui</div>
                                    <div class="dia-semana-header">Sex</div>
                                    <div class="dia-semana-header">Sáb</div>
                                </div>

                                <!-- Legenda do calendário -->
                                <div class="d-flex flex-wrap gap-3 mt-3 px-1">
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="legenda-dot" style="background:#EB6B9C;"></span>
                                        <small class="text-muted" style="font-size:0.72rem;">Dia selecionado</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="legenda-dot" style="background:#d1fae5;border:1.5px solid #10b981;"></span>
                                        <small class="text-muted" style="font-size:0.72rem;">Tem horários</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="legenda-dot" style="background:#e9ecef;"></span>
                                        <small class="text-muted" style="font-size:0.72rem;">Passado</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Coluna Esquerda -->

                    <!-- Coluna Direita: Configuração dos Horários -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">

                                <!-- Cabeçalho da área de cadastro -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-bold mb-0" id="tituloDiaSelecionado">
                                            <i class="bi bi-calendar-event me-2 text-rosa"></i>Selecione uma data
                                        </h6>
                                        <small class="text-muted" id="subtituloDiaSelecionado">
                                            Clique em um dia no calendário para gerenciar os horários
                                        </small>
                                    </div>
                                    <!-- Botão Limpar (oculto até selecionar data) -->
                                    <button type="button" class="btn btn-sm" id="btnLimparDia"
                                            style="background:#fff0f5;color:#EB6B9C;border:1px solid #f9c0d5;display:none;"
                                            onclick="limparTodosHorarios()">
                                        <i class="bi bi-trash me-1"></i>Limpar tudo
                                    </button>
                                </div>

                                <!-- Placeholder: exibido antes de selecionar uma data -->
                                <div id="areaBloqueioDia" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar3 fs-1 d-block mb-2" style="color:#f9c0d5;"></i>
                                    <p class="mb-0 small">Escolha um dia no calendário ao lado</p>
                                </div>

                                <!-- Área de cadastro (oculta até selecionar data) -->
                                <div id="areaCadastroDia" style="display:none;">

                                    <!-- Adicionar horário manualmente -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold small">
                                            <i class="bi bi-plus-circle me-1 text-rosa"></i>Adicionar horário
                                        </label>
                                        <div class="d-flex gap-2">
                                            <input type="time" class="form-control" id="inputNovoHorario"
                                                   style="max-width:140px;">
                                            <button type="button" class="btn btn-rosa btn-sm px-3"
                                                    onclick="adicionarHorarioManual()">
                                                <i class="bi bi-plus-lg me-1"></i>Adicionar
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Gerador de horários em série -->
                                    <div class="p-3 rounded-3 mb-4"
                                         style="background:#fff8fb;border:1px dashed #f9c0d5;">
                                        <p class="fw-semibold small mb-2">
                                            <i class="bi bi-magic me-1 text-rosa"></i>Gerar horários em série
                                        </p>
                                        <div class="row g-2">
                                            <div class="col-4">
                                                <label class="form-label" style="font-size:0.72rem;color:#888;">Das</label>
                                                <input type="time" class="form-control form-control-sm"
                                                       id="geradorInicio" value="09:00">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" style="font-size:0.72rem;color:#888;">Até</label>
                                                <input type="time" class="form-control form-control-sm"
                                                       id="geradorFim" value="18:00">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" style="font-size:0.72rem;color:#888;">A cada</label>
                                                <select class="form-select form-select-sm" id="geradorIntervalo">
                                                    <option value="30">30 min</option>
                                                    <option value="60" selected>1 hora</option>
                                                    <option value="90">1h30</option>
                                                    <option value="120">2 horas</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm mt-2 w-100"
                                                onclick="gerarHorariosEmSerie()"
                                                style="background:#fff0f5;color:#EB6B9C;border:1px solid #f9c0d5;">
                                            <i class="bi bi-stars me-1"></i>Gerar horários automaticamente
                                        </button>
                                    </div>

                                    <!-- Lista de horários cadastrados para o dia -->
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <label class="form-label fw-semibold small mb-0">
                                                <i class="bi bi-list-ul me-1 text-rosa"></i>Horários do dia
                                            </label>
                                            <span class="badge rounded-pill" id="contadorHorarios"
                                                  style="background:#fff0f5;color:#EB6B9C;font-size:0.7rem;">
                                                0 horários
                                            </span>
                                        </div>
                                        <div id="listaHorariosCadastro" class="d-flex flex-wrap gap-2"
                                             style="min-height:60px;max-height:180px;overflow-y:auto;">
                                            <div class="text-muted small w-100 text-center py-3" id="msgSemHorarios">
                                                <i class="bi bi-clock me-1"></i>Nenhum horário adicionado
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /Área de cadastro -->

                            </div>
                        </div>
                    </div>
                    <!-- /Coluna Direita -->

                </div>

                <!-- Resumo geral dos dias configurados -->
                <div class="mt-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold mb-0 small">
                                    <i class="bi bi-calendar-check me-2 text-rosa"></i>Resumo — Dias configurados
                                </h6>
                                <span class="badge rounded-pill" id="totalDiasConfigurados"
                                      style="background:#fff0f5;color:#EB6B9C;">0 dias</span>
                            </div>
                            <div id="resumoDiasConfigurados" class="d-flex flex-wrap gap-2">
                                <small class="text-muted" id="msgResumoVazio">Nenhum dia configurado ainda.</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Body -->

            <!-- Footer -->
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-rosa px-4" onclick="salvarTodosHorarios()">
                    <i class="bi bi-check-lg me-2"></i>Salvar Horários
                </button>
            </div>

        </div>
    </div>
</div>
<!-- /MODAL: Cadastrar Horários -->


<!-- ============================================================
     MODAL: Ver Agenda Completa
============================================================ -->
<div class="modal fade" id="modalAgenda" tabindex="-1"
     aria-labelledby="modalAgendaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold titulo" id="modalAgendaLabel">
                        <i class="bi bi-calendar3 me-2 text-rosa"></i>Agenda Completa
                    </h5>
                    <p class="text-muted small mb-0">Visualize e gerencie todos os agendamentos</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <!-- Body -->
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

                    <!-- Agendamento 1 (exemplo estático) -->
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
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Cancelar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Agendamento 1 -->

                </div>
            </div>
            <!-- /Body -->

            <!-- Footer -->
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>
<!-- /MODAL: Ver Agenda Completa -->


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

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap Bundle JS (inclui Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* =============================================================
 *  SERVIÇOS — Seleção, edição e exclusão na lista de serviços
 * ============================================================= */
let servicoSelecionadoId = null;

document.addEventListener('DOMContentLoaded', function () {
    const lista     = document.getElementById('listaServicos');
    const btnEditar = document.getElementById('btnEditarSelecionado');
    const btnExcluir = document.getElementById('btnExcluirSelecionado');

    // Seleciona um serviço na lista e exibe os botões de ação
    if (lista) {
        lista.addEventListener('click', function (e) {
            const item = e.target.closest('.servico-item');
            if (!item) return;

            document.querySelectorAll('.servico-item').forEach(el => el.classList.remove('active'));
            item.classList.add('active');

            servicoSelecionadoId = item.getAttribute('data-id');
            btnEditar.classList.remove('d-none');
            btnExcluir.classList.remove('d-none');
        });
    }

    // Botão Excluir: confirma e envia via form POST
    if (btnExcluir) {
        btnExcluir.addEventListener('click', function () {
            if (!servicoSelecionadoId) {
                Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Nenhum serviço selecionado.', confirmButtonColor: '#0d6efd' });
                return;
            }

            const itemSelecionado = document.querySelector(`.servico-item[data-id="${servicoSelecionadoId}"]`);
            const nomeServico     = itemSelecionado ? itemSelecionado.dataset.nome : 'este serviço';

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
                    const form    = document.createElement('form');
                    form.method   = 'POST';
                    form.action   = '../actions/excluir_servico.php';
                    const inputId = document.createElement('input');
                    inputId.type  = 'hidden';
                    inputId.name  = 'id';
                    inputId.value = servicoSelecionadoId;
                    form.appendChild(inputId);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    }

    // Modal Novo/Editar Serviço: preenche campos ao abrir no modo edição
    const modalNovo = document.getElementById('modalNovoServico');
    modalNovo.addEventListener('show.bs.modal', function (event) {
        const trigger  = event.relatedTarget;
        const title    = document.getElementById('modalNovoServicoLabel');
        const subtitle = document.getElementById('modalSubtitle');
        const btnSalvar = document.getElementById('btnSalvarServico');
        const form     = document.getElementById('formNovoServico');

        // Estado padrão (novo serviço)
        form.reset();
        document.getElementById('editId').value = '';
        title.textContent    = 'Novo Serviço';
        subtitle.textContent = 'Adicione um novo serviço ao seu catálogo';
        btnSalvar.textContent = 'Salvar Serviço';

        // Modo edição: preenche campos com dados do serviço selecionado
        if (trigger && trigger.id === 'btnEditarSelecionado' && servicoSelecionadoId) {
            const itemSelecionado = document.querySelector(`.servico-item[data-id="${servicoSelecionadoId}"]`);
            if (itemSelecionado) {
                title.textContent    = 'Editar Serviço';
                subtitle.textContent = 'Altere as informações do serviço selecionado';
                btnSalvar.textContent = 'Salvar Alterações';

                document.getElementById('editId').value      = servicoSelecionadoId;
                document.getElementById('nomeServico').value = itemSelecionado.dataset.nome;
                document.getElementById('descricao').value   = itemSelecionado.dataset.descricao;
                document.getElementById('preco').value       = itemSelecionado.dataset.preco;

                let duracaoMin = parseInt(itemSelecionado.dataset.duracao) || 0;
                let valor  = duracaoMin;
                let unidade = 'minutos';
                if (duracaoMin >= 60) { valor = Math.floor(duracaoMin / 60); unidade = 'horas'; }

                document.getElementById('duracao').value        = valor;
                document.getElementById('unidadeDuracao').value = unidade;
            }
        }
    });
});


/* =============================================================
 *  FEEDBACK — Mensagens de sucesso/erro vindas da URL
 * ============================================================= */
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const success   = urlParams.get('success');
    const error     = urlParams.get('error');
    const limparUrl = () => window.history.replaceState({}, document.title, window.location.pathname);

    // Sucesso: novo serviço
    if (success === 'novo_servico') {
        Swal.fire({ title: 'Serviço Cadastrado!', text: 'O serviço foi adicionado com sucesso.', icon: 'success', buttonsStyling: false, confirmButtonText: 'OK' }).then(limparUrl);

    // Sucesso: serviço editado
    } else if (success === 'servico_editado') {
        Swal.fire({ title: 'Serviço Atualizado!', text: 'As alterações foram salvas com sucesso.', icon: 'success', buttonsStyling: false, confirmButtonText: 'OK' }).then(limparUrl);

    // Sucesso: serviço excluído
    } else if (success === 'servico_excluido') {
        Swal.fire({ title: 'Serviço Excluído!', text: 'O serviço foi removido com sucesso.', icon: 'success', buttonsStyling: false, confirmButtonText: 'OK' }).then(limparUrl);

    // Erro: falha no cadastro
    } else if (error === 'falha_cadastro') {
        Swal.fire({ title: 'Erro!', text: 'Não foi possível cadastrar o serviço. Tente novamente.', icon: 'error', buttonsStyling: false, confirmButtonText: 'OK' }).then(limparUrl);

    // Erro: falha na edição
    } else if (error === 'falha_edicao') {
        Swal.fire({ title: 'Erro!', text: 'Não foi possível editar o serviço. Tente novamente.', icon: 'error', buttonsStyling: false, confirmButtonText: 'OK' }).then(limparUrl);

    // Erro: ID inválido
    } else if (error === 'id_invalido') {
        Swal.fire({ title: 'Erro!', text: 'ID do serviço inválido.', icon: 'error', buttonsStyling: false, confirmButtonText: 'OK' }).then(limparUrl);

    // Erro: falha na exclusão
    } else if (error === 'servico_exclusao_falha') {
        Swal.fire({ title: 'Erro!', text: 'Não foi possível excluir o serviço. Tente novamente.', icon: 'error', buttonsStyling: false, confirmButtonText: 'OK' }).then(limparUrl);
    }
});


/* =============================================================
 *  CLIENTES — Modal de edição: preenche campos ao abrir
 * ============================================================= */
const modalEditCliente = document.getElementById('modalEditarCliente');
if (modalEditCliente) {
    modalEditCliente.addEventListener('show.bs.modal', event => {
        const button    = event.relatedTarget;
        const idcliente = button.getAttribute('data-id');
        const nome      = button.getAttribute('data-nome');
        const sobrenome = button.getAttribute('data-sobrenome');
        const email     = button.getAttribute('data-email');
        const telefone  = button.getAttribute('data-telefone');

        modalEditCliente.querySelector('#edit-nome').value      = nome;
        modalEditCliente.querySelector('#edit-sobrenome').value = sobrenome;
        modalEditCliente.querySelector('#edit-email').value     = email;
        modalEditCliente.querySelector('#edit-telefone').value  = telefone;
        modalEditCliente.querySelector('#edit-id').value        = idcliente;
    });
}

/* =============================================================
 *  CLIENTES — Formulário de edição com confirmação SweetAlert
 * ============================================================= */
const formEditarCliente = document.getElementById('formEditarCliente');
if (formEditarCliente) {
    formEditarCliente.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Deseja salvar as alterações?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sim, salvar',
            denyButtonText: 'Não salvar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#EB6B9C',
            denyButtonColor: '#6c757d',
            cancelButtonColor: '#adb5bd'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Salvando...', text: 'Aguarde um momento', icon: 'info', showConfirmButton: false, allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                formEditarCliente.submit();
            } else if (result.isDenied) {
                Swal.fire({ title: 'Alterações não salvas', text: 'Os dados não foram modificados', icon: 'info', confirmButtonColor: '#EB6B9C' });
            }
        });
    });
}

/* =============================================================
 *  CLIENTES — Exclusão com confirmação SweetAlert (delegação)
 * ============================================================= */
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.querySelector('#modalListaClientes tbody');

    if (tbody) {
        tbody.addEventListener('click', function (e) {
            const botaoExcluir = e.target.closest('.btnExcluirCliente');
            if (!botaoExcluir) return;

            e.preventDefault();
            e.stopPropagation();

            const id   = botaoExcluir.getAttribute('data-id');
            const nome = botaoExcluir.getAttribute('data-nome');

            Swal.fire({
                title: 'Tem certeza?',
                text: `Deseja realmente excluir ${nome}? Esta ação não pode ser desfeita!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form    = document.createElement('form');
                    form.method   = 'POST';
                    form.action   = '../actions/usuario_excluir.php';
                    const inputId = document.createElement('input');
                    inputId.type  = 'hidden';
                    inputId.name  = 'id';
                    inputId.value = id;
                    form.appendChild(inputId);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    }
});

/* =============================================================
 *  CLIENTES — Busca e paginação na tabela de clientes
 * ============================================================= */
document.addEventListener('DOMContentLoaded', () => {
    const inputBusca = document.getElementById('buscarCliente');
    const linhas     = Array.from(document.querySelectorAll('#modalListaClientes tbody tr'));
    const paginacao  = document.getElementById('paginacaoClientes');

    const itensPorPagina = 10;
    let paginaAtual      = 1;
    let linhasFiltradas  = [...linhas];

    // Exibe apenas as linhas da página atual
    function renderizarTabela() {
        const inicio = (paginaAtual - 1) * itensPorPagina;
        const fim    = inicio + itensPorPagina;
        linhas.forEach(linha => linha.style.display = 'none');
        linhasFiltradas.slice(inicio, fim).forEach(linha => { linha.style.display = ''; });
    }

    // Gera os links de paginação
    function renderizarPaginacao() {
        paginacao.innerHTML = '';
        const totalPaginas = Math.ceil(linhasFiltradas.length / itensPorPagina);

        for (let i = 1; i <= totalPaginas; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === paginaAtual ? 'active' : ''}`;

            const a       = document.createElement('a');
            a.className   = 'page-link';
            a.href        = '#';
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

    // Filtra clientes pelo nome digitado
    function filtrarClientes() {
        const termo = inputBusca.value.toLowerCase().trim();
        linhasFiltradas = linhas.filter(linha => {
            const nome      = linha.dataset.nome.toLowerCase();
            const sobrenome = linha.dataset.sobrenome.toLowerCase();
            return `${nome} ${sobrenome}`.includes(termo);
        });
        paginaAtual = 1;
        renderizarTabela();
        renderizarPaginacao();
    }

    inputBusca.addEventListener('input', filtrarClientes);

    // Inicializa tabela e paginação
    renderizarTabela();
    renderizarPaginacao();
});


/* =============================================================
 *  PERFIL — Preenche o modal com dados do usuário logado
 * ============================================================= */
document.addEventListener('DOMContentLoaded', function () {
    const perfilModal = document.getElementById('perfilModal');

    perfilModal.addEventListener('show.bs.modal', function (event) {
        const button           = event.relatedTarget;
        const nome             = button.getAttribute('data-nome');
        const sobrenome        = button.getAttribute('data-sobrenome');
        const email            = button.getAttribute('data-email');
        const telefone         = button.getAttribute('data-telefone');
        const ultimoAgendamento = button.getAttribute('data-ultimo-agendamento');
        const criadoEm        = button.getAttribute('data-criado-em');

        document.getElementById('modal-nome').textContent              = nome + ' ' + sobrenome;
        document.getElementById('modal-email').textContent             = email || '—';
        document.getElementById('modal-telefone').textContent          = telefone || '—';
        document.getElementById('modal-ultimo-agendamento').textContent = ultimoAgendamento || 'Nenhum agendamento';
        document.getElementById('modal-criado-em').textContent         = criadoEm ? new Date(criadoEm).toLocaleDateString('pt-BR') : '—';
    });
});


/* =============================================================
 *  AGENDA — Botões Cancelar e Confirmar agendamento
 * ============================================================= */

// Botão Cancelar
document.querySelectorAll('.btn-cancelar-agenda').forEach(button => {
    button.addEventListener('click', function () {
        const appointmentCard = this.closest('.appointment-card');
        const nomeCliente     = appointmentCard.querySelector('.appointment-name').textContent;

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
                Swal.fire({ title: 'Cancelado!', text: 'O agendamento foi cancelado com sucesso.', icon: 'success', confirmButtonColor: '#28a745', timer: 1500, showConfirmButton: false })
                    .then(() => { appointmentCard.remove(); });
            }
        });
    });
});

// Botão Confirmar
document.querySelectorAll('.btn-action.confirm').forEach(button => {
    button.addEventListener('click', function () {
        const appointmentCard  = this.closest('.appointment-card');
        const nomeCliente      = appointmentCard.querySelector('.appointment-name').textContent;
        const servicoCliente   = appointmentCard.querySelector('.appointment-service').textContent;
        const horarioCliente   = appointmentCard.querySelector('.appointment-time').textContent;

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
                Swal.fire({ title: 'Confirmado!', text: 'O agendamento foi confirmado com sucesso.', icon: 'success', confirmButtonColor: '#28a745', timer: 1500, showConfirmButton: false })
                    .then(() => {
                        appointmentCard.style.borderLeft      = '4px solid #28a745';
                        appointmentCard.style.backgroundColor = '#f8f9fa';
                        const actionsDiv = appointmentCard.querySelector('.appointment-actions');
                        actionsDiv.innerHTML = '<span class="badge bg-success">Confirmado</span>';
                    });
            }
        });
    });
});


/* =============================================================
 *  NOVO AGENDAMENTO — Carrega horários via AJAX ao mudar data
 * ============================================================= */
document.getElementById('dataAgendamento').addEventListener('change', carregarHorariosModal);

function carregarHorariosModal() {
    const data          = document.getElementById('dataAgendamento').value;
    const selectHorario = document.getElementById('horarioSelect');

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
                const option      = document.createElement('option');
                option.value      = h.id;
                option.textContent = h.horario.slice(0, 5);
                selectHorario.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erro ao carregar horários:', error);
            selectHorario.innerHTML = '<option value="">Erro ao carregar horários</option>';
        });
}

/* =============================================================
 *  NOVO AGENDAMENTO — Confirmação com SweetAlert antes de enviar
 * ============================================================= */
document.getElementById('btnConfirmarAgendamento').addEventListener('click', function (e) {
    e.preventDefault();

    const form = document.getElementById('formNovoAgendamento');
    if (!form.checkValidity()) { form.reportValidity(); return; }

    const clienteNome    = document.getElementById('clienteNome').value;
    const data           = document.getElementById('dataAgendamento').value;
    const servicoSelect  = document.getElementById('servicoSelect');
    const servicoNome    = servicoSelect.options[servicoSelect.selectedIndex].text;
    const horarioSelect  = document.getElementById('horarioSelect');
    const horario        = horarioSelect.options[horarioSelect.selectedIndex].text;
    const dataFormatada  = new Date(data + 'T00:00:00').toLocaleDateString('pt-BR');

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
        customClass: { confirmButton: 'btn btn-primary px-4', cancelButton: 'btn btn-secondary px-4' },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) { form.submit(); }
    });
});


/* =============================================================
 *  RELATÓRIOS — Seletor de período e abertura via URL
 * ============================================================= */
document.addEventListener('DOMContentLoaded', function () {
    const selectPeriodo = document.getElementById('selectPeriodo');

    // Ao mudar o período, recarrega os dados via AJAX (sem reload da página)
    if (selectPeriodo) {
        selectPeriodo.addEventListener('change', function () {
            const periodoSelecionado = this.value;
            const periodosValidos    = ['semana', 'mes', 'trimestre', 'ano'];
            if (!periodosValidos.includes(periodoSelecionado)) return;
            carregarRelatorios(periodoSelecionado);
        });
    }

    // Reabre o modal de relatórios se o parâmetro ?modal=relatorios estiver na URL
    const urlParams  = new URLSearchParams(window.location.search);
    const modalParam = urlParams.get('modal');
    if (modalParam === 'relatorios') {
        const modalRelatorios = new bootstrap.Modal(document.getElementById('modalRelatorios'));
        modalRelatorios.show();
        window.history.replaceState({}, '', window.location.pathname);
    }
});

/* =============================================================
 *  RELATÓRIOS — Recarrega dados frescos ao abrir o modal
 * ============================================================= */
document.addEventListener('DOMContentLoaded', function () {
    const modalRelatoriosEl = document.getElementById('modalRelatorios');
    if (!modalRelatoriosEl) return;

    modalRelatoriosEl.addEventListener('show.bs.modal', function () {
        const periodo = document.getElementById('selectPeriodo')?.value || 'mes';
        carregarRelatorios(periodo);
    });
});

/* =============================================================
 *  RELATÓRIOS — Função AJAX que atualiza cards e tabela
 * ============================================================= */
function carregarRelatorios(periodo) {
    fetch(`../actions/get_relatorios_data.php?periodo=${periodo}`)
        .then(r => r.json())
        .then(data => {
            if (data.erro) return;

            // Atualiza cards de estatísticas
            const elReceita = document.getElementById('valorReceita');
            const elLabel   = document.getElementById('labelReceitaPeriodo');
            const elAtend   = document.getElementById('valorAtendimentos');
            const elClien   = document.getElementById('valorClientesNovos');

            if (elReceita) elReceita.textContent = 'R$ ' + data.dadosPeriodo.receita;
            if (elLabel)   elLabel.textContent   = 'RECEITA ' + data.nomePeriodo.toUpperCase();
            if (elAtend)   elAtend.textContent   = data.dadosPeriodo.atendimentos;
            if (elClien)   elClien.textContent   = data.dadosPeriodo.clientesNovos;

            // Atualiza tabela de resumo dos últimos 6 meses
            const tbody = document.getElementById('tbodyResumoMeses');
            if (tbody && data.resumoMeses) {
                tbody.innerHTML = '';
                data.resumoMeses.forEach(mes => {
                    let badgeClass  = 'badge-variacao-neutra';
                    let variacaoTxt = '0%';
                    if (mes.variacao > 0)      { badgeClass = 'badge-variacao-positiva'; variacaoTxt = mes.variacaoFormatada; }
                    else if (mes.variacao < 0) { badgeClass = 'badge-variacao-negativa'; variacaoTxt = mes.variacaoFormatada; }

                    tbody.innerHTML += `
                        <tr>
                            <td class="fw-medium border-0 py-3">${mes.mes}</td>
                            <td class="text-rosa fw-semibold border-0 py-3">${mes.receita}</td>
                            <td class="border-0 py-3">${mes.atendimentos}</td>
                            <td class="border-0 py-3"><span class="badge ${badgeClass}">${variacaoTxt}</span></td>
                        </tr>`;
                });
            }
        })
        .catch(err => console.error('Erro ao carregar relatórios:', err));
}


/* =============================================================
 *  HORÁRIOS — Carrega horários do banco ao abrir o modal
 * ============================================================= */
document.addEventListener('DOMContentLoaded', function () {
    const modalHorariosEl = document.getElementById('modalCadastrarHorarios');
    if (!modalHorariosEl) return;

    modalHorariosEl.addEventListener('show.bs.modal', function () {
        fetch('../actions/listar_todos_horarios_admin.php')
            .then(r => r.json())
            .then(dados => {
                if (dados.erro) return;
                modalHorariosEl.dispatchEvent(new CustomEvent('horariosCarregados', { detail: dados }));
            })
            .catch(err => console.error('Erro ao carregar horários do banco:', err));
    });
});


/* =============================================================
 *  HORÁRIOS — Calendário interativo (IIFE para escopo isolado)
 * ============================================================= */
(function () {
    let mesAtual       = new Date().getMonth();
    let anoAtual       = new Date().getFullYear();
    let dataSelecionada = null;
    let horariosDB     = {};

    const MESES = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                   'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    // Formata uma data como string YYYY-MM-DD
    function formatarData(ano, mes, dia) {
        return `${ano}-${String(mes + 1).padStart(2,'0')}-${String(dia).padStart(2,'0')}`;
    }

    // Renderiza o calendário do mês atual
    function renderizarCalendario() {
        const grade   = document.getElementById('gradeCalendario');
        const headers = Array.from(grade.children).slice(0, 7);
        grade.innerHTML = '';
        headers.forEach(h => grade.appendChild(h));

        document.getElementById('mesAnoAtual').textContent = MESES[mesAtual] + ' ' + anoAtual;

        const hoje    = new Date();
        const hojeStr = formatarData(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
        const primeiroDia = new Date(anoAtual, mesAtual, 1).getDay();
        const totalDias   = new Date(anoAtual, mesAtual + 1, 0).getDate();

        // Células vazias antes do primeiro dia
        for (let i = 0; i < primeiroDia; i++) {
            const v = document.createElement('div');
            v.className = 'dia-cal dia-vazio';
            grade.appendChild(v);
        }

        // Células dos dias do mês
        for (let d = 1; d <= totalDias; d++) {
            const dataStr = formatarData(anoAtual, mesAtual, d);
            const cel     = document.createElement('div');
            cel.className     = 'dia-cal';
            cel.textContent   = d;
            cel.dataset.data  = dataStr;

            const dataObj = new Date(anoAtual, mesAtual, d);
            const hojeObj = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());

            if (dataObj < hojeObj)    cel.classList.add('dia-passado');
            else if (dataStr === hojeStr) cel.classList.add('dia-hoje');

            if (horariosDB[dataStr]?.length > 0)  cel.classList.add('dia-com-horarios');
            if (dataSelecionada === dataStr)       cel.classList.add('dia-selecionado');

            cel.addEventListener('click', function () {
                if (cel.classList.contains('dia-passado')) return;
                selecionarDia(dataStr);
            });

            grade.appendChild(cel);
        }
    }

    // Seleciona um dia no calendário e exibe a área de cadastro
    function selecionarDia(dataStr) {
        dataSelecionada = dataStr;

        document.querySelectorAll('.dia-cal').forEach(c => c.classList.remove('dia-selecionado'));
        const cel = document.querySelector(`.dia-cal[data-data="${dataStr}"]`);
        if (cel) cel.classList.add('dia-selecionado');

        const [ano, mes, dia] = dataStr.split('-').map(Number);
        const dataObj    = new Date(ano, mes - 1, dia);
        const diasSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
        const nomesMes   = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

        document.getElementById('tituloDiaSelecionado').innerHTML =
            `<i class="bi bi-calendar-event me-2 text-rosa"></i>${diasSemana[dataObj.getDay()]}, ${dia} de ${nomesMes[mes-1]} de ${ano}`;
        document.getElementById('subtituloDiaSelecionado').textContent =
            'Adicione ou remova os horários disponíveis para este dia';

        document.getElementById('areaBloqueioDia').style.display   = 'none';
        document.getElementById('areaCadastroDia').style.display   = 'block';
        document.getElementById('btnLimparDia').style.display      = 'inline-flex';

        if (!horariosDB[dataStr]) horariosDB[dataStr] = [];
        renderizarTagsHorarios();
    }

    // Renderiza as tags (chips) de horários do dia selecionado
    function renderizarTagsHorarios() {
        if (!dataSelecionada) return;
        const lista    = document.getElementById('listaHorariosCadastro');
        const horarios = (horariosDB[dataSelecionada] || []).slice().sort();

        lista.innerHTML = '';

        if (horarios.length === 0) {
            lista.innerHTML = `<div class="text-muted small w-100 text-center py-3">
                <i class="bi bi-clock me-1"></i>Nenhum horário adicionado</div>`;
        } else {
            horarios.forEach(h => {
                const tag = document.createElement('div');
                tag.className = 'tag-horario';
                tag.innerHTML = `<i class="bi bi-clock-fill" style="font-size:0.7rem;"></i>${h}
                    <button class="btn-remover-horario" onclick="removerHorario('${h}')" title="Remover">
                        <i class="bi bi-x-lg"></i>
                    </button>`;
                lista.appendChild(tag);
            });
        }

        document.getElementById('contadorHorarios').textContent =
            horarios.length + (horarios.length === 1 ? ' horário' : ' horários');

        const cel = document.querySelector(`.dia-cal[data-data="${dataSelecionada}"]`);
        if (cel) {
            if (horarios.length > 0) cel.classList.add('dia-com-horarios');
            else cel.classList.remove('dia-com-horarios');
        }

        atualizarResumo();
    }

    // Adiciona um horário digitado manualmente
    window.adicionarHorarioManual = function () {
        if (!dataSelecionada) return;
        const input = document.getElementById('inputNovoHorario');
        const valor = input.value;

        if (!valor) {
            Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Informe um horário válido.', confirmButtonColor: '#EB6B9C', timer: 2000, showConfirmButton: false });
            return;
        }
        if (!horariosDB[dataSelecionada]) horariosDB[dataSelecionada] = [];
        if (horariosDB[dataSelecionada].includes(valor)) {
            Swal.fire({ icon: 'info', title: 'Duplicado', text: 'Este horário já foi adicionado.', confirmButtonColor: '#EB6B9C', timer: 2000, showConfirmButton: false });
            return;
        }

        horariosDB[dataSelecionada].push(valor);
        input.value = '';
        renderizarTagsHorarios();
    };

    // Remove um horário específico (chamada ao banco + atualiza UI)
    window.removerHorario = function (horario) {
        if (!dataSelecionada) return;
        fetch('../actions/remover_horario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ acao: 'remover_um', data: dataSelecionada, horario: horario })
        })
        .then(r => r.json())
        .then(data => {
            if (data.sucesso) {
                horariosDB[dataSelecionada] = horariosDB[dataSelecionada].filter(h => h !== horario);
                renderizarTagsHorarios();
            } else {
                Swal.fire({ icon: 'error', title: 'Erro', text: data.mensagem || 'Não foi possível remover.', confirmButtonColor: '#EB6B9C' });
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Erro de conexão', text: 'Verifique sua conexão e tente novamente.', confirmButtonColor: '#EB6B9C' });
        });
    };

    // Remove todos os horários do dia selecionado
    window.limparTodosHorarios = function () {
        if (!dataSelecionada) return;
        Swal.fire({
            title: 'Limpar horários?',
            text: 'Todos os horários deste dia serão removidos.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EB6B9C',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, limpar',
            cancelButtonText: 'Cancelar'
        }).then(r => {
            if (r.isConfirmed) {
                fetch('../actions/remover_horario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ acao: 'limpar_tudo', data: dataSelecionada })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.sucesso) {
                        horariosDB[dataSelecionada] = [];
                        renderizarTagsHorarios();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Erro', text: data.mensagem || 'Não foi possível limpar.', confirmButtonColor: '#EB6B9C' });
                    }
                })
                .catch(() => {
                    Swal.fire({ icon: 'error', title: 'Erro de conexão', text: 'Verifique sua conexão e tente novamente.', confirmButtonColor: '#EB6B9C' });
                });
            }
        });
    };

    // Gera horários em série entre dois horários com intervalo definido
    window.gerarHorariosEmSerie = function () {
        if (!dataSelecionada) return;
        const inicio   = document.getElementById('geradorInicio').value;
        const fim      = document.getElementById('geradorFim').value;
        const intervalo = parseInt(document.getElementById('geradorIntervalo').value);

        if (!inicio || !fim) {
            Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Preencha o início e fim.', confirmButtonColor: '#EB6B9C' });
            return;
        }
        if (inicio >= fim) {
            Swal.fire({ icon: 'warning', title: 'Atenção', text: 'O início deve ser antes do fim.', confirmButtonColor: '#EB6B9C' });
            return;
        }

        const [hI, mI] = inicio.split(':').map(Number);
        const [hF, mF] = fim.split(':').map(Number);
        let minAtual   = hI * 60 + mI;
        const minFim   = hF * 60 + mF;

        if (!horariosDB[dataSelecionada]) horariosDB[dataSelecionada] = [];
        let adicionados = 0;

        while (minAtual <= minFim) {
            const h = `${String(Math.floor(minAtual/60)).padStart(2,'0')}:${String(minAtual%60).padStart(2,'0')}`;
            if (!horariosDB[dataSelecionada].includes(h)) {
                horariosDB[dataSelecionada].push(h);
                adicionados++;
            }
            minAtual += intervalo;
        }

        renderizarTagsHorarios();
        Swal.fire({
            icon: adicionados > 0 ? 'success' : 'info',
            title: adicionados > 0 ? 'Pronto!' : 'Sem novidades',
            text: adicionados > 0 ? `${adicionados} horário(s) adicionado(s).` : 'Todos já estavam adicionados.',
            confirmButtonColor: '#EB6B9C',
            timer: 2000,
            showConfirmButton: false
        });
    };

    // Atualiza o resumo de dias configurados no rodapé do modal
    function atualizarResumo() {
        const resumo  = document.getElementById('resumoDiasConfigurados');
        const contador = document.getElementById('totalDiasConfigurados');
        const diasComHorarios = Object.entries(horariosDB)
            .filter(([, h]) => h.length > 0)
            .sort(([a], [b]) => a.localeCompare(b));

        resumo.innerHTML = '';

        if (diasComHorarios.length === 0) {
            resumo.innerHTML = '<small class="text-muted">Nenhum dia configurado ainda.</small>';
            contador.textContent = '0 dias';
            return;
        }

        const nomesMes = ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'];
        diasComHorarios.forEach(([data, horas]) => {
            const [ano, mes, dia] = data.split('-').map(Number);
            const tag = document.createElement('span');
            tag.className = 'tag-resumo-dia';
            tag.title     = `${horas.length} horário(s)`;
            tag.innerHTML = `<i class="bi bi-calendar-check-fill" style="color:#10b981;font-size:0.7rem;"></i>
                <strong>${dia} ${nomesMes[mes-1]}</strong>
                <span class="badge rounded-pill" style="background:#e6f9f3;color:#065f46;font-size:0.65rem;">${horas.length}</span>`;
            tag.addEventListener('click', () => {
                mesAtual = mes - 1;
                anoAtual = ano;
                renderizarCalendario();
                selecionarDia(data);
            });
            resumo.appendChild(tag);
        });

        contador.textContent = diasComHorarios.length + (diasComHorarios.length === 1 ? ' dia' : ' dias');
    }

    // Salva todos os horários configurados no banco via AJAX
    window.salvarTodosHorarios = function () {
        // Inclui TODAS as entradas (inclusive arrays vazios para limpar datas no banco)
        const payload           = Object.entries(horariosDB);
        const payloadComHorarios = payload.filter(([, h]) => h.length > 0);

        if (payload.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Nada para salvar', text: 'Configure pelo menos um horário antes de salvar.', confirmButtonColor: '#EB6B9C' });
            return;
        }

        const nomesMes   = ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'];
        const resumoHtml = payloadComHorarios.slice(0, 5).map(([data, horas]) => {
            const [, mes, dia] = data.split('-').map(Number);
            return `<li><strong>${dia}/${nomesMes[mes-1]}:</strong> ${horas.sort().join(', ')}</li>`;
        }).join('')
            + (payloadComHorarios.length > 5 ? `<li>... e mais ${payloadComHorarios.length - 5} dia(s)</li>` : '')
            + (payload.length > payloadComHorarios.length
                ? `<li class="text-danger"><i class="bi bi-trash me-1"></i>${payload.length - payloadComHorarios.length} dia(s) serão limpos</li>` : '');

        Swal.fire({
            title: 'Confirmar horários?',
            html: `<ul class="text-start small ps-3">${resumoHtml}</ul>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#EB6B9C',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i>Sim, salvar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => {
            if (!r.isConfirmed) return;

            Swal.fire({ title: 'Salvando...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });

            fetch('../actions/salvar_horarios.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ horarios: Object.fromEntries(payload) })
            })
            .then(res => res.json())
            .then(data => {
                if (data.sucesso) {
                    Swal.fire({ icon: 'success', title: 'Salvo!', text: 'Horários cadastrados com sucesso.', confirmButtonColor: '#EB6B9C', timer: 2500, showConfirmButton: false });
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalCadastrarHorarios'));
                        if (modal) modal.hide();
                    }, 2600);
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: data.mensagem || 'Não foi possível salvar.', confirmButtonColor: '#EB6B9C' });
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Erro de conexão', text: 'Verifique sua conexão e tente novamente.', confirmButtonColor: '#EB6B9C' });
            });
        });
    };

    // Inicializa o calendário e eventos ao abrir o modal de horários
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalCadastrarHorarios');
        if (modalEl) {
            modalEl.addEventListener('show.bs.modal', function () {
                mesAtual = new Date().getMonth();
                anoAtual = new Date().getFullYear();
                renderizarCalendario();

                document.getElementById('btnMesAnterior').addEventListener('click', () => {
                    if (mesAtual === 0) { mesAtual = 11; anoAtual--; } else mesAtual--;
                    renderizarCalendario();
                });
                document.getElementById('btnProximoMes').addEventListener('click', () => {
                    if (mesAtual === 11) { mesAtual = 0; anoAtual++; } else mesAtual++;
                    renderizarCalendario();
                });

                // Tecla Enter no campo de horário manual
                document.getElementById('inputNovoHorario').addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') { e.preventDefault(); adicionarHorarioManual(); }
                });
            });

            // Recebe horários do banco e mescla com os da sessão atual
            modalEl.addEventListener('horariosCarregados', function (e) {
                const dadosBanco = e.detail;
                for (const [data, horas] of Object.entries(dadosBanco)) {
                    if (!horariosDB[data]) {
                        horariosDB[data] = horas;
                    } else {
                        horas.forEach(h => { if (!horariosDB[data].includes(h)) horariosDB[data].push(h); });
                    }
                }
                renderizarCalendario();
                atualizarResumo();
            });
        }
    });

})();
</script>

</body>
</html>