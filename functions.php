
<?php 
#fungsi
$db=mysqli_connect("localhost","root","","final-pemodelan");

function query($query){
    $sql="";
    global $db;
    $result =mysqli_query($db,$query);
    $rows =[];
    while( $row = mysqli_fetch_assoc($result)) {
        $rows[]=$row;
    };
    return $rows;
}

Class Movies()

function cari($keyword){
    //print($keyword);
     $query="SELECT * FROM movies
     WHERE 
     movie_name LIKE '%$keyword%' OR
     genre LIKE '%$keyword%' OR
     studio_id LIKE '%$keyword%' OR
     release_date LIKE '%$keyword%' 
            ";
     return query($query);
}



?>