<h1>Home</h1>
<h2 class="mb-4">Recent Movies</h2>

<div class="row justify-content-center">


    <?php foreach ($recentMovies as $movie): ?>

        <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 mb-4">

            <a class="text-decoration-none text-dark" href="<?= BASE_URL . "movie?id=" . $movie["id"] ?>">
                <div class="card h-100">
                    <img
                        src="<?= htmlspecialchars($movie["image_url"]) ?>"
                        class="card-img-top"
                        alt="<?= htmlspecialchars($movie["title"]) ?>"
                        onerror="this.onerror=null; this.src='<?= ASSETS_URL ?>view/style/default.png';">

                    <div class="card-body">
                        <h6 class="card-title">
                            <?= htmlspecialchars($movie["title"]) ?>
                        </h6>

                        <p class="card-text">

                            ⭐ <?= round($movie["avg_rating"], 1) ?>/10

                            <br>

                            <?= $movie["review_count"] ?> reviews

                        </p>

                    </div>

                </div>
            </a>

        </div>

    <?php endforeach; ?>
    <div class="text-end">
        <a class="text-decoration-none text-dark" href="<?= BASE_URL . "movies" ?>"> See all movies</a>
    </div>
</div>

<h2 class="mb-4">Top Rated Movies</h2>

<div class="row justify-content-center">

    <?php foreach ($bestMovies as $movie): ?>

        <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 mb-4">

            <a class="text-decoration-none text-dark" href="<?= BASE_URL . "movie?id=" . $movie["id"] ?>">
                <div class="card h-100">
                    <img
                        src="<?= htmlspecialchars($movie["image_url"]) ?>"
                        class="card-img-top"
                        alt="<?= htmlspecialchars($movie["title"]) ?>"
                        onerror="this.onerror=null; this.src='<?= ASSETS_URL ?>view/style/default.png';">

                    <div class="card-body">
                        <h6 class="card-title">
                            <?= htmlspecialchars($movie["title"]) ?>
                        </h6>

                        <p class="card-text">

                            ⭐ <?= round($movie["avg_rating"], 1) ?>/10

                            <br>

                            <?= $movie["review_count"] ?> reviews

                        </p>

                    </div>

                </div>
            </a>

        </div>

    <?php endforeach; ?>

    <div class="text-end">
        <a class="text-decoration-none text-dark" href="<?= BASE_URL . "movies" ?>"> See all movies</a>
    </div>
</div>