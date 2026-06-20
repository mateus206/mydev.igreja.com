<?php include __DIR__ . "/../includes/header_home.php"; ?>

<main class="container-fluid p-4 flex-grow-1">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Notificações</h2>
      <p class="text-muted mb-0">Envio e gestão de avisos para os membros</p>
    </div>
    <a href="/dashboard" class="btn btn-outline-secondary">voltar</a>
  </div>

  <div class="card mb-4">
    <div class="card-header"><h5 class="mb-0"><?= isset($editNotificacao) ? 'Editar Notificação' : 'Nova Notificação' ?></h5></div>
    <div class="card-body">
      <form method="POST" action="<?= isset($editNotificacao) ? '/notificacoes/update' : '/notificacoes/store' ?>" class="row g-3 mb-0">
        <?php if (isset($editNotificacao)): ?><input type="hidden" name="id" value="<?= $editNotificacao['id'] ?>"><?php endif; ?>
        <div class="col-md-3"><label class="form-label">Utilizador</label><select name="id_user" class="form-select"><option value="">Todos os utilizadores</option><?php foreach ($users as $user): ?><option value="<?= $user->getId() ?>" <?= isset($editNotificacao) && (string)$user->getId() === (string)($editNotificacao['id_user'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($user->getNome()) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-3"><label class="form-label">Título</label><input name="titulo" class="form-control" value="<?= htmlspecialchars($editNotificacao['titulo'] ?? '') ?>" required></div>
        <div class="col-md-2"><label class="form-label">Tipo</label><input name="tipo" class="form-control" value="<?= htmlspecialchars($editNotificacao['tipo'] ?? 'Geral') ?>"></div>
        <div class="col-md-2"><label class="form-label">Lida</label><select name="lida" class="form-select"><option value="0" <?= isset($editNotificacao) && (int)$editNotificacao['lida'] === 0 ? 'selected' : '' ?>>Não</option><option value="1" <?= isset($editNotificacao) && (int)$editNotificacao['lida'] === 1 ? 'selected' : '' ?>>Sim</option></select></div>
        <div class="col-md-10"><label class="form-label">Mensagem</label><textarea name="mensagem" class="form-control" required><?= htmlspecialchars($editNotificacao['mensagem'] ?? '') ?></textarea></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-success w-100" type="submit"><?= isset($editNotificacao) ? 'Atualizar' : 'Enviar' ?></button></div>
      </form>
    </div>
  </div>

  <div class="card"><div class="card-header"><h5 class="mb-0">Lista de Notificações</h5></div><div class="card-body p-0"><div class="table-responsive"><table class="table table-striped table-hover mb-0 align-middle"><thead><tr><th>ID</th><th>Destino</th><th>Título</th><th>Tipo</th><th>Mensagem</th><th>Lida</th><th>Ações</th></tr></thead><tbody><?php foreach ($notificacoes as $item): ?><tr><td><?= $item['id'] ?></td><td><?= $item['id_user'] ? htmlspecialchars($item['nome_user'] ?? ('User #' . $item['id_user'])) : 'Todos' ?></td><td><?= htmlspecialchars($item['titulo']) ?></td><td><?= htmlspecialchars($item['tipo']) ?></td><td><?= htmlspecialchars($item['mensagem']) ?></td><td><span class="badge text-bg-<?= (int)$item['lida'] === 1 ? 'success' : 'warning' ?>"><?= (int)$item['lida'] === 1 ? 'Sim' : 'Não' ?></span></td><td class="text-nowrap"><a class="btn btn-sm btn-success" href="/notificacoes/edit?id=<?= $item['id'] ?>"><i class="bi bi-pencil"></i> Editar</a> <form method="POST" action="/notificacoes/delete" style="display:inline;"><input type="hidden" name="id" value="<?= $item['id'] ?>"><button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i> Apagar</button></form></td></tr><?php endforeach; ?></tbody></table></div></div></div>
</main>

<?php include __DIR__ . "/../includes/footer_home.php"; ?>
