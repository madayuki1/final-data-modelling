<?php 
    require 'classes\data.classes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $data = new data();
    foreach($data->all() as $element){
        echo $element['username'] . '<br>';
    }
    ?>
</body>
</html>