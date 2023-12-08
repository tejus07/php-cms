<?php
include_once 'common/isUserLoggedIn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for adding a new user
    $host = 'localhost';
    $dbname = 'rentandgodb';
    $username = 'root';
    $password = '';

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $checkSql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':email', $_POST['email']);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            echo "Email already exists. Please use a different email address.";
            return;
        }

        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            echo "Passwords do not match. Please try again.";
            exit;
        }
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Insert new user details into the database
        $query = "INSERT INTO users (username, email, role, phone_number, password, registration_date) VALUES (:username, :email, :role, :phone_number, :password,  NOW())";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':role', $_POST['role']);
        $stmt->bindParam(':phone_number', $_POST['phone_number']);
        $stmt->bindParam(':password', $hashed_password);

        // Execute the insertion
        $stmt->execute();

        // Redirect to manage-users.php after successful addition
        header("Location: manage-users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function validateForm() {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const phoneNumber = document.getElementById('phone_number').value;

            if (username === '' || email === '' || newPassword === '' || confirmPassword === '' || phoneNumber === '') {
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

            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phoneNumber)) {
                alert('Please enter a valid 10-digit phone number');
                return false;
            }

            return true;
        }

        function validatePassword() {
            const newPassword = document.getElementById('new_password').value;
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

        function validatePhoneNumber() {
            const passwordInput = document.getElementById('phone_number');
            const passwordError = document.getElementById('phone_number_error');
            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(passwordInput.value)) {
                passwordError.innerText = 'Please enter a valid 10-digit phone number';
                passwordError.style.color = 'red';
                return false;
            } else {
                passwordError.innerText = '';
                return true;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Add New User</h1>
    </header>
    <main class="admin-container">
        <?php include('common/navbar.php'); ?>
        <section class="admin-content">
            <h2>Enter User Details</h2>
            <form method="post" action="add-new-user.php" onsubmit="return validateForm()">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"><br><br>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" oninput="return validateEmail()">
                <span id="email_error"></span>
                <br><br>

                <label for="role">Role:</label>
                <select id="role" name="role" class="form-input" required>
                    <option value="admin">Admin</option>
                    <option value="renter">Renter</option>
                    <option value="traveler">Traveler</option>
                </select><br><br>

                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" oninput="return validatePhoneNumber()">
                <span id="phone_number_error"></span><br><br>

                <label for="new_password">New Password:</label>
                <input type="text" id="new_password" name="new_password" oninput="return validatePassword()">
                <span id="password_strength"></span><br><br>
                
                <label for="confirm_password">Confirm Password:</label>
                <input type="text" id="confirm_password" name="confirm_password"><br><br>

                <input type="submit" value="Add User">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
