<?php
include_once '../Shared/database.php';
include_once 'shared/userHandler.php';

if(empty($_SESSION['user_id']) || empty($_SESSION['role'])) {
    header('Location: login.php');
}

$conn = new Database();
$userHandler = new UserHandler($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    if ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
        exit;
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $userHandler->username = $username;
    $userHandler->email = $email;
    $userHandler->password = $hashed_password;
    $userHandler->role = $role;
    
    $requestStatus = $userHandler->addUser();
    
    if ($requestStatus == true) {
        header("Location: users.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <link rel="stylesheet" href="css/admin-panel.css">
    <title>Admin Panel</title>
    <script>
        function validateForm() {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const newPassword = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (username === '' || email === '' || newPassword === '' || confirmPassword === '') {
                alert('All fields are required');
                return false;
            }

            if (newPassword.length < 8) {
                alert('Password should be at least 8 characters long');
                return false;
            }

            if (newPassword !== confirmPassword) {
                alert('Passwords do not match');
                return false;
            }

            return true;
        }

        function validatePassword() {
            const newPassword = document.getElementById('password').value;
            const passwordStrength = document.getElementById('password_strength');

            if (newPassword.length < 8) {
                passwordStrength.innerText = 'Weak password';
                passwordStrength.style.color = 'red';
            } else {
                passwordStrength.innerText = 'Strong password';
                passwordStrength.style.color = 'green';
            }
        }
        
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email_error');
            const email = emailInput.value.trim();

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                emailError.innerText = 'Please enter a valid email address';
                emailError.style.color = 'red';
                return false;
            } else {
                emailError.innerText = '';
                return true;
            }
        }
    </script>
</head>
<body>
    <div class="admin-panel">
        <div class="sidebar">
            <h1>Admin Panel</h1>
            <ul>
                <li><a href="./">Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="categories.php">Categories</a></li>
            </ul>
        </div>

    <div class="add-recipe-container">
        <h2 class="add-recipe-title">Add User</h2>
        <form class="recipe-form" action="add_new_user.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="username">User Name:</label>
            <input type="text" id="username" name="username" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" class="form-input" oninput="return validateEmail()" required>
            <span id="email_error"></span>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" class="form-input" oninput="return validatePassword()" required>
            <span id="password_strength"></span>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="text" id="confirm_password" name="confirm_password" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select id="role" name="role" class="form-input" required>
                <option value="admin">Admin</option>
                <option value="non-admin">Non-admin</option>
            </select>
        </div>
            <input type="submit" value="Add User" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>