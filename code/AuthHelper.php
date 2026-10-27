<?php
class AuthHelper {

    //vrne je uporabnik prijavljen    
    public static function isLoggedIn() {
        return isset($_SESSION["user"]);
    }


    //pove če je admin
    public static function isAdmin() {
        return self::isLoggedIn() && $_SESSION["user"]["role"] == "admin";
    }

    //Vrne trenutnega uporabnika ali pa null če ni prijavljen
    public static function getUser() {
        return $_SESSION["user"] ?? null;
    }

    //predvsem za prijavo in registracijo -> zavrnjen dostop če si že prijavljen
    public static function requireGuest(){
        if (self::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL);
            exit;
        }
    }
    //mora biti prijavljen -> drugače ne pusti in te vrne na prijavo
    public static function requireLogin(){
        if (!self::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "login");
            exit;
        }
    }

}



?>