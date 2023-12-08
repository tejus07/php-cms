<?php
include_once '../shared/database.php';

$database = new Database();
$pdo = $database->getConnection();


if (isset($_SESSION['registration_success'])) {
    $registration_success = $_SESSION['registration_success'];
    echo '<span class="register-success-message">'. $registration_success .'</span>';
    unset($_SESSION['registration_success']);
}

if(isset($_GET['logout']) && $_GET['logout']) {
    unset($_SESSION['user_id']);
}

if(!empty($_SESSION['user_id'])) {
    if(!empty($_SESSION['user_role'] && $_SESSION["user_role"] == "admin")) {
        header('Location: .');
    } else {
        header('Location: ../user/user_dashboard.php');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (isset($user['email']) && isset($user['email'])) {
        
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['login_success'] = "Login was successful";

        if($user['role'] == "admin") {
            $_SESSION["user_role"] = "admin";
        }
        
        
        if ($user['role'] === "admin") {
            header('Location: index.php');
        } else {
            header('Location: ../user/user_dashboard.php');
        }
        exit;
    } else {
        
        $error_message = "Incorrect email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login_register.css">
    <script>
        function validateForm() {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address");
                return false;
            }

            // if (password.length < 8) {
            //     alert("Password must be at least 8 characters long");
            //     return false;
            // }

            return true;
        }
    </script>
</head>
<body>
    <div class="form-container">
        <?php if (isset($error_message)) { ?>
            <h4 class="error-message"><?php echo $error_message; ?></h4>
        <?php }?>
        <h2 class="form-title">Login</h2>
        <form class="form" method="post" action="login.php" onsubmit="return validateForm()">
            <div class="input-container">
                <label for="email">Email:</label>
                <input class="input-field" type="text" name="email" id="email" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input class="input-field" type="password" name="password" id="password" required>
            </div>
            <button class="form-button" type="submit">Login</button>
        </form>
        <p class="form-link">Don't have an account? <a href="register.php">Register</a></p>
        
    </div>
</body>
</html>
