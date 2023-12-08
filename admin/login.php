<?php
session_start();


if(!empty($_SESSION['user_id'])) {
    header('Location: .');
}

if(isset($_GET['success'])) {
    $registration_success = "Registration successfull";
}

$invalidUsernameOrPassword;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

     if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        exit();
    }

    $host = 'localhost';
    $dbname = 'rentandgodb';
    $username_db = 'root';
    $password_db = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($user['email']) && isset($user['password']) && password_verify($_POST['password'], $user['password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            header("Location: .?success"); 
            exit();
        } else {
            $invalidUsernameOrPassword = "Invalid email or password. Please try again.";
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
            
            <?php if (isset($invalidUsernameOrPassword)) { ?>
                <h3><?php echo $invalidUsernameOrPassword; ?></h3>
            <?php } ?>

            <?php if (isset($registration_success)) { ?>
                <h3><?php echo $registration_success; ?></h3>
            <?php } ?>
            
            <form action="login.php" method="post" class="login-form">
                <label for="email" class="form-label">Email:</label>
                <input type="text" id="email" name="email" class="form-input" required><br><br>

                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-input" required><br><br>

                <input type="submit" value="Login" class="form-submit">
            </form>
            <p class="form-link">Not Registered? <a href="register.php">Sign up</a></p>
        </section>
    </main>
    <footer class="footer">
        <p class="footer-text">&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
