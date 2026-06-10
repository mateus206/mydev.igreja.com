<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
 
$success = $_SESSION['flash_success'] ?? null;
$error   = $_SESSION['flash_error'] ?? null;
 
unset($_SESSION['flash_success'], $_SESSION['flash_error']);
?>
 
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
  <?php if ($success): ?>
    <div id="appToastSuccess" class="toast text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body"><?= htmlspecialchars($success) ?></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  <?php endif; ?>
 
  <?php if ($error): ?>
    <div id="appToastError" class="toast text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body"><?= htmlspecialchars($error) ?></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  <?php endif; ?>
</div>
 
<script>
  (function() {
    const opts = {
      delay: 3500
    };
    const s = document.getElementById('appToastSuccess');
    const e = document.getElementById('appToastError');
    if (s) bootstrap.Toast.getOrCreateInstance(s, opts).show();
    if (e) bootstrap.Toast.getOrCreateInstance(e, opts).show();
  })();
</script>