-- Active: 1779360747419@@127.0.0.1@3306@igreja_system
<?php include __DIR__ . "/../includes/header_home.php"; ?>

<body class="d-flex flex-column min-vh-100">

  <!-- NAVBAR + SIDEBAR vêm do header_home.php -->

  <!-- CONTENT -->
  <main class="container-fluid p-4 flex-grow-1">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

      <div>
        <h2>Users</h2>
        <p class="text-muted mb-0">Lista de utilizadores da Igreja+</p>
      </div>


    </div>



    <!-- TABLE -->
    <div class="card">

      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Users</h5>
        <input type="text" class="form-control w-25" placeholder="Pesquisar...">
      </div>

      <div class="card-body p-0">

        <div class="table-responsive">

          <table class="table table-striped table-hover mb-0">

            <thead>
              <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Is Admin</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Data Resgito</th>
                <th>Ações</th>
              </tr>
            </thead>

            <tbody>

              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= $user->getId() ?></td>
                  <td><?= $user->getNome() ?></td>

                  <td>
                    <?php if ($user->getIsAdmin()): ?>
                      <i class="fa-solid fa-user"></i>
                    <?php else: ?>
                      <i class="fa-regular fa-user"></i>
                    <?php endif; ?>
                  </td>

                  <td><?= $user->getEmail() ?></td>
                  <td><?= $user->getTelefone() ?></td>
                  <td><?= $user->getDataResgito() ?></td>

                  <td>
                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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