<?php include __DIR__ . "/../includes/header_login.php"; ?>
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
            <form id="loginForm" class="text-start">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>