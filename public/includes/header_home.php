<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Central Church Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

  <!-- Navbar / Header com menu hamburger -->
  <nav class="navbar bg-info">
    <div class="container-fluid px-3">
      <a class="navbar-brand text-white fw-bold" href="dashboard.html">
        <i class="bi bi-church me-2"></i> Churches +
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <i class="bi bi-list text-white fs-3"></i>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav mt-2 mb-1">
          <li class="nav-item">
            <a class="nav-link text-white-50" href="/dashboard">
              <i class="bi bi-people me-1"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white-50" href="/membros">
              <i class="bi bi-people me-1"></i> Members
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white-50" href="/eventos ">
              <i class="bi bi-calendar-event me-1"></i> Events
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white-50" href="/ativos">
              <i class="bi bi-wallet2 me-1"></i> Active / Inactive
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white-50" href="/utilizadores">
              <i class="bi bi-people me-1"></i> Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white-50" href="/campanhas">
              <i class="bi bi-megaphone me-1"></i> Campaigns
            </a>
          </li>
          <form action = "/logout" method="POST" class="d-flex mt-2">
            <button class="btn btn-outline-light w-100">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
          </form>
        </ul>
      </div>

    </div>
  </nav>