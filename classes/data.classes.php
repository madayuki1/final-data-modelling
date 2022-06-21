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
}