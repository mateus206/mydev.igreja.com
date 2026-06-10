<?php
if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();

/** @var string $token — set by AuthController::verifyEmailForm() */
$token = $token ?? '';
?>
<!doctype html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Igrejas+ | Verificar Email</title>

  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'DM Sans', sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      background: #0b1220;
    }

    .left {
      flex: 1;
      background: linear-gradient(135deg, #185fa5, #0b2b4d);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px;
    }

    .left h1 {
      font-size: 34px;
      margin-bottom: 10px;
    }

    .left p {
      font-size: 15px;
      opacity: 0.85;
      line-height: 1.6;
      max-width: 400px;
    }

    .brand {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 30px;
    }

    .right {
      flex: 1;
      background: #f7f9fc;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .box {
      width: 100%;
      max-width: 420px;
      background: white;
      padding: 30px;
      border-radius: 14px;
      border: 1px solid #e6e6e6;
    }

    h2 {
      font-size: 20px;
      margin-bottom: 6px;
    }

    .subtitle {
      font-size: 13px;
      color: #666;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    label {
      font-size: 13px;
      margin-bottom: 6px;
      display: block;
      color: #444;
    }

    .field {
      margin-bottom: 14px;
    }

    input[type="password"] {
      width: 100%;
      padding: 11px;
      border-radius: 8px;
      border: 1px solid #ddd;
      outline: none;
      font-size: 14px;
    }

    input[type="password"]:focus {
      border-color: #185fa5;
    }

    button {
      width: 100%;
      margin-top: 4px;
      padding: 11px;
      background: #185fa5;
      border: none;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      font-size: 14px;
    }

    button:hover {
      opacity: 0.9;
    }

    .small {
      margin-top: 12px;
      font-size: 12px;
      color: #777;
      text-align: center;
    }

    .small a {
      color: #185fa5;
      text-decoration: none;
    }

    .footer {
      margin-top: 15px;
      font-size: 11px;
      color: #aaa;
      text-align: center;
    }

    @media (max-width: 900px) {
      body { flex-direction: column; }
      .left { display: none; }
    }
  </style>
</head>

<body>

  <!-- LEFT -->
  <div class="left">
    <div class="brand">Igrejas+</div>
    <h1>Bem-vindo à comunidade</h1>
    <p>
      Confirma o teu email para ativares a tua conta e começares a participar em igrejas,
      eventos e comunidades locais no Igrejas+.
    </p>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <div class="box">

      <h2>Verificação de Email</h2>
      <div class="subtitle">
        Define a tua password para ativares a conta.
      </div>

      <!-- CORRIGIDO: action aponta para POST /verify-email -->
      <form method="post" action="/verify-email">

        <!-- token oculto vindo do link de email -->
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <!-- CORRIGIDO: campo de password (era "code" mas o controller lia "password") -->
        <div class="field">
          <label>Nova password</label>
          <input type="password" name="password" minlength="6" placeholder="Mínimo 6 caracteres" required>
        </div>

        <div class="field">
          <label>Confirmar password</label>
          <input type="password" id="confirmPassword" placeholder="Repete a password" required>
        </div>

        <button type="submit">Ativar conta</button>
      </form>

      <div class="small">
        Não recebeste o link? <a href="/resend-verification">Reenviar email</a>
      </div>

      <div class="footer">
        Link válido por 10 minutos
      </div>

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    // Mostrar toast vindo da sessão (erros de verifyEmailSubmit)
    const toast = <?= json_encode($_SESSION['toast'] ?? null) ?>;
    <?php unset($_SESSION['toast']); ?>

    if (toast) {
      toastr[toast.type](toast.message);
    }

    // Validação client-side: confirmar que as passwords coincidem
    document.querySelector('form').addEventListener('submit', function (e) {
      const pw  = document.querySelector('input[name="password"]').value;
      const cpw = document.getElementById('confirmPassword').value;

      if (pw !== cpw) {
        e.preventDefault();
        toastr.error('As passwords não coincidem.');
      }
    });
  </script>

</body>
</html>