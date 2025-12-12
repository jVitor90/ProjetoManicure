<?php
//Verifica se o usuario esta logado:
session_start();
if (!isset($_SESSION['usuario'])) {
  //Caso o usuario esteja logado, retorna ao login.php
  header("Location: login.php?err=usuario_sessao_invaliada");
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - Nail Pro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body class="bg-white">

<header class="header-custom sticky-top bg-white">
    <div class="container-fluid px-4">

      <!-- Linha superior: left spacer / logo central / right actions -->
      <div class="header-top d-flex align-items-center justify-content-between py-3">
        <div class="header-left"></div>

        <div class="text-center">
          <a href="./index.php class="logo fw-bold d-inline-block">Nail Pro</a>
        </div>

        <div class="header-right d-flex align-items-center gap-2">
          

          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Olá,
              <?=$_SESSION['usuario']['nome']?>!
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li>
                <a
                  class="dropdown-item"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  href="#">
                </a>
              </li>

              <li><a class="dropdown-item" href="#">Perfil</a></li>
              <li><a class="dropdown-item" href="#">Configurações</a></li>
              <hr>
              <li>
                <a
                  class="dropdown-item d-flex align-items-center"
                  href="./admin/sair.php">Sair

                </a>
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
            <li class="nav-item"><a class="nav-link link-nav px-3" href="../Contato/index.php">Contato</a></li>
          </ul>
        </nav>
      </div>

    </div>
  </header>

<main class="container-fluid px-4 py-5">
  
  <!-- Seção de Título -->
  <div class="row mb-5">
    <div class="col-lg-8">
      <span class="badge badge-admin">DASHBOARD ADMIN</span>
      <h1 class="title-welcome mt-3">Bem-vinda, Ana Paula! 👋</h1>
      <p class="text-muted subtitle">Aqui está o resumo do seu negócio hoje.</p>
    </div>
    <div class="col-lg-4 d-flex gap-2 justify-content-lg-end mt-3 mt-6">
      <button class="btn btn-primary-custom" >⚙️ Configurações</button>
      <button class="btn btn-primary-custom">+ Novo Serviço</button>
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
          <h3 class="stat-value">4.9 ★</h3>
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
            <h5 class="card-title">📅 Agenda de Hoje</h5>
            <p class="card-subtitle">quinta-feira, 11 de dezembro</p>
          </div>
          <a href="#" class="link-view-all">Ver tudo →</a>
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
            <a href="#" class="action-button">
              <i class="bi bi-bar-chart"></i> Relatórios
            </a>
          </div>
        </div>
      </div>

      <!-- Card Este Mês -->
      <div class="card-custom">
        <div class="card-body-custom-sidebar">
          <div class="mb-4">
            <h6 class="sidebar-title">Este Mês</h6>
            <p class="mb-0">
              <i class="bi bi-arrow-up-right" style="color: #eb6b9b;"></i>
            </p>
          </div>
          <h2 class="month-value">R$ 6.450</h2>
          <p class="month-subtitle">18 atendimentos esta semana</p>
          <a href="#" class="btn-view-report">Ver Relatório Completo</a>
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
          <li>Seg–Sáb: 9h às 19h</li>
        </ul>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="footer-title">Redes Sociais</h5>
        <a href="#" class="footer-link">Instagram</a>
        <a href="#" class="footer-link">WhatsApp</a>
      </div>
    </div>
    <div class="footer-bottom">
      © 2025 Nail Pro — Todos os direitos reservados.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>