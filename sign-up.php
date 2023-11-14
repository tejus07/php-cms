<?php
$title = 'Sign Up';
require_once 'includes/header.php';
require_once 'navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    $username = $_POST['username'];
    $password1 = password_hash($_POST['password1'], PASSWORD_DEFAULT); // Hash the password for security
    $email = $_POST['email'];

    // Insert the user data into the "users" table
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password1)");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password1', $password1);

    try {
        if ($stmt->execute()) {
            echo '<h1>Registration successful</h1>';
        } else {
            echo '<h1>Registration failed</h1>';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            // Check for a duplicate entry error
            echo '<h1>Username or email already exists. Please choose a different one.</h1>';
        } else {
            // Handle other database-related errors
            echo '<h1>Error: ' . $e->getMessage() . '</h1>';
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Sign Up</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="sign-up.php" method="post">
                <div class="form-group">
                    <label for="username">User Name</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="password1">Password</label>
                    <input type="password" class="form-control" id="password1" name="password1">
                </div>
                <div class="form-group">
                    <label for="password2">Re-enter Password</label>
                    <input type="password" class="form-control" id="password2" name="password2">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>