<?php

include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

        try {
            $sql = "DELETE FROM Users WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            echo "User deleted successfully!";
            header("Location: users.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
}

?>
