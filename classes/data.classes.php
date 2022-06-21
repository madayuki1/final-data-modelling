<?php
require 'dbh.classes.php';

class data extends Dbh
{
    public function all()
    {
        $sql = '
        SELECT * FROM users;
        ';

        $stmt = $this->connect()->query($sql);

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            return $users;
        }
        return false;
    }


    public function allMongo(){
       //update di sini
        $reviews=$this->connectMongo()->reviews->find();

        if($reviews){
            return $reviews;
        }
        return false;
    }



    public function findTopGenre(){
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

    public function userCountry(){
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

}