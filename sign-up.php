<?php
$title = 'Sign Up';
require_once 'includes/header.php';
require_once 'navbar.php';
require 'includes/db.php';

if (isset($_GET['error'])):
    $error_message = $_GET['error'];
    echo "<div class='row'><div class='col-md-9 ml-sm-auto col-lg-10 px-md-4'>
    <div class='error-message'>$error_message</div>
    </div></div>";
endif;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_STRING) : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $reEnteredPassword = isset($_POST['re-password']) ? $_POST['re-password'] : null;
    $role = 2;

    if (!$email) {
        $error_message = "Please enter a valid email address.";
        header("Location: sign-up.php?error=" . urlencode($error_message) . "&username=" . urlencode($username));
        exit();
    }

    if (empty($username) || empty($password) || empty($reEnteredPassword) || !in_array($role, [1, 2])):
        $error_message = "Please enter all required fields";
        header("Location: sign-up.php?error=" . urlencode($error_message) . "&username=" . urlencode($username) . "&password=" . urlencode($username));
        exit();
    endif;

    if (
        strlen($password) < 8 || // Password should be at least 8 characters long
        !preg_match('/[A-Z]/', $password) || // Password should contain uppercase letters
        !preg_match('/[a-z]/', $password) || // Password should contain lowercase letters
        !preg_match('/[^\w\d\s]/', $password) // Password should contain special characters
    ) {
        $error_message = "Password must be at least 8 characters long and include uppercase and lowercase letters, and special characters.";
        header("Location: sign-up.php?error=" . urlencode($error_message) . "&username=" . urlencode($username) . "&password=" . urlencode($username));
        exit();
    } elseif ($password !== $reEnteredPassword) {
        $error_message = "Passwords do not match.";
        header("Location: sign-up.php?error=" . urlencode($error_message) . "&username=" . urlencode($username) . "&password=" . urlencode($username));
        exit();
    }

    try {
        $checkStmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $checkStmt->bindParam(':username', $username);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();
        $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error_message = "Username or email already exists. Please choose a different one.";
            header("Location: sign-up.php?error=" . urlencode($error_message));
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        header("Location: sign-in.php?register=success");
        exit();
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

<div class="container-fluid">
    <div class="row text-center mt-5">
        <div class="col">
            <h2>Sign Up</h2>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-5 mx-auto">
            <form action="sign-up.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Enter Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required
                        aria-describedby="passwordHelp">
                    <small id="emailHelp" class="form-text text-muted">Password must be at least 8 characters long and
                        include uppercase and lowercase letters, and special characters.</small>
                </div>
                <div class="form-group">
                    <label for="re-password">Re-Enter Password:</label>
                    <input type="password" class="form-control" id="re-password" name="re-password" required>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>