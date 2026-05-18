<?php include __DIR__ . "/../includes/header_home.php"; ?>

<body class="d-flex flex-column min-vh-100">

<div class="container-fluid flex-grow-1">

  <div class="p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

      <div>
        <h2>Dashboard</h2>
        <p class="text-muted mb-0">
          Bem-vindo ao painel administrativo da Igreja+
        </p>
      </div>

      <button class="btn btn-primary">
        <i class="bi bi-plus-lg"></i>
        Novo Evento
      </button>

    </div>

    <!-- CARDS -->
    <div class="row g-3 mb-4">

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h6 class="text-muted">Total de Users</h6>
            <h2><?= $userCount ?></h2>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h6 class="text-muted">Eventos</h6>
            <h2><?= $eventCount ?></h2>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h6 class="text-muted">Apoio Social</h6>
            <h2><?= $apoioSocialCount ?></h2>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h6 class="text-muted">Pedidos de Oração</h6>
            <h2><?= $pedidosOracaoCount ?></h2>
          </div>
        </div>
      </div>

    </div>

    <!-- TABELA -->
    <div class="card mb-4">

      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Últimos Membros</h5>

        <button class="btn btn-sm btn-outline-primary">
          Ver Todos
        </button>
      </div>

      <div class="card-body p-0">

        <div class="table-responsive">

          <table class="table table-striped table-hover mb-0">

            <thead>
              <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Cargo</th>
                <th>Status</th>
              </tr>
            </thead>

            <tbody>

              <tr>
                <td>1</td>
                <td>João Silva</td>
                <td>joao@email.com</td>
                <td>Membro</td>
                <td><span class="badge text-bg-success">Ativo</span></td>
              </tr>

              <tr>
                <td>2</td>
                <td>Maria Costa</td>
                <td>maria@email.com</td>
                <td>Líder</td>
                <td><span class="badge text-bg-success">Ativo</span></td>
              </tr>

              <tr>
                <td>3</td>
                <td>Pedro Rocha</td>
                <td>pedro@email.com</td>
                <td>Visitante</td>
                <td><span class="badge text-bg-warning">Pendente</span></td>
              </tr>

            </tbody>

          </table>

        </div>

      </div>

    </div>

  </div>

</div>

<?php include __DIR__ . "/../includes/footer_home.php"; ?>