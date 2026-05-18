<!-- FOOTER -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">

        <h5 class="mb-2">Churches+</h5>
        <p class="mb-2">Conectando comunidades e ações solidárias.</p>

        <small>© 2026 Churches+ - Todos os direitos reservados</small>

    </div>
</footer>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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