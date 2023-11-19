<?php 
class Database {
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'rentandgodb';

    public function setupConnection() {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>