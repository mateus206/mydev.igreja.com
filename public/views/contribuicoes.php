<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Dízimos e Ofertas</h2>
      <p class="text-muted mb-0">Gestão das contribuições enviadas pelos membros</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header"><h5 class="mb-0"><?= isset($editContribuicao) ? 'Editar Contribuição' : 'Nova Contribuição' ?></h5></div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editContribuicao) ? '/contribuicoes/update' : '/contribuicoes/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editContribuicao)): ?><input type="hidden" name="id" value="<?= $editContribuicao['id'] ?>"><?php endif; ?>

        <div class="col-md-3">
          <label class="form-label">Utilizador</label>
          <select name="id_user" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= $user->getId() ?>" <?= isset($editContribuicao) && $user->getId() == $editContribuicao['id_user'] ? 'selected' : '' ?>><?= htmlspecialchars($user->getNome()) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label">Tipo</label>
          <select name="tipo" class="form-select" required>
            <?php $tipoAtual = $editContribuicao['tipo'] ?? ''; foreach (['Dízimo','Oferta','Missões','Construção','Outro'] as $tipo): ?>
              <option value="<?= $tipo ?>" <?= $tipoAtual === $tipo ? 'selected' : '' ?>><?= $tipo ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label">Valor</label>
          <input type="number" step="0.01" min="0" name="valor" class="form-control" value="<?= $editContribuicao['valor'] ?? '' ?>" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Método</label>
          <select name="metodo_pagamento" class="form-select" required>
            <?php $metodoAtual = $editContribuicao['metodo_pagamento'] ?? ''; foreach (['MB Way','Transferência','Numerário','Outro'] as $metodo): ?>
              <option value="<?= $metodo ?>" <?= $metodoAtual === $metodo ? 'selected' : '' ?>><?= $metodo ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label">Estado</label>
          <select name="estado" class="form-select">
            <?php $estadoAtual = $editContribuicao['estado'] ?? 'Pendente'; foreach (['Pendente','Confirmado','Recusado'] as $estado): ?>
              <option value="<?= $estado ?>" <?= $estadoAtual === $estado ? 'selected' : '' ?>><?= $estado ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-10">
          <label class="form-label">Observação</label>
          <textarea name="observacao" class="form-control"><?= htmlspecialchars($editContribuicao['observacao'] ?? '') ?></textarea>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-success w-100" type="submit"><?= isset($editContribuicao) ? 'Atualizar' : 'Salvar' ?></button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><h5 class="mb-0">Lista de Contribuições</h5></div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead><tr><th>ID</th><th>Membro</th><th>Tipo</th><th>Valor</th><th>Método</th><th>Estado</th><th>Data</th><th>Ações</th></tr></thead>
          <tbody>
            <?php foreach ($contribuicoes as $item): ?>
              <tr>
                <td><?= $item['id'] ?></td>
                <td><?= htmlspecialchars($item['nome_user'] ?? ('User #' . $item['id_user'])) ?></td>
                <td><?= htmlspecialchars($item['tipo']) ?></td>
                <td><?= number_format((float)$item['valor'], 2, ',', '.') ?> €</td>
                <td><?= htmlspecialchars($item['metodo_pagamento']) ?></td>
                <td><span class="badge text-bg-<?= $item['estado'] === 'Confirmado' ? 'success' : ($item['estado'] === 'Recusado' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($item['estado']) ?></span></td>
                <td><?= $item['data_criacao'] ?? '' ?></td>
                <td class="text-nowrap">
                  <a class="btn btn-sm btn-success" href="/contribuicoes/edit?id=<?= $item['id'] ?>"><i class="bi bi-pencil"></i> Editar</a>
                  <form method="POST" action="/contribuicoes/delete" style="display:inline;"><input type="hidden" name="id" value="<?= $item['id'] ?>"><button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i> Apagar</button></form>
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
