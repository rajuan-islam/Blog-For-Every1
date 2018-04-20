<?php

class DatabaseConnection {

    public function __construct() {
        global $pdo;
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        } catch (PDOException $ex) {
            exit('Database Error');
        }
    }

}
