<?php
include_once '../shared/database.php';

$database = new Database();
$pdo = $database->getConnection();

if(isset($_GET['logout']) && $_GET['logout']) {
    unset($_SESSION['user_id']);
}

// if(!empty($_SESSION['user_id'])) {
//     header('Location: .');
// }
if(!empty($_SESSION['user_id']) && empty($_SESSION['is_admin'])) {
    header('Location: ../user/user_dashboard.php');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);


    // echo $user. "in here";
    if ($user['email'] == $email && $password == $user['password']) {
        
        $_SESSION['user_id'] = $user['user_id'];
        if ($user['is_admin']== 1){
            $_SESSION['is_admin'] = true;
            echo $_SESSION['is_admin'];
            header('Location: index.php');
        }
        else {
            unset($_SESSION['is_admin']);
            header('Location: ../user/user_dashboard.php');
        }
        exit;
    } else {

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