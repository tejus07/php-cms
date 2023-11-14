<?php
require_once '../includes/initialize.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_phone'])) {
    $phone_id = $_POST['phone_id'];
    echo $phone_id;

        try {
            $sql = "DELETE FROM phone_specs WHERE phone_id = :phone_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':phone_id', $phone_id);
            $stmt->execute();

            $sql = "DELETE FROM phones WHERE id = :phone_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':phone_id', $phone_id);
            $stmt->execute();

            echo "Phone deleted successfully!";
            header("Location: phones.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
}

?>
