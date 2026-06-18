<!DOCTYPE html>
<html lang="pt" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Igreja+ Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    .sidebar-checkbox {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }

    .sidebar-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1040;
    }

    #sidebarToggle:checked ~ .sidebar-backdrop {
      display: block;
    }

    #sidebarToggle:checked ~ #sidebar {
      transform: none;
      visibility: visible;
    }

    .hamburger-label {
      cursor: pointer;
    }
  </style>
</head>

<body>

  <input type="checkbox" id="sidebarToggle" class="sidebar-checkbox">
  <label for="sidebarToggle" class="sidebar-backdrop"></label>

  <!-- NAVBAR -->
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">

      <!-- HAMBURGER -->
      <label class="btn btn-outline-light hamburger-label" for="sidebarToggle" role="button" aria-label="Abrir menu">
        <i class="fa-solid fa-bars"></i>
      </label>

      <a class="navbar-brand fw-bold ms-2" href="/dashboard">Igreja+</a>

      <div class="ms-auto d-flex align-items-center gap-3">

        <span class="text-white">
          <i class="fa-solid fa-user"></i> Admin
          <?php if(AuthMiddlewareWeb::isLogin()): ?>
              <a class="nav-link">
                <?= $_SESSION['token']['email'] ?>
              </a>
            <?php endif; ?>
        </span>

        <ul class="navbar-nav flex-row gap-3">
          <li class="nav-item">
            <a class="nav-link text-white" href="/dashboard">Dashboard</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="/users">Users</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="/eventos">Eventos</a>
          </li>
        </ul>

      </div>


    </div>
  </nav>

  <!-- SIDEBAR OFFCANVAS -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar">

    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Painel Admin</h5>
      <label for="sidebarToggle" class="btn-close" role="button" aria-label="Fechar menu"></label>
    </div>

    <div class="offcanvas-body">

      <div class="list-group">

        <a href="/dashboard" class="list-group-item list-group-item-action active">
          <i class="fa-solid fa-gauge"></i> Dashboard
        </a>

        <a href="/users" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-users"></i> Users
        </a>

        <a href="/eventos" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-calendar"></i> Eventos
        </a>

        <a href="/apoio-sociais" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-hand-holding-heart"></i> Apoio Social
        </a>

        <a href="/pedido-oracoes" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-pray"></i> Pedidos de Oração
        </a>

        <a href="/acao-solidarias" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-image"></i> Ação Solidária
        </a>

      </div>

      <form action="/logout" method="POST" class="mt-4">
        <button class="btn btn-danger w-100" type="submit">Logout</button>
      </form>

    </div>
  </div>