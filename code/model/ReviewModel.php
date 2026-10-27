<?php

require_once("DBinit.php");

class ReviewModel {

    //vrne ta z idjem
    public static function get($id){
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT 
                                        reviews.id,
                                        reviews.rating,
                                        reviews.review_text,
                                        reviews.created_at,
                                        reviews.movie_id,
                                        users.username,
                                        reviews.user_id
                                    FROM reviews

                                    JOIN users
                                        ON reviews.user_id = users.id

                                    WHERE reviews.id = :review_id");

        $statement->bindParam(":review_id", $id, PDO::PARAM_INT); //poslje kot int
        $statement->execute();

        return $statement->fetch();
    }
    //vrne vse reviewe tega filma
    public static function getByMovie($movieId) {
        $db = DBinit::getInstance();

        //hocmo se username dobit - mgc id če bo imel vsak svojo stran - verjetno ne
        $statement = $db->prepare("SELECT
                                        reviews.id,
                                        reviews.rating,
                                        reviews.review_text,
                                        reviews.created_at,
                                        users.username,
                                        reviews.user_id

                                    FROM reviews

                                    JOIN users
                                        ON reviews.user_id = users.id

                                    WHERE movie_id = :movie_id
                                    ORDER BY reviews.created_at DESC");
        $statement->bindParam(":movie_id", $movieId, PDO::PARAM_INT); //poslje kot int
        $statement->execute();

        return $statement->fetchAll();
    }

    //torej za tega uporabnika njegovo review za ta film
    public static function getByUserAndByMovie($movieId, $userId) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("SELECT
                                        reviews.id,
                                        reviews.rating,
                                        reviews.review_text,
                                        reviews.created_at,
                                        users.username,
                                        reviews.user_id

                                    FROM reviews

                                    JOIN users
                                        ON reviews.user_id = users.id

                                    WHERE movie_id = :movie_id AND user_id = :user_id
                                    ORDER BY reviews.created_at DESC");
        $statement->bindParam(":movie_id", $movieId, PDO::PARAM_INT); //poslje kot int
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT); //poslje kot int
        $statement->execute();

        return $statement->fetch();
    }

    //vrne vse reviewe tega userja
    public static function getByUser($userId) {
        $db = DBinit::getInstance();

        //hocmo se username dobit - mgc id če bo imel vsak svojo stran - verjetno ne
        $statement = $db->prepare("SELECT
                                        reviews.id,
                                        reviews.rating,
                                        reviews.review_text,
                                        reviews.created_at,
                                        users.username,
                                        movies.title,
                                        reviews.movie_id

                                    FROM reviews

                                    JOIN users
                                        ON reviews.user_id = users.id JOIN movies ON movies.id = reviews.movie_id

                                    WHERE reviews.user_id = :user_id
                                    

                                    ORDER BY reviews.created_at DESC
                                ");
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT); //poslje kot int
        $statement->execute();

        return $statement->fetchAll();
    }

    //da dobis stevilo in povprecno ocena na uporabnika za user page
    public static function getStatsByuser($userId) {
        $db = DBinit::getInstance();

        //hocmo se username dobit - ne smemo mesati agregatnih in normalnih zahtevkov
        $statement = $db->prepare("SELECT
                                    COUNT(*) AS review_count,
                                    COALESCE(AVG(rating), 0) AS avg_rating
                                    FROM reviews
                                    WHERE user_id = :user_id
                                ");
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT); //poslje kot int
        $statement->execute();

        return $statement->fetch();
    }

    


    //insert
    public static function insert($userId, $movieId, $rating, $reviewText) {

        $db = DBinit::getInstance();

        $statement = $db->prepare("INSERT INTO reviews (user_id, movie_id, rating, review_text)
                                VALUES (:user_id, :movie_id, :rating, :review_text)");

        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":movie_id", $movieId, PDO::PARAM_INT);
        $statement->bindParam(":rating", $rating, PDO::PARAM_INT);
        $statement->bindParam(":review_text", $reviewText);
        $statement->execute();
    }

    //update
    public static function update($id, $rating, $reviewText) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("UPDATE reviews SET rating = :rating, review_text = :review_text WHERE id = :id");

        
        $statement->bindParam(":rating", $rating, PDO::PARAM_INT);
        $statement->bindParam(":review_text", $reviewText);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    //brisanje
    public static function delete($id) {
        $db = DBinit::getInstance();

        $statement = $db->prepare("DELETE FROM reviews WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        $statement->execute();
    }
}