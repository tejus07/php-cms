<?php 

class UserHandler {
    private $database;
    public $user_name;

    public function __construct($conn) {
        $this->database = $conn;
    }

    public function addUser() {
        $pdo = $this->database->getConnection();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':category_name', $this->user_name);
                
                echo $sql;
                $stmt->execute();
        
                echo "Category added successfully!";
                
                header("Location: categories.php");
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    
    public function getUsers() {
        $pdo = $this->database->getConnection();
        $users = [];
        $user_sql = "SELECT user_id, username FROM Users";
        $user_stmt = $pdo->query($user_sql);

        while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[$row['user_id']] = $row['username'];
        }

        return $users;
    }    
    public function getUserInfo($user_id) {
        $pdo = $this->database->getConnection();

        $query = "SELECT * FROM Users WHERE user_id = :userId";
        $stmt1 = $pdo->prepare($query);
        
        $stmt1->bindParam(':userId', $user_id, PDO::PARAM_INT);
        
        $stmt1->execute();
        
        $user = $stmt1->fetch(PDO::FETCH_ASSOC);

        return $user;

    }
}

?>