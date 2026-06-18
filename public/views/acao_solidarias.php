<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Ações Solidárias</h2>
      <p class="text-muted mb-0">Gestão das ações solidárias</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0"><?= isset($editAcao) ? 'Editar Ação' : 'Nova Ação' ?></h5>
    </div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editAcao) ? '/acao-solidarias/update' : '/acao-solidarias/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editAcao)): ?>
          <input type="hidden" name="id" value="<?= $editAcao->getId() ?>">
        <?php endif; ?>

        <div class="col-md-3">
          <label class="form-label">Utilizador</label>
          <select name="id_user" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= $user->getId() ?>" <?= isset($editAcao) && $user->getId() === $editAcao->getIdUser() ? 'selected' : '' ?>><?= $user->getNome() ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Data e Hora</label>
          <input type="datetime-local" name="data_hora_inicio" class="form-control" value="<?= isset($editAcao) ? str_replace(' ', 'T', substr($editAcao->getDataHoraInicio(), 0, 16)) : '' ?>" required>
        </div>

        <div class="col-md-4">
          <label class="form-label">Nome da Ação</label>
          <input name="nome_acao" class="form-control" value="<?= isset($editAcao) ? $editAcao->getNomeAcao() : '' ?>" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-success w-100" type="submit"><?= isset($editAcao) ? 'Atualizar' : 'Salvar' ?></button>
        </div>

        <?php if (isset($editAcao)): ?>
          <div class="col-md-2 d-flex align-items-end">
            <a href="/acao-solidarias" class="btn btn-outline-secondary w-100">Cancelar</a>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Lista de Ações</h5>
      <input type="text" class="form-control w-25" placeholder="Pesquisar...">
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>Data</th>
              <th>Nome</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($acoes as $acao): ?>
              <tr>
                <td><?= $acao->getId() ?></td>
                <td><?= $acao->getIdUser() ?></td>
                <td><?= $acao->getDataHoraInicio() ?></td>
                <td><?= $acao->getNomeAcao() ?></td>
                <td class="text-nowrap">
                  <a class="btn btn-sm btn-success" href="/acao-solidarias/edit?id=<?= $acao->getId() ?>"><i class="bi bi-pencil"></i> Editar</a>
                  <form method="POST" action="/acao-solidarias/delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $acao->getId() ?>">
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
