<footer class="bg-info text-white py-3">
  <div class="container-fluid px-4">
    <div class="row align-items-center">
      <div class="col-md-6 mb-2 mb-md-0">
        <span class="fw-semibold text-white">Igrejas+ Admin</span>
        <span class="ms-2 text-white">&copy; 2026. All rights reserved.</span>
      </div>
      <div class="col-md-6 text-md-end">
        <a href="#" class="text-white text-decoration-none me-3">Support</a>
        <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
        <a href="#" class="text-white text-decoration-none">Terms of Use</a>
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