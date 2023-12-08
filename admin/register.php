<?php
include_once '../shared/database.php';
include_once 'shared/userHandler.php';

$conn = new Database();
$userHandler = new UserHandler($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = "non-admin";
    
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
        $_SESSION['registration_success'] = "Registration was successful";
        header("Location: login.php");
    }
    

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/login_register.css">
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
    <div class="form-container">
        <h2 class="form-title">Register</h2>
        <form class="form" method="post" action="register.php" onsubmit="return validateForm()">
            <div class="input-container">
                <label for="username">Username:</label>
                <input class="input-field" type="text" name="username" id="username" required>
            </div>
            <div class="input-container">
                <label for="email">Email:</label>
                <input class="input-field" type="email" name="email" id="email" oninput="return validateEmail()" required>
                <span id="email_error"></span>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input class="input-field" type="password" name="password" id="password" oninput="return validatePassword()" required>
                <span id="password_strength"></span>
            </div>
            <div class="input-container">
                <label for="confirm_password">Confirm Password:</label>
                <input class="input-field" type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button class="form-button" type="submit">Register</button>
        </form>
        <p class="form-link">Already have an account? <a href="login.php">Login</a></p>
        <p class="form-link">Go back to <a href="../">Home</a></p>
    </div>
</body>
</html>
