<?php

require_once ("model/UserModel.php");
require_once("model/ReviewModel.php");
require_once ("ViewHelper.php");
require_once ("AuthHelper.php");

class AuthController {

    //pokaze pogled za prijavo -> da je lahko že izpolnjeno ko redirectamo
    public static function showLoginForm($variables = array("email" => "")) {
        ViewHelper::render("view/auth/login.php", $variables);
    }

    //izvede prijavo
    public static function login() {
        //najprej rabimo podatke dobiti iz zahtevka
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        //najdemo uporabnika
        $user = UserModel::getUserByEmail($email);

        //ce uporabnik ne obstaja
        if (!$user) {
            self::showLoginForm(array("email" => $email, "error" => "User with this email does not yet exist"));
            return;
            
        }
        //uporabnik obstaja, preverimo geslo
        if (password_verify($password, $user["password_hash"])) {
            //ce je uredu potem shranimo uporabnika v session in redirectamo domov
            $_SESSION["user"] = [
                "id" => $user["id"],
                "username" => $user["username"],
                "email" => $user["email"],
                "role" => $user["role"]
            ];
            ViewHelper::redirect(BASE_URL);

        } else {
            self::showLoginForm(array("email" => $email, "error" => "The password is incorrect"));
            return;
        }
    }


    //prikaz forma za registracijo
    public static function showRegisterForm($variables = array("email" => "", "username" => "")) {
        ViewHelper::render("view/auth/register.php", $variables);
    }
    //registracija
    public static function register() {
        //najprej dobimo spet vse podatke

        $username = trim($_POST["username"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";

        $validData = !empty($username) &&
                     !empty($email) &&
                     !empty($password);

        //ce mu je uspelo zaobiti preverjanje na spletni strani mu vrzemo ta error
        if (strlen($password) < 6) {
            ViewHelper::error400("Password too short. It must be at least 6 characters.");
            return;
        }





        //podledamo se pravilno obliko emaila - ce ni ga opozorimo
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            self::showRegisterForm([
                "email" => $email,
                "username" => $username,
                "error" => "Invalid email address."
            ]);

            return;
        }
        
        
        
        //pogledamo če ze obstaja tak uporabnik
        $user = UserModel::getUserByEmail($email);
        if ($user) {
            self::showRegisterForm(array("username" => $_POST["username"] ?? "", "email" => $_POST["email"] ?? "", "error" => "An account with this email already exists. Please log in instead."));
            return;
        }

        //pogledamo da je unique username
        $user = UserModel::getUserByUsername($username);
        if ($user) {
            self::showRegisterForm(array("username" => $_POST["username"] ?? "", "email" => $_POST["email"] ?? "", "error" => "This username is already taken."));
            return;
        }


        
        //ce so vsi podatki potem lahko shranimo uporabnika
        if ($validData) {
            //zgeneriramo hash
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            UserModel::create($username, $email, $passwordHash);
            ViewHelper::redirect(BASE_URL . "login");
            return;
        } 
    
        self::showRegisterForm(array("username" => $_POST["username"] ?? "", "email" => $_POST["email"] ?? "", "error" => "All fields required"));


    }

    //logout pa uniči sejo in te vrne na home
    public static function logout(){
        //naj bi bilo bolj pravilno, ker ni nujno da se session takoj uniči
        $_SESSION = [];
        session_destroy();
        ViewHelper::redirect(BASE_URL);
    }

    //stran uporabnika
    public static function getDetails($userId) {
        $reviews = ReviewModel::getByUser($userId);
        $stats = ReviewModel::getStatsByuser($userId);
        $user = UserModel::get($userId);

        ViewHelper::render("view/user-details.php", ["reviews" => $reviews, "stats" => $stats, "user" => $user]);

    }
}