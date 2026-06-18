<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$success = $_SESSION['flash_success'] ?? null;
$error   = $_SESSION['flash_error'] ?? null;

unset($_SESSION['flash_success'], $_SESSION['flash_error']);
?>

<?php if ($success): ?>
  <div class="alert alert-success" role="alert"><?= $success ?></div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="alert alert-danger" role="alert"><?= $error ?></div>
<?php endif; ?>
