<?php
include_once 'common/isUserLoggedIn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user_id is provided
    if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
        // Redirect if user_id is missing
        header("Location: manage-users.php");
        exit();
    }

    $user_id = $_POST['user_id'];

    $host = 'localhost';
    $dbname = 'rentandgodb';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete the user from the database
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Redirect to manage-users.php after successful deletion
        header("Location: manage-users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // If not a POST request, redirect to manage-users.php
    header("Location: manage-users.php");
    exit();
}
?>
