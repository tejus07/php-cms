<?php
include_once '../shared/database.php';

$database = new Database();
$pdo = $database->getConnection();

if(isset($_GET['logout']) && $_GET['logout']) {
    echo'in if';
    unset($_SESSION['user_id']);
}

if(!empty($_SESSION['user_id'])) {
    header('Location: .');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    echo $user['email'];
    echo $user['password'];

    echo (password_verify($password, $user['password']));
    // echo $user. "in here";
    if ($user['email'] == $email && $password == $user['password']) {
        echo 'in if';
        echo $user['user_id'];
        
        $_SESSION['user_id'] = $user['user_id'];
        
        header('Location: index.php');
        exit;
    } else {
        echo 'in else';

        $error_message = "Error: " . $query->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login_register.css">
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Login</h2>
        <form class="form" method="post" action="login.php">
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
        <!-- <p class="form-link">Don't have an account? <a href="register.php">Register</a></p> -->
        <?php
        if (isset($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
        }
        ?>
    </div>
</body>
</html>
