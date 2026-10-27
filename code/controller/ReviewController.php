<?php
require_once("model/ReviewModel.php");
require_once("ViewHelper.php");

class ReviewController {

    public static function validateReviewData(){
        //da ustvaris review moras biti prijavljen -> ce gres na ta link in nisi prijavljen te vrze na login
        AuthHelper::requireLogin();

        //dobimo podatke iz obrazca -> treba preverit da so vsi nastavljeni in pravilni
        $movieId = $_POST["movie_id"] ?? "";
        $rating = $_POST["rating"] ?? 0;
        $text = trim($_POST["review_text"] ?? "");

        //id in rating morrata biti stevilka
        if (!is_numeric($movieId) || !is_numeric($rating)) {
            ViewHelper::error400("Invalid input");
            return null;
        }
        //če ga nismo dobil(ni izbral potem ga moramo na to opozoriti)
        if ($rating == 0) {
            //zlovdamo isto stran z errorjem
            MovieController::getDetails($movieId, "Please select a rating.");
            return null;
        }

        //rating mora biti med 1 in 10

        if ($rating < 1 || $rating > 10) {
            ViewHelper::error400("Rating must be between 1 and 10");
            return null;
        }
        $user = AuthHelper::getUser();
        return ["movie_id" => $movieId, "rating" => $rating, "text" => $text, "user_id" => $user["id"]];
    }

    public static function postAReview(){
        $data = self::validateReviewData();
        if ($data == null) {
            //ce se je nekaj zalomilo
            return;
        }
        //pogledamo da se nima ta uporabnik reviwa -> v bazi je unique, tako da v primeru napake bo nek sql eror, tukaj gre le za lepsi error
        $existing = ReviewModel::getByUserAndByMovie(
            $data["movie_id"],
            $data["user_id"]
        );

        if ($existing) {
            ViewHelper::error400("You already reviewed this movie.");
            return;
        }

        ReviewModel::insert($data["user_id"], $data["movie_id"], $data["rating"], $data["text"]);

        ViewHelper::redirect(BASE_URL . "movie?id=" . $data["movie_id"]);
    }

    public static function editAReview(){
        $data = self::validateReviewData();
        if ($data == null) {
            //ce se je nekaj zalomilo
            return;
        }
        $reviewId = $_POST["review_id"] ?? "";
        //pogledamo da je stevilka
        if (!is_numeric($reviewId)) {
            ViewHelper::error400("Invalid input");
            return;
        }

        //dobimo review
        $review = ReviewModel::get($reviewId);

        //pogledamo da obstaja
        if ($review == null) {
            ViewHelper::error400("Review not found");
            return;
        }
        //pogledamo ce je njegov - ima dovoljenje
        if ($review["user_id"] != $_SESSION["user"]["id"]) {
            ViewHelper::error403();
            return;
        }

        ReviewModel::update($reviewId, $data["rating"], $data["text"]);

        ViewHelper::redirect(BASE_URL . "movie?id=" . $data["movie_id"]);
    }

    public static function deleteAReview(){
        AuthHelper::requireLogin();
        $reviewId = $_POST["review_id"] ?? "";

        if (!is_numeric($reviewId)) {
            ViewHelper::error400("Invalid input");
            return;
        }
        //dobimo review
        $review = ReviewModel::get($reviewId);

        //pogledamo da obstaja
        if ($review == null) {
            ViewHelper::error400("Review not found");
            return;
        }
        //pogledamo ce je njegov - ima dovoljenje
        if ($review["user_id"] != $_SESSION["user"]["id"]) {
            ViewHelper::error403();
            return;
        }
        ReviewModel::delete($reviewId);

        ViewHelper::redirect(BASE_URL . "movie?id=" . $review["movie_id"]);
    }

}