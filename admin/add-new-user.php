<?php
$title = 'Add New Brand';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once '../functions/function.php';
require_once 'admin-navbar.php';

if (session_status() == PHP_SESSION_NONE):
    session_start();
endif;

if (
    !isset($_SESSION['user_id']) || empty($_SESSION['user_id'])
    || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'
):
    header("Location: ./login.php");
    exit();
endif;

if (isset($_GET['error'])):
    $error_message = $_GET['error'];
    echo "<div class='row'><div class='col-md-9 ml-sm-auto col-lg-10 px-md-4'>
    <div class='error-message'>$error_message</div>
    </div></div>";
endif;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])):
    $error_message = "";
    $username = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_STRING) : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $reEnteredPassword = isset($_POST['re-password']) ? $_POST['re-password'] : null;
    $role = isset($_POST['role']) ? intval($_POST['role']) : null;

    if (!$email) {
        $error_message = "Please enter a valid email address.";
        header("Location: add-new-user.php?error=" . urlencode($error_message) . "&username=" . urlencode($username));
        exit();
    }

    if (empty($username) || empty($password) || empty($reEnteredPassword) || !in_array($role, [1, 2])):
        $error_message = "Please enter all required fields";
        header("Location: add-new-user.php?error=" . urlencode($error_message) . "&username=" . urlencode($username) . "&password=" . urlencode($username));
        exit();
    endif;

    if (
        strlen($password) < 8 || // Password should be at least 8 characters long
        !preg_match('/[A-Z]/', $password) || // Password should contain uppercase letters
        !preg_match('/[a-z]/', $password) || // Password should contain lowercase letters
        !preg_match('/[^\w\d\s]/', $password) // Password should contain special characters
    ) {
        $error_message = "Password must be at least 8 characters long and include uppercase and lowercase letters, and special characters.";
        header("Location: add-new-user.php?error=" . urlencode($error_message) . "&username=" . urlencode($username) . "&password=" . urlencode($username));
        exit();
    } elseif ($password !== $reEnteredPassword) {
        $error_message = "Passwords do not match.";
        header("Location: add-new-user.php?error=" . urlencode($error_message) . "&username=" . urlencode($username) . "&password=" . urlencode($username));
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
            header("Location: add-new-user.php?error=" . urlencode($error_message));
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        header("Location: users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }

endif;

?>

<div class="container-fluid">
    <div class="row">
        <?php require 'admin-sidebar.php'; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New User</h1>
            </div>
            <form method="post">
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
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" name="role">
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Add User</button>
            </form>
        </main>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>