<?php

class DBinit{
    private static $host = "localhost";
    private static $user = "root";
    private static $password = "";
    
    private static $schema  = "moviereviewer";
    private static $instance = null;



    /**
     * vrne instanco nase baze
     * imamo singleton tako da je samo 1 povezava activna naenkrat
     * v options so 
     * 
     */
    public static function getInstance() {
        if (!self::$instance) {
            $connectionString = "mysql:host=" . self::$host . ";dbname=" . self::$schema . ";charset=utf8";

            $options =  array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //vrne exception pri napaki s query
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //do podatkov lahko samo asociativno dostopamo
                // PDO::ATTR_PERSISTENT => true,
                // PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            );

            self::$instance = new PDO($connectionString, self::$user, self::$password, $options);

        }
        return self::$instance;
    }

}


?>