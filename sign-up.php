<?php
$title = 'Sign Up';
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $email = $_POST['email'];

    // Insert the user data into the "users" table
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo '<h1>Registration successful</h1>';
    } else {
        echo '<h1>Registration failed</h1>';
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
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>