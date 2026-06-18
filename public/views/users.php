<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Users</h2>
      <p class="text-muted mb-0">Gestão de utilizadores da Igreja+</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0"><?= isset($editUser) ? 'Editar Utilizador' : 'Novo Utilizador' ?></h5>
    </div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editUser) ? '/users/update' : '/users/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editUser)): ?>
          <input type="hidden" name="id" value="<?= $editUser->getId() ?>">
        <?php endif; ?>

        <div class="col-md-3">
          <label class="form-label">Nome</label>
          <input name="nome" class="form-control" value="<?= isset($editUser) ? $editUser->getNome() : '' ?>" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Telefone</label>
          <input name="telefone" class="form-control" value="<?= isset($editUser) ? $editUser->getTelefone() : '' ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= isset($editUser) ? $editUser->getEmail() : '' ?>" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Estado</label>
          <input name="estado" class="form-control" value="<?= isset($editUser) ? $editUser->getEstado() : 'ativo' ?>">
        </div>

        <?php if (!isset($editUser)): ?>
          <div class="col-md-2">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            <small class="text-muted">Obrigatória ao criar.</small>
          </div>
        <?php endif; ?>

        <div class="col-md-2">
          <label class="form-label">Admin</label>
          <select name="is_admin" class="form-select">
            <option value="0" <?= isset($editUser) && !$editUser->getIsAdmin() ? 'selected' : '' ?>>Não</option>
            <option value="1" <?= isset($editUser) && $editUser->getIsAdmin() ? 'selected' : '' ?>>Sim</option>
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label">Verificado</label>
          <select name="is_verified" class="form-select">
            <option value="0" <?= isset($editUser) && !$editUser->getIsVerified() ? 'selected' : '' ?>>Não</option>
            <option value="1" <?= isset($editUser) && $editUser->getIsVerified() ? 'selected' : '' ?>>Sim</option>
          </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-success w-100" type="submit"><?= isset($editUser) ? 'Atualizar' : 'Salvar' ?></button>
        </div>

        <?php if (isset($editUser)): ?>
          <div class="col-md-2 d-flex align-items-end">
            <a href="/users" class="btn btn-outline-secondary w-100">Cancelar</a>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Lista de Users</h5>
      <input type="text" class="form-control w-25" placeholder="Pesquisar...">
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Admin</th>
              <th>Email</th>
              <th>Telefone</th>
              <th>Estado</th>
              <th>Verificado</th>
              <th>Data Registo</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getNome() ?></td>
                <td><?= $user->getIsAdmin() ? 'Sim' : 'Não' ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getTelefone() ?></td>
                <td><?= $user->getEstado() ?></td>
                <td><?= $user->getIsVerified() ? 'Sim' : 'Não' ?></td>
                <td><?= $user->getDataResgito() ?></td>
                <td class="text-nowrap">
                  <a class="btn btn-sm btn-success" href="/users/edit?id=<?= $user->getId() ?>"><i class="bi bi-pencil"></i> Editar</a>
                  <form method="POST" action="/users/delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
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
