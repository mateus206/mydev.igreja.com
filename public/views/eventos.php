<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Eventos</h2>
      <p class="text-muted mb-0">Gestão dos eventos da Igreja+</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0"><?= isset($editEvento) ? 'Editar Evento' : 'Novo Evento' ?></h5>
    </div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editEvento) ? '/eventos/update' : '/eventos/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editEvento)): ?>
          <input type="hidden" name="id" value="<?= $editEvento->getId() ?>">
        <?php endif; ?>
        <input type="hidden" name="id_users" value="<?= isset($editEvento) ? $editEvento->getIdUsers() : ($_SESSION['user_id'] ?? '') ?>">

        <div class="col-md-4">
          <label class="form-label">Data e Hora</label>
          <input type="datetime-local" name="data_hora_inicio" class="form-control" value="<?= isset($editEvento) ? str_replace(' ', 'T', substr($editEvento->getDataHoraInicio(), 0, 16)) : '' ?>" required>
        </div>

        <div class="col-md-4">
          <label class="form-label">Nome do Evento</label>
          <input type="text" name="nome_evento" class="form-control" value="<?= isset($editEvento) ? $editEvento->getNomeEvento() : '' ?>" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">Tipo</label>
          <input type="text" name="tipo_evento" class="form-control" value="<?= isset($editEvento) ? $editEvento->getTipoEvento() : '' ?>" required>
        </div>

        <div class="col-md-1 d-flex align-items-end">
          <button class="btn btn-success w-100" type="submit"><?= isset($editEvento) ? 'Atualizar' : 'Salvar' ?></button>
        </div>

        <?php if (isset($editEvento)): ?>
          <div class="col-md-2 d-flex align-items-end">
            <a href="/eventos" class="btn btn-outline-secondary w-100">Cancelar</a>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Lista de Eventos</h5>
      <input type="text" class="form-control w-25" placeholder="Pesquisar...">
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Utilizador</th>
              <th>Data e Hora</th>
              <th>Nome</th>
              <th>Tipo</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($eventos as $evento): ?>
              <tr>
                <td><?= $evento->getId() ?></td>
                <td>
                  <?php foreach ($users as $user): ?>
                    <?php if ($user->getId() === $evento->getIdUsers()): ?>
                      <?= $user->getNome() ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </td>
                <td><?= $evento->getDataHoraInicio() ?></td>
                <td><?= $evento->getNomeEvento() ?></td>
                <td><?= $evento->getTipoEvento() ?></td>
                <td class="text-nowrap">
                  <a class="btn btn-sm btn-success" href="/eventos/edit?id=<?= $evento->getId() ?>"><i class="bi bi-pencil"></i> Editar</a>
                  <form method="POST" action="/eventos/delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $evento->getId() ?>">
                    <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i> Apagar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</main>

<?php include __DIR__ . "/../includes/footer_home.php"; ?>
