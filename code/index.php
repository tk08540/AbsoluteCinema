<?php

    //začetek seje
    session_start();

    require_once("controller/MovieController.php");
    require_once("controller/AuthController.php");
    require_once("controller/ReviewController.php");

    //enako kot pri vajah deklariramo globalno spremenljivko z nasim base urljem
    define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/"); //na koncu damo /da je kot imenik - index.php/bova poskusila izklopiti na koncu

    //okej ker ima base_url notri se index.php za assete - css , js potrebujeva brez tega bova definirala se eno spremenljivko
    define("ASSETS_URL", str_replace("index.php/", "", BASE_URL));


    //$_SERVER["SCRIPT_NAME"] = vse za localhost do trenutne scripte
    //$_SERVER["PATH_INFO"] = del urlja za skripto

    //definiramo se spremenljivko path po /index.php/ z odstranjenimi vodilinimi in zakljucinim slashi
    $path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

    //asociativno polje, kjer so kljuci urlji in vrednosti funkcije, ki se bodo poklicale
    $urls = [
        "home" => function () {
            MovieController::getHome();
        },
        "" => function () {
            ViewHelper::redirect(BASE_URL . "home");
        },
        "movie" => function () {
            //da se izgonemu ce je brez ali pa da je sam neke bedarije napisal
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                ViewHelper::error404();
                return;
            }
            
            MovieController::getDetails($_GET["id"]);
        },
        "review-submit" => function () {
            ReviewController::postAReview();
        },
        "review-update" => function(){
            ReviewController::editAReview();
        },
        "review-delete" => function () {
            ReviewController::deleteAReview();
        },
        "movie/edit" => function () {
        //da se izgonemu ce je brez ali pa da je sam neke bedarije napisal
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                ViewHelper::error404();
                return;
            }

            MovieController::showEditForm($_GET["id"]);
        },
        "movie/delete" => function () {
            //da se izgonemu ce je brez ali pa da ni stevilka
            if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
                ViewHelper::error400("Invalid id.");
                return;
            }
            MovieController::deleteMovie($_POST["id"]);
        },
        
        "movie-update" => function() {
            MovieController::updateMovie();
        },
        "movie/add" => function() {
            MovieController::showAddForm();
        },
        "movie-insert" => function () {
            MovieController::addMovie();
        },

        "movies" => function() {
            MovieController::showMovies();
        },
        "user" => function () {
            //da se izgonemu ce je brez ali pa da je sam neke bedarije napisal
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                ViewHelper::error404();
                return;
            }
            
            AuthController::getDetails($_GET["id"]);
        },
        "login" => function () {
            //preveri ali je prijavljen če ni bo exital
            AuthHelper::requireGuest();
            AuthController::showLoginForm();
        },
        "login-submit" => function() {
            AuthController::login();
        },
        "register" => function () {
            //preveri ali je prijavljen če ni bo exital
            AuthHelper::requireGuest();
            AuthController::showRegisterForm();
        },
        "register-submit" => function () {
            AuthController::register();
        },
        "logout" => function () {
            AuthHelper::requireLogin();
            AuthController::logout();
        }
    ];

    //dejanski router ki pogleda url ce je definiran in sprozi funkcijo, drugače vrne error
    try {
        if (isset($urls[$path])) {
            //izvedemo klic funkcije
            $urls[$path]();
        } else {
            ViewHelper::error404();
        }
    } catch (Exception $e) {


        //samo za debugiranje potem zamenjaj
        ViewHelper::error500($e->getMessage());

        //ViewHelper::error500("An internal error occurred.");

    
    } finally {
        exit();
    }

?>