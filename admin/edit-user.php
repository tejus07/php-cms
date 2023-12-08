<?php
$title = 'Edit User';
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
  ) :
    header("Location: ./login.php");
    exit();
endif;

if (!isset($_GET['id']) || empty($_GET['id'])):
    header("Location: ./users.php");
    exit();
endif;

$user_id = $_GET['id'];

// Fetch user data from the database using the $user_id

// Example query (Replace with your actual query to fetch user data)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user):
    header("Location: ./users.php");
    exit();
endif;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])):
    $error_message = "";
    $username = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_STRING) : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
    $role = isset($_POST['role']) ? intval($_POST['role']) : null;

    // Retrieve old and new password from the form
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : null;


    // Example code to update user data (Replace with your actual update logic)
    try {
        if (!empty($new_password)) {
            // Hash the new password
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role, password = :password WHERE id = :user_id");
            $stmt->bindParam(':password', $hashedPassword);
        } else {
            // If new password field is empty, exclude password from update query
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :user_id");
        }
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':user_id', $user_id);
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
                <h1 class="h2">Edit User</h1>
            </div>
            <form method="post">
                <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?= $user['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" name="role">
                        <option value="1" <?= ($user['role'] == 1) ? 'selected' : ''; ?>>Admin</option>
                        <option value="2" <?= ($user['role'] == 2) ? 'selected' : ''; ?>>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Update User</button>
            </form>
        </main>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>