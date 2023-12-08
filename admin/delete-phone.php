<?php
require_once '../includes/initialize.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['user_id']) || empty($_SESSION['user_id'])
    || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'
):
    header("Location: ./login.php");
    exit();
endif;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_phone'])) {
    $phone_id = $_POST['phone_id'];

    $image_path = "../" . $image_url;
    if (file_exists($image_path)) {
        unlink($image_path);
        echo "Image deleted successfully!";
    } else {
        echo "Image not found.";
    }
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