<?php 
include_once '../shared/database.php';

class UserHandler {
    private $database;
    public $username;

    public function __construct() {
        $this->database = new Database();
    }

    

    public function getUsers() {
        $pdo = $this->database->getConnection();
        $users = [];
        $user_sql = "SELECT user_id, username FROM users";
        $user_stmt = $pdo->query($user_sql);

        while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[$row['user_id']] = $row['username'];
        }

        return $users;
    }
}

?>