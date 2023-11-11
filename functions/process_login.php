<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Correct credentials; create a user session and redirect to a protected page
        session_start();
        $_SESSION['user_id'] = $user['id']; 
        header('Location: ../index.php');
        exit();
    } else {
        // Incorrect credentials; show an error message or redirect to the login page
        header('Location: ../sign-in.php?error=1'); // You can add an error parameter for displaying an error message
        exit();
    }
}
?>