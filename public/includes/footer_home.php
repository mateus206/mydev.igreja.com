<!-- FOOTER -->
<footer class="bg-dark text-white mt-auto">

  <div class="container-fluid py-4">

    <div class="row">

      <div class="col-md-6">
        <h5>Igreja+</h5>
        <p class="mb-0">Sistema administrativo da igreja.</p>
      </div>

      <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <p class="mb-1">© 2026 Igreja+</p>
      </div>

    </div>

  </div>

</footer>

<?php if (!empty($_SESSION['toast'])): ?>
  <div class="container-fluid fixed-top mt-3" style="pointer-events: none;">
    <div class="row justify-content-end">
      <div class="col-md-4">
        <div class="alert alert-<?= $_SESSION['toast']['type'] === 'success' ? 'success' : 'danger' ?> shadow" role="alert">
          <?= $_SESSION['toast']['message'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['toast']); ?>
<?php endif; ?>

</body>
</html>
