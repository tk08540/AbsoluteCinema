<?php

require_once("model/MovieModel.php");
require_once("ViewHelper.php");

class MovieController{

    public static function getHome() {
        $recentMovies = MovieModel::getLatest();
        
        $bestMovies = MovieModel::getRated();

        ViewHelper::render("view/home.php", ["recentMovies" => $recentMovies, "bestMovies" => $bestMovies]);
        
    }


    public static function getDetails($id, $error = ""){
        $movie = MovieModel::get($id);
        
        $reviews = ReviewModel::getByMovie($movie["id"]);

        if (AuthHelper::isLoggedIn()) {
            $userReview = ReviewModel::getByUserAndByMovie($id, $_SESSION["user"]["id"]);
        } else {
            $userReview = null;
        }

        ViewHelper::render("view/movie-details.php", ["movie" => $movie, "reviews" => $reviews, "userReview" => $userReview, "error" => $error]);
    }

    

    

    //prikaze edit vnos
    public static function showEditForm($id) {
        //mora biti admin
        if (!AuthHelper::isAdmin()) {
            ViewHelper::error403();
            return;
        }
        $movie = MovieModel::get($id);

        ViewHelper::render("view/movie-edit.php", ["movie" => $movie]);
    }

    //dejansko izvede spremembo podatkov
    public static function updateMovie() {
        //mora biti admin
        if (!AuthHelper::isAdmin()) {
            ViewHelper::error403();
            return;
        }

        //filtriramo pred skodljivimi vnosi
        $rules = [
            "id" => FILTER_VALIDATE_INT,
            "title" => FILTER_SANITIZE_SPECIAL_CHARS,
            "release_year" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1880, "max_range" => date("Y")]
            ],
            "genre" => FILTER_SANITIZE_SPECIAL_CHARS,
            "image_url" => FILTER_SANITIZE_SPECIAL_CHARS 
        ];


        //ce je napaka vrzemo error - legitimen uporabnik naj ne bi prisel do te tocke
        $data = filter_input_array(INPUT_POST, $rules);
        
        foreach ($data as $d) {
            if ($d === false) {
                ViewHelper::error400("Invalid data");
                return;
            }
        }
        //prefiltriramo description - dovolimo da admin uporablja html, vendar samo te značke
        $data["description"] = trim(strip_tags($_POST["description"] ?? "", "<b><i><p><br><ul><li>"));

        //Ce je karkoli prazno je tudi napaka
        if (empty($data["id"]) || empty($data["title"]) || empty($data["description"]) || empty($data["genre"]) || empty($data["release_year"]) || empty($data["image_url"])) {
            ViewHelper::error400("Invalid data");
            return;
        }

        //ce pa je vse to izpolnjeno potem loh shranimo
        MovieModel::update($data["id"], $data["title"], $data["description"], $data["genre"], $data["release_year"], $data["image_url"]);
        ViewHelper::redirect(BASE_URL . "movie?id=" . $data["id"]);
    }



    public static function deleteMovie($id) {
        //mora biti admin
        if (!AuthHelper::isAdmin()) {
            ViewHelper::error403();
            return;
        }

        MovieModel::delete($id);


        ViewHelper::redirect(BASE_URL . "movies");
        
    }
    //prikaze add vnos
    public static function showAddForm($movie = null){
        //mora biti admin
        if (!AuthHelper::isAdmin()) {
            ViewHelper::error403();
            return;
        }
        if($movie == null) {
            $movie = ["title" => "", "description" => "", "genre" => "", "release_year" => date("Y"), "image_url" => ""];
        }


        ViewHelper::render("view/movie-add.php", ["movie" => $movie]);
    }

    public static function addMovie() {
        //mora biti admin
        if (!AuthHelper::isAdmin()) {
            ViewHelper::error403();
            return;
        }

        //filtriramo pred skodljivimi vnosi
        $rules = [
            "title" => FILTER_SANITIZE_SPECIAL_CHARS,
            "release_year" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1880, "max_range" => date("Y")]
            ],
            "genre" => FILTER_SANITIZE_SPECIAL_CHARS,
            "image_url" => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        


        //ce je napaka vrzemo error - legitimen uporabnik naj ne bi prisel do te tocke
        $data = filter_input_array(INPUT_POST, $rules);

        foreach ($data as $d) {
            if ($d === false) {
                ViewHelper::error400("Invalid data");
                return;
            }
        }

        //prefiltriramo description - dovolimo da admin uporablja html, vendar samo te značke
        $data["description"] = trim(strip_tags($_POST["description"] ?? "", "<b><i><p><br><ul><li>"));

        //Ce je karkoli prazno je tudi napaka
        if (empty($data["title"]) || empty($data["description"]) || empty($data["genre"]) || empty($data["release_year"]) || empty($data["image_url"])) {
            ViewHelper::error400("Invalid data");
            return;
        }

        //ce pa je vse to izpolnjeno potem loh shranimo - dobimo id zadnjega filma
        $id = MovieModel::insert( $data["title"], $data["description"], $data["genre"], $data["release_year"], $data["image_url"]);
        ViewHelper::redirect(BASE_URL . "movie?id=" . $id);
    }

    //prikaze vse filme ni iskalnega niza, drugače samo ujemajoče
    public static function showMovies() {

        if(isset($_GET["search"]) && !empty($_GET["search"])) {
            $movies = MovieModel::search($_GET["search"]);
        } else {
            $movies = MovieModel::getAll();
        }
        ViewHelper::render("view/movies-search.php", ["movies" => $movies, "search" => $_GET["search"] ?? ""]);
    }

}