<?php
$title = 'Sign In';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 1;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE (username = :username OR email = :email) AND role = :role");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $username);
    $stmt->bindParam(':role', $role);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // echo var_dump($user);    
    echo var_dump(password_verify($password, $user['password']));
    if ($user && password_verify($password, $user['password'])) {
        // Correct credentials; create a user session and redirect to a protected page
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header('Location: ./index.php');
        exit();
    } else {
        header('Location: ./login.php?error=1'); // You can add an error parameter for displaying an error message
        exit();
    }
}

if (isset($_GET['error']) && $_GET['error'] === '1') {
    echo '<p style="color: red;">Invalid username or password. Please try again.</p>';
}
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Admin Login</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username or Email:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
        </div>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>