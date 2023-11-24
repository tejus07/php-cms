<?php
session_start();
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'pizzaPals';

    public function getConnection() {
        $dsn = 'mysql:host='. $this->host .';dbname='. $this->dbname;
        $pdo = new PDO($dsn, $this->user, $this->password);
        return $pdo;
    }
}

?>