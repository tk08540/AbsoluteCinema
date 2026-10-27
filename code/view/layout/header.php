<!DOCTYPE html>
<html lang="en">

<?php $title = "Absolute Cinema" ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link rel="icon" type="image/x-icon" href="<?= ASSETS_URL ?>view/style/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>view/style/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark px-4 py-3">
        <!-- LEVO -->
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
            <?= $title ?>
        </a>
        <!-- HAMBURGER -->
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- DESNO -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto align-items-md-center gap-2">
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= BASE_URL ?>">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= BASE_URL ?>movies">
                        Movies
                    </a>
                </li>
                <?php if (AuthHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>movie/add"
                            class="nav-link text-light me-4">
                            Add movie
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (!AuthHelper::isLoggedIn()) { ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm"
                            href="<?= BASE_URL ?>login">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm text-dark"
                            href="<?= BASE_URL ?>register">
                            Register
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link text-light fw-semibold"
                            href="<?= BASE_URL ?>user?id=<?= $_SESSION["user"]["id"] ?>">
                            <?= htmlspecialchars($_SESSION["user"]["username"]) ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm"
                            href="<?= BASE_URL ?>logout">
                            Logout
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">