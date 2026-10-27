<div class="container mt-4">
    <form method="POST" action="<?= BASE_URL . "movie-update" ?>">
        <div class="row">

            <!-- na levi strani je slika  -->

            <div class="col-md-4">
                <!--okej bomo s js poskusili narediti da se slika v realtimu spremeni, tuki rabmo dodati id-->
                <img id="image_preview" src="<?= htmlspecialchars($movie["image_url"]) ?>" class="img-fluid rounded mb-3" onerror="this.onerror=null; this.src='<?= ASSETS_URL ?>view/style/default.png'" data-default="<?= ASSETS_URL ?>view/style/default.png">
            </div>

            <!-- na desni so informacije  -->
            <div class="col-md-8">

                <input type="hidden" name="id" value="<?= $movie["id"] ?>" required>
                <p><label for="title">Title: </label>
                    <input type="text" name="title" id="title" value="<?= $movie["title"] ?>" required class="form-control mb-2">
                </p>

                <p>
                    ⭐ <?= round($movie["avg_rating"], 1) ?>/10
                    (<?= $movie["review_count"] ?> reviews)
                </p>

                <p>Description: </p>
                <textarea name="description" class="form-control mb-2" oninput="autoGrow(this)" required><?= htmlspecialchars($movie["description"]) ?></textarea>

                <p>
                    <label for="genre">Genre:</label>
                    <input type="text" name="genre" id="genre" value="<?= $movie["genre"] ?>" required class="form-control mb-2">
                </p>

                <p>
                    <label for="year">Year:</label>
                    <input type="number" name="release_year" id="year" value="<?= $movie["release_year"] ?>" required class="form-control mb-2" min="1880"
                        max="<?= date('Y') ?>">
                </p>
                <p>
                    <label for="url">Poster url:</label>
                    <input type="text" name="image_url" id="url" value="<?= $movie["image_url"] ?>" required class="form-control mb-2" oninput="previewPoster()">
                </p>

                <button class="btn btn-sm px-2 py-1 btn-primary mb-3">Save</button>

                <button type="button" onclick="history.back()"
                    class="btn btn-sm btn-secondary mb-3">
                    Cancel
                </button>
            </div>

        </div>
    </form>
</div>