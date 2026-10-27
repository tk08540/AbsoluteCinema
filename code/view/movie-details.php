<div class="container mt-4">

    <div class="row">

        <!-- na levi strani je slika  -->
        <div class="col-md-4">
            <img src="<?= htmlspecialchars($movie["image_url"]) ?>" class="img-fluid rounded mb-3" onerror="this.onerror=null; this.src='<?= ASSETS_URL ?>view/style/default.png';">
        </div>

        <!-- na desni so informacije  -->
        <div class="col-md-8">

            <h2><?= htmlspecialchars($movie["title"]) ?></h2>

            <h5>
                ⭐ <?= round($movie["avg_rating"], 1) ?>/10
                (<?= $movie["review_count"] ?> reviews)
            </h5>

            <p><?= $movie["description"] ?></p>

            <p>
                <strong>Genre:</strong> <?= htmlspecialchars($movie["genre"]) ?><br>
                <strong>Year:</strong> <?= $movie["release_year"] ?>
            </p>

            <!-- moznost urejanja če si admin -->
            <?php if (AuthHelper::isAdmin()): ?>
                <div class="d-flex gap-2">
                    <!--za to da sta v isti vrstici ju ovijemo-->
                    <a href="<?= BASE_URL ?>movie/edit?id=<?= $movie["id"] ?>"
                        class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form method="POST" action="<?= BASE_URL ?>movie/delete">
                        <input type="hidden" name="id" value="<?= $movie["id"] ?>" required>

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this movie?')">
                            Delete
                        </button>
                    </form>

                </div>
            <?php endif; ?>
        </div>


        <hr>

        <h4>Your review</h4>

        <?php
        //ce je prijavljen  in nima reviwa se pojavi direktno form za review
        if (AuthHelper::isLoggedIn()): ?>

            <?php if (!$userReview) : ?>
                <form method="POST" action="<?= BASE_URL . "review-submit" ?>">

                    <input type="hidden" name="movie_id" value="<?= $movie["id"] ?>">

                    <div class="mb-2">

                        <div class="star-rating">
                            <?php for ($i = 10; $i >= 1; $i--): ?>

                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>">

                                <!-- naredimo zvezdico z vsako vrednostjo da bo posredovalo strežniku-->
                                <label for="star<?= $i ?>">★</label>

                            <?php endfor; ?>
                        </div>

                    </div>

                    <textarea name="review_text" class="form-control mb-2" placeholder="Write review..." oninput="autoGrow(this)"></textarea>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <!--DA STA V ISTI VRSTICI -->
                        <button class="btn btn-primary btn-sm px-2 py-1">
                            Submit review
                        </button>

                        <?php if (!empty($error)) { ?>
                            <p class="text-danger mb-0"><?= htmlspecialchars($error) ?></p>
                        <?php } ?>

                    </div>

                </form>
            <?php
            //drugače pa se pokaze njegov review, za editanje ima skriti del
            else: ?>

                <div class="card border-primary mb-3">
                    <!-- id se uporabi za to da se tukaj edit form pojavi in ni treba relodat strani -->
                    <div class="card-body" id="review-view-<?= $userReview['id'] ?>">
                        <h6 class="card-title text-primary">You already rated this movie:</h6>

                        <strong>⭐ <?= $userReview["rating"] ?>/10</strong>
                        <p class="card-text"><?= htmlspecialchars($userReview["review_text"]) ?></p>
                        <small class="text-muted">Posted on: <?= date("d.m.Y H:i", strtotime($userReview["created_at"])) ?></small>


                        <div class="d-flex gap-2">
                            <button onclick="showEdit(<?= $userReview['id'] ?>)" class="btn btn-sm btn-warning">
                                Edit
                            </button>
                            <!-- form za delete - prenesemo podatke in jih zbrisemo-->
                            <form method="POST" action="<?= BASE_URL . "review-delete" ?>"
                                onsubmit="return confirm('Are you sure you want to delete this review?')"
                                class="d-inline">

                                <input type="hidden" name="review_id" value="<?= $userReview['id'] ?>" required>

                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>

                            </form>
                        </div>

                    </div>

                    <!-- zdej pa se skriti del-->
                    <div id="review-edit-<?= $userReview['id'] ?>" style="display:none;">
                        <form method="POST" action="<?= BASE_URL . "review-update" ?>">

                            <input type="hidden" name="review_id" value="<?= $userReview["id"] ?>" required>
                            <input type="hidden" name="movie_id" value="<?= $movie["id"] ?>" required>

                            <div class="star-rating">
                                <?php for ($i = 10; $i >= 1; $i--): ?>

                                    <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required <?php if ($i == $userReview["rating"]) {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>

                                    <!-- tisti ki je enaka vrednost se pripise checked - postane izbrana -->
                                    <label for="star<?= $i ?>">★</label>

                                <?php endfor; ?>
                            </div> <br>

                            <textarea name="review_text" class="form-control mb-2" oninput="autoGrow(this)"><?= htmlspecialchars($userReview["review_text"]) ?></textarea>

                            <button class="btn btn-sm px-2 py-1 btn-primary mb-3">Save</button>

                            <button type="button" onclick="hideEdit(<?= $userReview['id'] ?>)" class="btn btn-sm px-2 py-1 btn-secondary mb-3">Cancel</button>

                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>

            <p>
                Please <a href="<?= BASE_URL ?>login">login</a> to rate this movie.
            </p>

        <?php endif; ?>

        <hr>

        <?php
        $filteredReviews = [];
        //gremo cez vse reviewe in odstranimo od trenutnega uporabnika
        foreach ($reviews as $r) {
            if (AuthHelper::isLoggedIn() && $_SESSION["user"]["id"] == $r["user_id"]) {
                continue;
            }
            $filteredReviews[] = $r;
        }


        ?>
        <h4>Reviews</h4>


        <?php if (empty($reviews)) { ?>
            <p>There are no other reviews for this movie yet.</p>

        <?php } elseif (empty($filteredReviews)) { ?>
            <p>There are no other reviews for this movie yet.</p>
        <?php } else { ?>
            <?php foreach ($filteredReviews as $rev): ?>

                <div class="border p-2 mb-2 shadow-sm rounded-3">
                    ⭐ <?= $rev["rating"] ?>/10
                    <a href="<?= BASE_URL . "user?id=" . $rev["user_id"] ?>" class="user-link"><strong><?= htmlspecialchars($rev["username"]) ?></strong></a>
                    <p><?= htmlspecialchars($rev["review_text"]) ?></p>
                    <small class="text-muted"><?= date("d.m.Y H:i", strtotime($rev["created_at"])) ?></small>
                </div>

            <?php endforeach; ?>
        <?php } ?>
    </div>
</div>