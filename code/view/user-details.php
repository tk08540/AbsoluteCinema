<div class="container mt-4">

    <div class="row">

        <!-- LEVO: PODATKI O UPORABNIKU -->
        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4 p-4 bg-light mb-4">

                <div class="text-center mb-3">

                    <div class="display-3">
                        👤
                    </div>

                    <h3 class="fw-bold">
                        <?= htmlspecialchars($user["username"]) ?>
                    </h3>

                </div>

                <p>📊 Reviews: <?= $stats["review_count"] ?></p>

                <p>⭐ Avg rating: <?= round($stats["avg_rating"], 1) ?></p>

            </div>

        </div>

        <!-- DESNO: REVIEWI -->
        <div class="col-md-8">

            <?php if (empty($reviews)) { ?>
                <p>There are no reviews from this user yet.</p>

            <?php } else { ?>
                <?php foreach ($reviews as $rev): ?>
                    <a href="<?= BASE_URL . "movie?id=" . $rev["movie_id"] ?>" class="text-decoration-none text-dark">
                        <div class="border p-2 mb-2 shadow-sm rounded-3">
                            <strong><?= htmlspecialchars($rev["title"]) ?></strong><br>
                            ⭐ <?= $rev["rating"] ?>/10

                            <p><?= htmlspecialchars($rev["review_text"]) ?></p>
                            <small class="text-muted"><?= date("d.m.Y H:i", strtotime($rev["created_at"])) ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php } ?>

        </div>

    </div>

</div>