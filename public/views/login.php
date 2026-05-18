<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador - igrejas+</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ADICIONA ISTO -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #a7c7ff, #d6e6ff);
            /* baby blue */
            min-height: 100vh;
        }

        .full-height {
            min-height: 100vh;
        }

        .login-box {
            width: 400px;
            border-radius: 15px;
        }

        .logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .btn-primary {
            background-color: #5dade2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #3498db;
        }

        .form-control:focus {
            border-color: #5dade2;
            box-shadow: 0 0 5px rgba(93, 173, 226, 0.5);
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center full-height">

        <div class="bg-white p-4 shadow login-box text-center">

            <!-- LOGO -->
            <div class="mb-3">
                <img src="../assets/img/logo-igrejas.png" alt="Logo Igrejas+" class="logo">
            </div>

            <h3 class="mb-1">Admin Login</h3>
            <p class="mb-4 fw-bold" style="color:#5dade2; font-size: 1.5rem;">Churches+</p>

            <!-- FORMULÁRIO -->
            <form class="text-start" method="POST" action="/login">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password"
                        placeholder="Enter your password">
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

        </div>

    </div>

  <!-- Antes do </body> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 
    <script>
        const toast = <?= json_encode($_SESSION["toast"] ?? null) ?>;
        <?php unset($_SESSION['toast']); ?>
        if (toast) {
            toastr[toast.type](toast.message);
        }
    </script>
 
</body>
 
</html>