<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Apoio Social</h2>
      <p class="text-muted mb-0">Gestão dos pedidos de apoio social</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0"><?= isset($editApoio) ? 'Editar Pedido de Apoio' : 'Novo Pedido de Apoio' ?></h5>
    </div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editApoio) ? '/apoio-sociais/update' : '/apoio-sociais/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editApoio)): ?>
          <input type="hidden" name="id" value="<?= $editApoio['id'] ?>">
        <?php endif; ?>

        <div class="col-md-3">
          <label class="form-label">Utilizador</label>
          <select name="id_user" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= $user->getId() ?>" <?= isset($editApoio) && $user->getId() == $editApoio['id_user'] ? 'selected' : '' ?>><?= $user->getNome() ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Local</label>
          <input name="local" class="form-control" value="<?= isset($editApoio) ? $editApoio['local'] : '' ?>" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Código Postal</label>
          <input name="codigo_postal" class="form-control" value="<?= isset($editApoio) ? $editApoio['codigo_postal'] : '' ?>" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Telefone</label>
          <input name="telefone" class="form-control" value="<?= isset($editApoio) ? $editApoio['telefone'] : '' ?>" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Família</label>
          <input type="number" name="membros_de_familia" class="form-control" value="<?= isset($editApoio) ? $editApoio['membros_de_familia'] : '' ?>" required>
        </div>

        <div class="col-md-10">
          <label class="form-label">Pedido de Ajuda</label>
          <textarea name="pedido_ajuda" class="form-control" required><?= isset($editApoio) ? $editApoio['pedido_ajuda'] : '' ?></textarea>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-success w-100" type="submit"><?= isset($editApoio) ? 'Atualizar' : 'Salvar' ?></button>
        </div>

        <?php if (isset($editApoio)): ?>
          <div class="col-md-2 d-flex align-items-end">
            <a href="/apoio-sociais" class="btn btn-outline-secondary w-100">Cancelar</a>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Lista de Apoios</h5>
      <input type="text" class="form-control w-25" placeholder="Pesquisar...">
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>Local</th>
              <th>Código Postal</th>
              <th>Telefone</th>
              <th>Família</th>
              <th>Pedido</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($apoios as $apoio): ?>
              <tr>
                <td><?= $apoio['id'] ?></td>
                <td><?= $apoio['id_user'] ?></td>
                <td><?= $apoio['local'] ?></td>
                <td><?= $apoio['codigo_postal'] ?></td>
                <td><?= $apoio['telefone'] ?></td>
                <td><?= $apoio['membros_de_familia'] ?></td>
                <td><?= $apoio['pedido_ajuda'] ?></td>
                <td class="text-nowrap">
                  <a class="btn btn-sm btn-success" href="/apoio-sociais/edit?id=<?= $apoio['id'] ?>"><i class="bi bi-pencil"></i> Editar</a>
                  <form method="POST" action="/apoio-sociais/delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $apoio['id'] ?>">
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
