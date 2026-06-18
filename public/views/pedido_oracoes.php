<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Pedidos de Oração</h2>
      <p class="text-muted mb-0">Gestão dos pedidos de oração</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0"><?= isset($editPedido) ? 'Editar Pedido' : 'Novo Pedido' ?></h5>
    </div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editPedido) ? '/pedido-oracoes/update' : '/pedido-oracoes/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editPedido)): ?>
          <input type="hidden" name="id" value="<?= $editPedido['id'] ?>">
        <?php endif; ?>

        <div class="col-md-3">
          <label class="form-label">Utilizador</label>
          <select name="id_user" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= $user->getId() ?>" <?= isset($editPedido) && $user->getId() == $editPedido['id_user'] ? 'selected' : '' ?>><?= $user->getNome() ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= isset($editPedido) ? $editPedido['email'] : '' ?>" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">Tipo de Pedido</label>
          <input name="tipo_pedido" class="form-control" value="<?= isset($editPedido) ? $editPedido['tipo_pedido'] : '' ?>" required>
        </div>

        <div class="col-md-10">
          <label class="form-label">Descrição</label>
          <textarea name="descricao" class="form-control" required><?= isset($editPedido) ? $editPedido['descricao'] : '' ?></textarea>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-success w-100" type="submit"><?= isset($editPedido) ? 'Atualizar' : 'Salvar' ?></button>
        </div>

        <?php if (isset($editPedido)): ?>
          <div class="col-md-2 d-flex align-items-end">
            <a href="/pedido-oracoes" class="btn btn-outline-secondary w-100">Cancelar</a>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Lista de Pedidos</h5>
      <input type="text" class="form-control w-25" placeholder="Pesquisar...">
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>Email</th>
              <th>Tipo</th>
              <th>Descrição</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pedidos as $pedido): ?>
              <tr>
                <td><?= $pedido['id'] ?></td>
                <td><?= $pedido['id_user'] ?></td>
                <td><?= $pedido['email'] ?></td>
                <td><?= $pedido['tipo_pedido'] ?></td>
                <td><?= $pedido['descricao'] ?></td>
                <td class="text-nowrap">
                  <a class="btn btn-sm btn-success" href="/pedido-oracoes/edit?id=<?= $pedido['id'] ?>"><i class="bi bi-pencil"></i> Editar</a>
                  <form method="POST" action="/pedido-oracoes/delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
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
