<?php include __DIR__ . '/../includes/header_home.php'; ?>

<!-- ===== CAMPANHAS ===== -->
<div id="page-campanhas" class="page-section">

    <div class="section-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0">Campanhas de Solidariedade</h1>
            <small class="text-muted">
                Gestão de todas as campanhas ativas e encerradas
            </small>
        </div>

        <div class="d-flex gap-2">
            <input type="text" class="form-control" placeholder="Pesquisar campanhas..." style="width:220px">
            <button class="btn btn-info text-white">+ Nova campanha</button>
        </div>
    </div>

    <div class="card">

        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <span class="fw-semibold">Todas as campanhas</span>
            <button class="btn btn-outline-secondary btn-sm">Exportar</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">

                <thead>
                    <tr>
                        <th>Nome da campanha</th>
                        <th>Datas</th>
                        <th>Descrição</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td class="fw-semibold">Banco Alimentar de Páscoa</td>
                        <td class="text-muted">1–20 Abr 2025</td>
                        <td>Recolha de alimentos não perecíveis para famílias carenciadas da região</td>
                        <td>
                            <span class="badge bg-success rounded-pill px-3 py-1">
                                Em curso
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">Roupa para o Inverno</td>
                        <td class="text-muted">1 Nov – 15 Dez 2024</td>
                        <td>Angariação de agasalhos e cobertores para pessoas sem-abrigo</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill px-3 py-1">
                                Encerrada
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">Fundo de Emergência Escolar</td>
                        <td class="text-muted">15 Fev – 30 Jun 2025</td>
                        <td>Apoio a crianças em carência para material escolar e propinas</td>
                        <td>
                            <span class="badge bg-success rounded-pill px-3 py-1">
                                Em curso
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">Apoio a Refugiados</td>
                        <td class="text-muted">1 Mar – 31 Mai 2025</td>
                        <td>Recolha de donativos e voluntariado para famílias refugiadas</td>
                        <td>
                            <span class="badge bg-success rounded-pill px-3 py-1">
                                Em curso
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">Natal Solidário 2024</td>
                        <td class="text-muted">1–24 Dez 2024</td>
                        <td>Angariação de prendas e brinquedos para crianças hospitalizadas</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill px-3 py-1">
                                Encerrada
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-semibold">Horta Comunitária</td>
                        <td class="text-muted">1 Mai – 31 Out 2025</td>
                        <td>Projeto de horta partilhada para idosos e famílias da paróquia</td>
                        <td>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1">
                                Agendada
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center p-3 border-top text-muted" style="font-size:.85rem">
            <span>A mostrar 1–6 de 22 campanhas</span>

            <ul class="pagination pagination-sm mb-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
            </ul>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer_home.php'; ?>