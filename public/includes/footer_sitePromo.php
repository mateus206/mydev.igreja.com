<!-- FOOTER -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">

        <h5 class="mb-2">Churches+</h5>
        <p class="mb-2">Conectando comunidades e ações solidárias.</p>

        <small>© 2026 Churches+ - Todos os direitos reservados</small>

    </div>
</footer>
<?php if (!empty($_SESSION["toast"])): ?>
    <div class="container mt-3">
        <div class="alert alert-<?= $_SESSION["toast"]["type"] === "success" ? "success" : "danger" ?>" role="alert">
            <?= $_SESSION["toast"]["message"] ?>
        </div>
    </div>
    <?php unset($_SESSION["toast"]); ?>
<?php endif; ?>

</body>
</html>