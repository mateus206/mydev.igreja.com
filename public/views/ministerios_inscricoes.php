<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Inscrições em Ministérios</h2>
      <p class="text-muted mb-0">Membros que querem servir na igreja</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header"><h5 class="mb-0"><?= isset($editInscricao) ? 'Editar Inscrição' : 'Nova Inscrição' ?></h5></div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editInscricao) ? '/ministerios-inscricoes/update' : '/ministerios-inscricoes/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editInscricao)): ?><input type="hidden" name="id" value="<?= $editInscricao['id'] ?>"><?php endif; ?>

        <div class="col-md-3"><label class="form-label">Utilizador</label><select name="id_user" class="form-select" required><option value="">Selecione</option><?php foreach ($users as $user): ?><option value="<?= $user->getId() ?>" <?= isset($editInscricao) && $user->getId() == $editInscricao['id_user'] ? 'selected' : '' ?>><?= htmlspecialchars($user->getNome()) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-3"><label class="form-label">Ministério</label><select name="ministerio" class="form-select" required><?php $minAtual = $editInscricao['ministerio'] ?? ''; foreach (['Louvor','Intercessão','Multimédia','Receção','Crianças','Jovens','Ação Social','Evangelismo','Outro'] as $min): ?><option value="<?= $min ?>" <?= $minAtual === $min ? 'selected' : '' ?>><?= $min ?></option><?php endforeach; ?></select></div>
        <div class="col-md-3"><label class="form-label">Disponibilidade</label><input name="disponibilidade" class="form-control" value="<?= htmlspecialchars($editInscricao['disponibilidade'] ?? '') ?>"></div>
        <div class="col-md-2"><label class="form-label">Estado</label><select name="estado" class="form-select"><?php $estadoAtual = $editInscricao['estado'] ?? 'Pendente'; foreach (['Pendente','Aprovado','Recusado'] as $estado): ?><option value="<?= $estado ?>" <?= $estadoAtual === $estado ? 'selected' : '' ?>><?= $estado ?></option><?php endforeach; ?></select></div>
        <div class="col-md-5"><label class="form-label">Experiência</label><textarea name="experiencia" class="form-control"><?= htmlspecialchars($editInscricao['experiencia'] ?? '') ?></textarea></div>
        <div class="col-md-5"><label class="form-label">Mensagem</label><textarea name="mensagem" class="form-control"><?= htmlspecialchars($editInscricao['mensagem'] ?? '') ?></textarea></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-success w-100" type="submit"><?= isset($editInscricao) ? 'Atualizar' : 'Salvar' ?></button></div>
      </form>
    </div>
  </div>

  <div class="card"><div class="card-header"><h5 class="mb-0">Lista de Inscrições</h5></div><div class="card-body p-0"><div class="table-responsive"><table class="table table-striped table-hover mb-0 align-middle"><thead><tr><th>ID</th><th>Membro</th><th>Ministério</th><th>Disponibilidade</th><th>Estado</th><th>Mensagem</th><th>Ações</th></tr></thead><tbody><?php foreach ($inscricoes as $item): ?><tr><td><?= $item['id'] ?></td><td><?= htmlspecialchars($item['nome_user'] ?? ('User #' . $item['id_user'])) ?></td><td><?= htmlspecialchars($item['ministerio']) ?></td><td><?= htmlspecialchars($item['disponibilidade'] ?? '') ?></td><td><span class="badge text-bg-<?= $item['estado'] === 'Aprovado' ? 'success' : ($item['estado'] === 'Recusado' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($item['estado']) ?></span></td><td><?= htmlspecialchars($item['mensagem'] ?? '') ?></td><td class="text-nowrap"><a class="btn btn-sm btn-success" href="/ministerios-inscricoes/edit?id=<?= $item['id'] ?>"><i class="bi bi-pencil"></i> Editar</a> <form method="POST" action="/ministerios-inscricoes/delete" style="display:inline;"><input type="hidden" name="id" value="<?= $item['id'] ?>"><button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i> Apagar</button></form></td></tr><?php endforeach; ?></tbody></table></div></div></div>
</main>

<?php include __DIR__ . "/../includes/footer_home.php"; ?>
