<?php

class ViewHelper {

    //prikaze zahtevan pogled in da spremenljivke v scope
    public static function render($file, $variables = array()) {
        extract($variables);

        //bufferinga za ta projekt naj ne bi rabil
        //ob_start();
        
        include("view/layout/header.php");
        include($file);
        include("view/layout/footer.php");
        
        //$renderedView = ob_get_clean();

        //echo $renderedView;
    }


    //preusmeritev
    public static function redirect($url) {
        header("Location: ". $url); //pošlje http zahtevek z urljem v glavi
    }

    //vsakemu erroju damo code, title(status) in message
    //error 404
    public static function error404($message = "") {
        $code = 404;
        $title = "Page not found";
        $url = htmlspecialchars($_SERVER["REQUEST_URI"]);
        if (empty($message)) {
            $message = "The page <b>$url</b> does not exist.";
        }
        
        http_response_code($code);
        $variables = [
            "code" => $code,
            "title" => $title,
            "message" => $message
            
        ];

        self::render("view/errors/error.php", $variables);
    }

    //error 500 - neka napaka v strezniku
    public static function error500($message) {
        $code = 500;
        $title = "Internal server error";
    
        http_response_code($code);
        $variables = [
            "code" => $code,
            "title" => $title,
            "message" => $message
        ];

        self::render("view/errors/error.php", $variables);
    }

    //error 400 - neka napaka v zahtevku
    public static function error400($message){
        $code = 400;
        $title = "Bad Request";

        http_response_code($code);
        $variables = [
            "code" => $code,
            "title" => $title,
            "message" => $message
        ];

        self::render("view/errors/error.php", $variables);
    }

    //error 403 - napaka v pravicah uporabnika zahtevka
    public static function error403($message = "You do not have permission to access this resource."){
        $code = 403;
        $title = "Forbidden";
        
        http_response_code($code);
        $variables = [
            "code" => $code,
            "title" => $title,
            "message" => $message
        ];

        self::render("view/errors/error.php", $variables);
    }
}

?>