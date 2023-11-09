<?php
$title = 'Sign In';
require_once 'includes/header.php';

if (isset($_GET['error']) && $_GET['error'] === '1') {
    echo '<p style="color: red;">Invalid username or password. Please try again.</p>';
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     include 'db.php';

//     $username = $_POST['username'];
//     $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
//     $email = $_POST['email'];


//     if ($stmt->execute()) {
//         echo '<h1>Sign in successful</h1>';
//     } else {
//         echo '<h1>Sign in failed</h1>';
//     }
// }
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Sign Up</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="./functions/process_login.php" method="post">
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
require_once 'includes/footer.php';
?>