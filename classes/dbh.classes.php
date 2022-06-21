<?php
require 'vendor/autoload.php';
class Dbh
{
    protected function connect()
    {
        try
        {
            $username = "root";
            $password = "";
            $dbh = new PDO('mysql:host=localhost;dbname=final-pemodelan', $username, $password);
            return $dbh;
        }
        catch (PDOException $e)
        {
            print "Error!: ". $e->getMessage() . "<br/>";
            die();
        }
    }
    //connect mongo 
    protected function connectMongo(){

        try
        {
            $con=new MongoDB\Client("mongodb://localhost:27017");
            $db= $con->final_pemodelan;
            
            return $db;

        }
        catch (MongoConnectionException $e) {
            die('Failed to connect to MongoDB '.$e->getMessage(). "<br/>");
        }
    }

}