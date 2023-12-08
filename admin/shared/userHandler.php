<?php 
include_once '../shared/database.php';

class UserHandler {
    private $database;
    public $username;
    public $email;
    public $password;
    public $is_admin;

    public function __construct($conn) {
        $this->database = $conn;
    }
    public function addUser() {
        $pdo = $this->database->getConnection();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $checkSql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->bindParam(':email', $this->email);
                $checkStmt->execute();
                $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] > 0) {
                    echo "Email already exists. Please use a different email address.";
                    return;
                }
                $sql = "INSERT INTO users (username, email, is_admin, password, created_at) VALUES (:username, :email, :is_admin, :password, NOW())";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':is_admin', $this->is_admin);
                $stmt->bindParam(':password', $this->password);
                
                echo $sql;
                $stmt->execute();
        
                echo "User added successfully!";
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    public function updateUser($user_id) {
        $pdo = $this->database->getConnection();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $checkSql = "SELECT COUNT(*) as count FROM users WHERE email = :email AND user_id != :user_id";
                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->bindParam(':email', $this->email);
                $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $checkStmt->execute();
                $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] > 0) {
                    echo "Email already exists. Please use a different email address.";
                    return;
                }

                $sql = "UPDATE users SET username = :username, email = :email, is_admin = :is_admin, password = :password WHERE user_id = :user_id";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':is_admin', $this->is_admin);
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
        $user_sql = "SELECT user_id, username FROM users";
        $user_stmt = $pdo->query($user_sql);

        while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[$row['user_id']] = $row['username'];
        }

        return $users;
    }    
    public function getUserInfo($user_id) {
        $pdo = $this->database->getConnection();

        $query = "SELECT * FROM users WHERE user_id = :userId";
        $stmt1 = $pdo->prepare($query);

        $stmt1->bindParam(':userId', $user_id, PDO::PARAM_INT);

        $stmt1->execute();

        $user = $stmt1->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

}

?>