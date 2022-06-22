<?php
require 'dbh.classes.php';

class data extends Dbh
{
    public function all_actor()
    {
        $sql = '
        SELECT actor_id, actor_name 
        FROM actors;
        ';

        $stmt = $this->connect()->query($sql);

        $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($actors) {
            return $actors;
        }
        return false;
    }


    public function allMongo()
    {
        //update di sini
        $reviews = $this->connectMongo()->reviews->find();

        if ($reviews) {
            return $reviews;
        }
        return false;
    }



    public function findTopGenre()
    {
        $sql = '
        SELECT genre, COUNT(*) as total
        FROM movies 
        GROUP BY genre
        ORDER BY total DESC;
        ';
        // $sql = '
        // SELECT m1.genre, COUNT(*) as total
        // FROM movies m1
        // JOIN movies m2
        // ON FIND_IN_SET(m1.genre, m2.genre)
        // GROUP BY genre
        // ORDER BY total DESC;
        // ';


        $stmt = $this->connect()->query($sql);
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($movies) {
            return $movies;
        }
        return false;
    }

    public function userCountry()
    {
        $sql = '
        SELECT c.country_name, COUNT(*) as total
        FROM users u
        JOIN countries c
        ON  u.country_id = c.country_id
        GROUP BY c.country_name
        ORDER BY total DESC;
        ';

        $stmt = $this->connect()->query($sql);
        $country = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($country) {
            return $country;
        }
        return false;
    }

    public function find($index)
    {
        $sql = '
        SELECT * FROM users
        WHERE username = ?;
        ';
        $stmt = $this->connect()->prepare($sql);

        $stmt->execute(array($index));
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        }
        return "nothing found";
    }

    public function castingCountMongo()
    {

        $array = [];

        //update di sini
        $casts = $this->connectMongo()->casts->find();
        // var_dump($casts);
        // $assoc=json_decode(json_encode($casts), true);
        // var_dump($assoc);
        foreach ($casts as $cs) {
            $array[] = $cs->actor_id;
        }
        print(gettype($array));
        if ($array) {
            return $array;
        }
        return false;
    }

    public function avgRatingMongo()
    {

        $array = [];
        $reviews = $this->connectMongo()->reviews->find();

        foreach ($reviews as $rv) {
            $array[] = $rv->rating;
        }
        $average = array_sum($array) / count($array);
        if ($average) {
            return $average;
        }
        return false;
    }
}
