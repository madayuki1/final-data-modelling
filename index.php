<?php 
session_start();




//connect to database
require "functions.php";


$db=mysqli_connect("localhost","root","","final-pemodelan");
$result=mysqli_query($db,"SELECT * FROM movies");



$movies= query("SELECT  * FROM movies");
if(isset($_POST["search"])){
   // print("enter this");
    $movies=cari($_POST["keywords"]);
    
}


if(!$movies)
{
    print("Data Dicari Tidak Ada");
}

?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    <h1>Daftar movies</h1>
    <br>
    <form action="" method="post">
        <input type="text" name="keywords" size="30" autofocus
        placeholder="tulis di sini BRO" autocomplete="off">
        <button type="submit" name="search">search!!</button>
    </form>
 <a href="tambah.php"></a>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Studio</th>
            <th>Realese Date</th>
            <th>Duration</th>
        </tr>
            <?php $i=1; ?>
            <?php while($row =mysqli_fetch_assoc($result)):?>

        
        <tr>
            <td><?= $i ?></td>
            <td><?=$row["movie_name"]?></td>
            <td><?=$row["genre"]?></td>
            <td><?=$row["studio_id"]?></td>
            <td><?=$row["release_date"]?></td>
            <td><?=$row["duration_in_minutes"]?></td>
            <?php $i++ ?>

        </tr>

            <?php endwhile ;?>
    </table>

    <!-- versi pakek function -->
    <h1>Daftar movies</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Studio</th>
            <th>Realese Date</th>
            <th>Duration</th>
        </tr>
            <?php $i=1; ?>
            <?php foreach($movies as $row):?>

        
        <tr>
            <td><?= $i ?></td>
            <td><?=$row["movie_name"]?></td>
            <td><?=$row["genre"]?></td>
            <td><?=$row["studio_id"]?></td>
            <td><?=$row["release_date"]?></td>
            <td><?=$row["duration_in_minutes"]?></td>
            <?php $i++ ?>

        </tr>

            <?php endforeach ;?>
    </table>
</body>

</html>