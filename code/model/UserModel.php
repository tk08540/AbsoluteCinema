<?php

require_once("DBinit.php");

class UserModel {

    //dobis userja na podlagi idja
    public static function get($id) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT id, username, email, password_hash, role FROM users WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT); //poslje kot int
        $statement->execute();

        $user = $statement->fetch();

        if ($user != null) {
            return $user;
        } else {
            //ce ni vrne error 404
            ViewHelper::error404("User not found.");
        }
    }

    //ustvari uporabanika
    public static function create($username, $email, $passwordhash) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, 'user')");
        $statement->bindParam(":username", $username);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password_hash", $passwordhash);
        $statement->execute();
    }

    //za login da bomo dobili podatke o userju
    public static function getUserByEmail($email) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT id, username, email, password_hash, role FROM users WHERE email = :email");
        $statement->bindParam(":email", $email);
        $statement->execute();

        return $statement->fetch(); //pri prijavi pogledamo če je null ali ne
        

    }

    public static function getUserByUsername($username){
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT id, username, email, password_hash, role FROM users WHERE username = :username");
        $statement->bindParam(":username", $username);
        $statement->execute();

        return $statement->fetch(); //pri prijavi pogledamo če je null ali ne


    }
    
}