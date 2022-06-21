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



    public function findTopGenre($index){
        $sql = '
        SELECT movie_name, count(movie_id) as "total" FROM movies LIMIT ? ORDER BY "total" DESC;
        ';

        $stmt = $this->connect()->prepare($sql);

        $stmt->execute(array($index));
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($movies) {
            return $movies;
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