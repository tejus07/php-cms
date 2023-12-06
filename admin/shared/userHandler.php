<?php 

class UserHandler {
    private $database;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($conn) {
        $this->database = $conn;
    }

    public function addUser() {
        $pdo = $this->database->getConnection();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $sql = "INSERT INTO users (username, email, role, password, created_at, updated_at) VALUES (:username, :email, :role, :password, NOW(), NOW())";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':role', $this->role);
                $stmt->bindParam(':password', $this->password);
                
                echo $sql;
                $stmt->execute();
        
                echo "User added successfully!";
                header("Location: users.php");
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function updateUser($user_id) {
        $pdo = $this->database->getConnection();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $sql = "UPDATE users SET username = :username, email = :email, role = :role, password = :password, updated_at = NOW() WHERE user_id = :user_id";
    
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':role', $this->role);
                $stmt->bindParam(':password', $this->password);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
                $stmt->execute();
    
                echo "User updated successfully!";
                header("Location: users.php");
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