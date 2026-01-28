<!-- <?php
      //Verifica se o usuario esta logado:
      session_start();
      if (!isset($_SESSION['usuario'])) {
        //Caso o usuario esteja logado, retorna ao login.php
        header("Location: login.php?err=usuario_sessao_invaliada");
        exit();
      }
      ?> -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - Nail Pro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/index.css">
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

  <!-- Modal Novo Serviço -->
  <div class="modal fade" id="modalNovoServico" tabindex="-1" aria-labelledby="modalNovoServicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div>
            <h5 class="modal-title" id="modalNovoServicoLabel">Novo Serviço</h5>
            <p class="text-muted mb-0" style="font-size: 14px;">Adicione um novo serviço ao seu catálogo</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <form id="formNovoServico">
            <div class="row g-4">

              <!-- Nome do Serviço -->
              <div class="col-md-8">
                <label for="nomeServico" class="form-label">Nome do Serviço <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nomeServico" placeholder="Ex: Manicure Francesa" required>
              </div>

              <!-- Categoria -->
              <div class="col-md-4">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" required>
                  <option value="" selected disabled>Selecione</option>
                  <option value="Unhas posticas">Unhas Posticas</option>
                  <option value="manicure">Manicure</option>
                  <option value="pedicure">Pedicure</option>
                  <option value="combo">Combo</option>
                  <option value="unhas-gel">Unhas em Gel</option>
                  <option value="design">Design Personalizado</option>
                  <option value="outros">Outros</option>
                </select>
              </div>

              <!-- Descrição -->
              <div class="col-12">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" rows="3" placeholder="Descreva os detalhes do serviço..."></textarea>
              </div>

              <!-- Preço -->
              <div class="col-md-6">
                <label for="preco" class="form-label">Preço <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">R$</span>
                  <input type="number" class="form-control" id="preco" placeholder="0,00" step="0.01" min="0" required>
                </div>
              </div>

              <!-- Duração -->
              <div class="col-md-6">
                <label for="duracao" class="form-label">Duração aproximada</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="duracao" placeholder="60" min="1">
                  <select class="form-select" id="unidadeDuracao" style="max-width: 120px;">
                    <option value="minutos" selected>minutos</option>
                    <option value="horas">horas</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" form="formNovoServico" class="btn btn-primary">Salvar Serviço</button>
        </div>
      </div>
    </div>
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
            <select class="form-select form-select-sm" style="width: auto;">
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
              <div class="card-estatistica card-estatistica-rosa">
                <p class="stat-label-rel mb-2">TICKET MÉDIO</p>
                <div class="d-flex align-items-center justify-content-between">
                  <span class="valor-grande">R$ 74</span>
                  <div class="icone-card icone-rosa">
                    <i class="bi bi-graph-up-arrow"></i>
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

          <!-- Gráficos -->
          <div class="row g-4 mb-4">
            <!-- Receita Semanal -->
            <div class="col-lg-6">
              <div class="card border rounded-4 h-100">
                <div class="card-body p-4">
                  <h6 class="fw-bold mb-4">Receita Semanal</h6>
                  <div class="grafico-barras">
                    <div class="barra-container">
                      <div class="barra" style="height: 36%;"></div>
                      <span class="barra-label">Seg</span>
                      <span class="barra-valor">R$ 320</span>
                    </div>
                    <div class="barra-container">
                      <div class="barra" style="height: 50%;"></div>
                      <span class="barra-label">Ter</span>
                      <span class="barra-valor">R$ 450</span>
                    </div>
                    <div class="barra-container">
                      <div class="barra" style="height: 31%;"></div>
                      <span class="barra-label">Qua</span>
                      <span class="barra-valor">R$ 280</span>
                    </div>
                    <div class="barra-container">
                      <div class="barra" style="height: 58%;"></div>
                      <span class="barra-label">Qui</span>
                      <span class="barra-valor">R$ 520</span>
                    </div>
                    <div class="barra-container">
                      <div class="barra" style="height: 76%;"></div>
                      <span class="barra-label">Sex</span>
                      <span class="barra-valor">R$ 680</span>
                    </div>
                    <div class="barra-container">
                      <div class="barra barra-destaque" style="height: 100%;"></div>
                      <span class="barra-label">Sáb</span>
                      <span class="barra-valor">R$ 890</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Serviços Mais Realizados -->
            <div class="col-lg-6">
              <div class="card border rounded-4 h-100">
                <div class="card-body p-4">
                  <h6 class="fw-bold mb-4">Serviços Mais Realizados</h6>
                  <div class="servicos-lista">
                    <div class="servico-item">
                      <div class="d-flex justify-content-between mb-1">
                        <span class="servico-nome">Gel</span>
                        <span class="servico-percent text-rosa">35%</span>
                      </div>
                      <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-rosa" style="width: 35%;"></div>
                      </div>
                    </div>
                    <div class="servico-item">
                      <div class="d-flex justify-content-between mb-1">
                        <span class="servico-nome">Pedicure</span>
                        <span class="servico-percent text-rosa">25%</span>
                      </div>
                      <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-rosa" style="width: 25%;"></div>
                      </div>
                    </div>
                    <div class="servico-item">
                      <div class="d-flex justify-content-between mb-1">
                        <span class="servico-nome">Combo Mani+Pedi</span>
                        <span class="servico-percent text-rosa">20%</span>
                      </div>
                      <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-rosa" style="width: 20%;"></div>
                      </div>
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
                      <th class="fw-semibold border-0 pb-3">Ticket Médio</th>
                      <th class="fw-semibold border-0 pb-3">Variação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="fw-medium border-0 py-3">Janeiro</td>
                      <td class="text-rosa fw-semibold border-0 py-3">R$ 6.450</td>
                      <td class="border-0 py-3">87</td>
                      <td class="border-0 py-3">R$ 74</td>
                      <td class="border-0 py-3"><span class="badge badge-variacao-positiva">+5.7%</span></td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-rosa rounded-pill px-4">
            <i class="bi bi-download me-2"></i>Exportar PDF
          </button>
        </div>
      </div>
    </div>
  </div>

  <main class="container-fluid px-4 py-5">

    <!-- Seção de Título -->
    <div class="row mb-5">
      <div class="col-lg-8">
        <span class="badge badge-admin">DASHBOARD ADMIN</span>
        <h1 class="title-welcome mt-3">Bem-vinda, <?= $_SESSION['usuario']['nome'] ?>!</h1>
        <p class="text-muted subtitle">Aqui está o resumo do seu negócio hoje.</p>
      </div>
      <div class="col-lg-4 d-flex gap-2 justify-content-lg-end mt-3 mt-6">
        <button class="btn btn-primary-custom">Configurações</button>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalNovoServico">+ Novo Serviço</button>
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
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <p class="stat-label">Avaliação</p>
          <div class="d-flex align-items-center justify-content-between">
            <h3 class="stat-value">4.9</h3>
            <div class="icon-stat-gray"><i class="bi bi-star-fill"></i></div>
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
            <a href="#" class="link-view-all">Ver tudo</a>
          </div>

          <div class="card-body-custom">
            <!-- Agendamento 1 -->
            <div class="appointment-card">
              <div class="d-flex align-items-center gap-4">
                <div class="avatar avatar-pink">MS</div>
                <div class="flex-grow-1">
                  <div class="appointment-name">Mariana Silva</div>
                  <div class="appointment-service">Manicure em Gel</div>
                </div>
                <div class="text-end">
                  <div class="appointment-time">10:00</div>
                  <div class="appointment-price">R$ 80</div>
                </div>
                <span class="badge-status confirmed">Confirmado</span>
              </div>
            </div>

            <!-- Agendamento 2 -->
            <div class="appointment-card">
              <div class="d-flex align-items-center gap-3">
                <div class="avatar avatar-purple">CS</div>
                <div class="flex-grow-1">
                  <div class="appointment-name">Camila Santos</div>
                  <div class="appointment-service">Combo Mani + Pedi</div>
                </div>
                <div class="text-end">
                  <div class="appointment-time">14:00</div>
                  <div class="appointment-price">R$ 90</div>
                </div>
                <span class="badge-status pending">Pendente</span>
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
              <a href="#" class="action-button">
                <i class="bi bi-calendar-check"></i> Ver Agenda Completa
              </a>
              <a href="#" class="action-button">
                <i class="bi bi-briefcase"></i> Gerenciar Serviços
              </a>
              <a href="#" class="action-button">
                <i class="bi bi-people"></i> Lista de Clientes
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>