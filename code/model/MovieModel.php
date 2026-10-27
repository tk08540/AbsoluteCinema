<?php

require_once("DBinit.php");

class MovieModel {
    
    //Vrne vse filme
    public static function getAll() {
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT 
                                        movies.id,
                                        movies.title,
                                        movies.description,
                                        movies.genre,
                                        movies.release_year,
                                        movies.image_url,
                                        COALESCE(AVG(reviews.rating), 0) AS avg_rating,
                                        COUNT(reviews.id) AS review_count
                                    FROM movies
                                    LEFT JOIN reviews
                                        ON movies.id = reviews.movie_id
                                    GROUP BY movies.id
                                    ORDER BY movies.title");
        $statement->execute();

        return $statement->fetchAll();
    }

    //Vrne 10 najbolj ratingah filmov
    public static function getRated(){
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT 
                                        movies.id,
                                        movies.title,
                                        movies.image_url,
                                        movies.release_year,
                                        COALESCE(AVG(reviews.rating), 0) AS avg_rating,
                                        COUNT(reviews.id) AS review_count
                                    FROM movies
                                    LEFT JOIN reviews ON movies.id = reviews.movie_id
                                    GROUP BY movies.id
                                    ORDER BY avg_rating DESC
                                    LIMIT 6;");
        $statement->execute();

        return $statement->fetchAll();
    }

    //vrne 10 najnovejših filmov
    public static function getLatest(){
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT 
                                        movies.id,
                                        movies.title,
                                        movies.image_url,
                                        movies.release_year,
                                        COALESCE(AVG(reviews.rating), 0) AS avg_rating,
                                        COUNT(reviews.id) AS review_count
                                    FROM movies
                                    LEFT JOIN reviews ON movies.id = reviews.movie_id
                                    GROUP BY movies.id
                                    ORDER BY movies.created_at DESC
                                    LIMIT 6;");
        $statement->execute();

        return $statement->fetchAll();
    }

    //vrne specifičen film glede na id
    public static function get($id) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT 
                                        movies.id,
                                        movies.title,
                                        movies.description,
                                        movies.genre,
                                        movies.release_year,
                                        movies.image_url,
                                        COALESCE(AVG(reviews.rating), 0) AS avg_rating,
                                        COUNT(reviews.id) AS review_count
                                    FROM movies
                                    LEFT JOIN reviews
                                        ON movies.id = reviews.movie_id
                                    WHERE movies.id = :id
                                    GROUP BY movies.id");

        $statement->bindParam(":id", $id, PDO::PARAM_INT); //poslje kot int
        $statement->execute();

        $movie = $statement->fetch();

        if ($movie != null) {
            return $movie;
        } else {
            //ce ni vrne error 404
            ViewHelper::error404("Movie not found.");
        }
    }

    //vstavljanje
    public static function insert($title, $description, $genre, $release_year, $image_url) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("INSERT INTO movies (title, description, genre, release_year, image_url) 
                                    VALUES (:title, :description, :genre, :release_year, :image_url)");

        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":genre", $genre);
        $statement->bindParam(":release_year", $release_year);
        $statement->bindParam(":image_url", $image_url);

        $statement->execute();

        //da vemo potem kam ga zlovdat
        //vrne zadnji id ki ga je vstavilo
        return $db->lastInsertId();
        
    }

    //posodabljanje
    public static function update($id, $title, $description, $genre, $release_year, $image_url) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("UPDATE movies SET title = :title, description = :description, 
                                    genre = :genre, release_year = :release_year, image_url = :image_url WHERE id = :id");

        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":genre", $genre);
        $statement->bindParam(":release_year", $release_year);
        $statement->bindParam(":image_url", $image_url);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        $statement->execute();
        
    }

    //brisanje
    public static function delete($id) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("DELETE FROM movies WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        $statement->execute();
    }


    //iskanje
    public static function search($query) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT 
                                        movies.id,
                                        movies.title,
                                        movies.description,
                                        movies.genre,
                                        movies.release_year,
                                        movies.image_url,
                                        COALESCE(AVG(reviews.rating), 0) AS avg_rating,
                                        COUNT(reviews.id) AS review_count
                                    FROM movies
                                    LEFT JOIN reviews
                                        ON movies.id = reviews.movie_id 
                                    WHERE (movies.title LIKE :query OR movies.release_year LIKE :query OR movies.description LIKE :query
                                    OR movies.genre LIKE :query)
                                    GROUP BY movies.id
                                    ORDER BY title");
        
        //isce vsebovanje v naslovu ali letu ali opisu ali zanru - param 1 value vec
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();

        return $statement->fetchAll();

    }
}



?>