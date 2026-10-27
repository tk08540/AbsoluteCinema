<div class="d-flexalign-items-center vh-100">

    <div class="text-center">

        <h1 class="display-4 fw-bold text-danger">
            <?= $code ?>
        </h1>

        <h3 class="mb-3">
            <?= htmlspecialchars($title) ?>
        </h3>

        <p class="text-muted mb-4">
            <?= $message ?>
        </p>

        <a href="<?= BASE_URL ?>" class="btn btn-primary">
            Go home
        </a>

    </div>

</div>