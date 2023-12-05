<?php
session_start();


if(!empty($_SESSION['user_id'])) {
    header('Location: .');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

     if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit();
    }

    $host = 'localhost';
    $dbname = 'rentandgodb';
    $username_db = 'root';
    $password_db = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['username'] && $user['password']) {

            $_SESSION['user_id'] = $username;
            header("Location: ."); 

            exit();
        } else {
            echo "Invalid username or password. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - RentAndGo</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <header class="header">
        <h1 class="header-title">Login to <a class="home-page-link" href="..">RentAndGo</a></h1>
    </header>
    <main>
        <section class="login-container">
            <form action="login.php" method="post" class="login-form">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-input" required><br><br>

                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-input" required><br><br>

                <input type="submit" value="Login" class="form-submit">
            </form>
        </section>
    </main>
    <footer class="footer">
        <p class="footer-text">&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
