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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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