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
        if ($array) {
            return $array;
        }
        return false;
    }

    public function avgRatingMongo()
    {


        $sql = '
        SELECT * FROM movies;
        ';
        $stmt = $this->connect()->query($sql);

        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $rate=[];
        $mvid=[];
        $reviews=$this->connectMongo()->reviews->find();

        foreach($reviews as $rv){
            $rate[]=$rv->rating;
            $mvid[]=$rv->movie_id;
            
        }
        $sumOfUniq=[];
        $countOfUniq=[];
        $avgOfUniq=[];
        foreach($mvid as $key=>$id){
            if(array_key_exists($id,$sumOfUniq))
            {
                $sumOfUniq[$id]+=$rate[$key];
                $countOfUniq[$id]+=1;

            }
            else{
                $sumOfUniq[$id]=0;
                $sumOfUniq[$id]+=$rate[$key];
                $countOfUniq[$id]=0;
                $countOfUniq[$id]+=1;
            }
            
        }
        $countRateMovies=[];
        foreach($sumOfUniq as $key=>$id){
            $avgOfUniq[$id]=0;
            $avgOfUniq[$id]=$sumOfUniq[$key]/$countOfUniq[$key];  
            $found_key = array_search($id, array_column($movies, 'movie_id'));
            $countRateMovies[$movies[$found_key]['movie_name']]=$avgOfUniq[$id];
            }
        

        
        //var_dump($countMovies);

     

        if($countRateMovies){
            return $countRateMovies;

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

    public function actorCountMongoPMA(){
       
        $data=new data();
        $assoc=$data->castingCountMongo();
        $assoc=array_count_values($assoc);
        //var_dump($assoc);
        
      
       
       
        $sql = '
        SELECT actor_id,actor_name FROM actors;
        ';

        $stmt = $this->connect()->query($sql);

        $actors= $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countActors=[];
        // echo $actors[9]['actor_name'];
        // $found_key = array_search('9', array_column($actors, 'actor_id'));
        // $found_key = array_search('Gerald Caps', array_column($actors, 'actor_name'));

        // echo $found_key;

        foreach($assoc as $one => $value){
            
            $found_key = array_search($one, array_column($actors, 'actor_id'));
            $countActors[$actors[$found_key]['actor_name']]=$value;
            }
        if ($countActors) {
            return $countActors;
        }
        
        return false;
    }

}


