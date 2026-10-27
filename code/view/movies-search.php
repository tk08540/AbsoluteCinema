<h1>Movies</h1>
<div class="container mt-4">

    <div class="d-flex justify-content-center mb-4">

        <form method="GET" action="<?= BASE_URL ?>movies" class="col-md-6">

            <div class="input-group shadow-sm rounded-pill overflow-hidden">

                <input
                    type="text"
                    name="search"
                    class="form-control border-0 px-4"
                    placeholder="Search movies..."
                    value="<?= htmlspecialchars($search ?? "") ?>">

                <button class="btn btn-dark px-4" type="submit">
                    🔍︎
                </button>

            </div>

        </form>

    </div>

    <div class="row justify-content-center">

        <?php foreach ($movies as $movie) { ?>

            <div class="col-lg-8 col-md-10 mb-4">

                <a href="<?= BASE_URL . "movie?id=" . $movie["id"] ?>" class="text-decoration-none text-dark">

                    <div class="card shadow-sm h-100">
                        <div class="row g-0 align-items-center">

                            <!-- slika -->
                            <div class="col-md-4 text-center p-3" style="overflow:hidden; border-radius:12px;">
                                <img
                                    src="<?= htmlspecialchars($movie["image_url"]) ?>"
                                    class="movie-poster rounded"
                                    onerror="this.onerror=null; this.src='<?= ASSETS_URL ?>view/style/default.png';">

                            </div>

                            <!-- podatki -->
                            <div class="col-md-8 d-flex align-items-center">
                                <div class="card-body ms-4">

                                    <h3 class="card-title mb-3">
                                        <?= htmlspecialchars($movie["title"]) ?>
                                    </h3>
                                    <p class="mb-2 fs-5">
                                        ⭐ <?= round($movie["avg_rating"], 1) ?>/10
                                    </p>
                                    <p class="mb-2">
                                        <?= $movie["review_count"] ?> reviews
                                    </p>
                                    <p class="mb-2">
                                        <strong>Genre:</strong>
                                        <?= htmlspecialchars($movie["genre"]) ?>
                                    </p>

                                    <p class="mb-0">
                                        <strong>Year:</strong>
                                        <?= $movie["release_year"] ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>

</div>