<?php
$title = 'Sign Up';
require_once 'includes/header.php';
require_once 'navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

   $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
   $password1 = password_hash(filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT); // Hash the password for security
   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
   $role = 2;

    // Insert the user data into the "users" table
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password1, :role)");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password1', $password1);
    $stmt->bindParam(':role', $role);

    try {
        if ($stmt->execute()) {
            // Registration successful message with a redirect
            echo '<div class="container"><div class="row"><div class="col"><h1>Registration successful</h1></div></div></div>';
            echo '<script>
                    setTimeout(function(){
                        window.location.href = "sign-in.php"; // Redirect after 2 seconds
                    }, 2000);
                  </script>';
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
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password1">Password</label>
                    <input type="password" class="form-control" id="password1" name="password1" required>
                </div>
                <div class="form-group">
                    <label for="password2">Re-enter Password</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>