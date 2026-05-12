<?php
include __DIR__ ."/../includes/header_home.php"; ?>

    <div class="container my-5">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Gestão de Ativos/Não Ativos</h2>
                <p class="text-muted">Cadastre e gerencie os ativos da sua instituição</p>
            </div>

            
            
        </div>

        <!-- BOTÃO ADICIONAR -->
        <div class="mb-4">
            <button class="btn btn-primary-custom text-black w-100 py-2">
                <i class="bi bi-plus"></i> Adicionar Ativo/Não Ativo
            </button>
        </div>

        <!-- CARD -->
        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="card-title mb-4">
                    Lista de Ativos
                    <small class="text-muted fs-6 fw-normal">4 ativos cadastrados</small>
                </h5>

                <!-- BUSCA -->
                <div class="input-group mb-4">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" class="form-control border-start-0"
                        placeholder="Filtrar por nome do ativo, categoria ou status...">
                </div>

                <!-- TABELA -->
                <div class="table-responsive">
                    <table class="table align-middle">

                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" class="form-check-input"></th>
                                <th>Ativo</th>
                                <th>Categoria</th>
                                <th>Localização</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td>Computador Dell</td>
                                <td>Informática</td>
                                <td>Departamento TI</td>
                                <td>
                                    <span class="badge bg-success badge-status">Ativo</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary me-2">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Apagar
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td>Projetor Epson</td>
                                <td>Equipamentos</td>
                                <td>Auditório</td>
                                <td>
                                    <span class="badge bg-danger badge-status">Inativo</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary me-2">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Apagar
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>