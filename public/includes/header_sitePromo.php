<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Churches+</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style_homepage.css" rel="stylesheet">


    <style>
        .menu-checkbox {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .navbar-toggler-label {
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            #menuNavbar {
                display: none;
            }

            #menuNavbarToggle:checked ~ #menuNavbar {
                display: block;
            }
        }
    </style>

</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top shadow">
    <div class="container">
        <a class="navbar-brand text-center fw-bold" href="#inicio">
            <img src="../assets/img/logo_igreja.png" width="100">
            <div>Churches+</div>
        </a>

        <input type="checkbox" id="menuNavbarToggle" class="menu-checkbox">
        <label class="navbar-toggler navbar-toggler-label" for="menuNavbarToggle" role="button" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </label>

        <div class="collapse navbar-collapse" id="menuNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#inicio">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#funcionalidades">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#equipa">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="#software">Software</a></li>
                <li class="nav-item"><a class="nav-link" href="#linguagens">Languages</a></li>
                <li class="nav-item"><a class="nav-link" href="#contacto">Contact</a></li>
                <li class="nav-button"><a class="nav-link btn btn-primary text-white px-4" href="login">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<div style="height:80px;"></div>