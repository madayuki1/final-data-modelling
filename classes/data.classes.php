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