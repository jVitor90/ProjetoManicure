<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - Nail Pro</title>
  <!-- Bootstrap v5 via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
  <!-- Custom CSS for styling Bootstrap components -->
  <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>

<main class="pagina-admin">
  <div class="container py-5">

    <!-- Header using Bootstrap flex utilities -->
    <div class="row mb-4">
      <div class="col-lg-8">
        <span class="badge badge-admin mb-3">Dashboard Admin</span>
        <h1 class="titulo-boas-vindas">Bem-vinda, Ana Paula! 💅</h1>
        <p class="subtitulo text-muted">Aqui está o resumo do seu negócio hoje.</p>
      </div>
      <div class="col-lg-4 d-flex gap-2 justify-content-lg-end pt-3 pt-lg-0">
        <!-- Using Bootstrap btn classes for header buttons -->
        <button class="btn btn-configuracoes">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
          Configurações
        </button>
        <button class="btn btn-novo-servico">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
          Novo Serviço
        </button>
      </div>
    </div>

    <!-- Statistics Cards using Bootstrap grid (row + col) -->
    <div class="row g-3 mb-4">
      <div class="col-6 col-lg-3">
        <div class="card-estatistica">
          <span class="rotulo-estatistica">Hoje</span>
          <div class="d-flex justify-content-between align-items-center">
            <span class="valor-estatistica valor-rosa">R$ 320</span>
            <span class="icone-estatistica icone-rosa">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
            </span>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card-estatistica">
          <span class="rotulo-estatistica">Esta semana</span>
          <div class="d-flex justify-content-between align-items-center">
            <span class="valor-estatistica valor-rosa">R$ 1580</span>
            <span class="icone-estatistica icone-rosa">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 7-8.5 8.5-5-5L2 17"/><path d="M16 7h6v6"/></svg>
            </span>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card-estatistica">
          <span class="rotulo-estatistica">Agendamentos</span>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="valor-estatistica">4</span>
              <span class="texto-auxiliar">hoje</span>
            </div>
            <span class="icone-estatistica icone-cinza">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </span>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card-estatistica">
          <span class="rotulo-estatistica">Avaliação</span>
          <div class="d-flex justify-content-between align-items-center">
            <span class="valor-estatistica">4.9 <span class="estrela">★</span></span>
            <span class="icone-estatistica icone-cinza">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content using Bootstrap grid -->
    <div class="row g-4">
      <!-- Agenda Section using Bootstrap col-lg-8 -->
      <div class="col-lg-8">
        <div class="card-painel">
          <div class="row mb-3 align-items-center">
            <div class="col">
              <h2 class="titulo-painel">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                Agenda de Hoje
              </h2>
              <span class="texto-data">terça-feira, 9 de dezembro</span>
            </div>
            <div class="col-auto">
              <a href="#" class="link-ver-tudo">Ver tudo ›</a>
            </div>
          </div>

          <!-- Appointments list using Bootstrap gap utilities -->
          <div class="lista-agendamentos">
            <div class="item-agendamento d-flex align-items-center justify-content-between gap-3">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <span class="avatar-cliente">MS</span>
                <div>
                  <span class="nome-cliente">Mariana Silva</span>
                  <span class="servico-cliente">Manicure em Gel</span>
                </div>
              </div>
              <div class="info-agendamento text-end">
                <span class="horario">10:00</span>
                <span class="preco">R$ 80</span>
              </div>
              <span class="badge badge-confirmado">Confirmado</span>
            </div>

            <div class="item-agendamento d-flex align-items-center justify-content-between gap-3">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <span class="avatar-cliente avatar-roxo">CS</span>
                <div>
                  <span class="nome-cliente">Camila Santos</span>
                  <span class="servico-cliente">Combo Mani + Pedi</span>
                </div>
              </div>
              <div class="info-agendamento text-end">
                <span class="horario">14:00</span>
                <span class="preco">R$ 90</span>
              </div>
              <span class="badge badge-pendente">Pendente</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar using Bootstrap col-lg-4 -->
      <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card-painel mb-4">
          <h3 class="titulo-painel-pequeno mb-3">Ações Rápidas</h3>
          <div class="lista-acoes">
            <a href="#" class="item-acao">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
              Ver Agenda Completa
            </a>
            <a href="#" class="item-acao">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
              Gerenciar Serviços
            </a>
            <a href="#" class="item-acao">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              Lista de Clientes
            </a>
            <a href="#" class="item-acao">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
              Relatórios
            </a>
          </div>
        </div>

        <!-- This Month Card -->
        <div class="card-painel">
          <h3 class="titulo-painel-pequeno d-flex align-items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 7-8.5 8.5-5-5L2 17"/><path d="M16 7h6v6"/></svg>
            Este Mês
          </h3>
          <span class="valor-grande">R$ 6.450</span>
          <span class="texto-auxiliar-bloco">18 atendimentos esta semana</span>
        </div>
      </div>
    </div>

  </div>
</main>

<!-- Floating WhatsApp Button using Bootstrap rounded-circle -->
<a href="https://wa.me/5511900000000" class="btn-whatsapp rounded-circle position-fixed d-flex align-items-center justify-content-center" target="_blank">
  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
