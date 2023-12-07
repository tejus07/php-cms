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

        // Insert new user details into the database
        $query = "INSERT INTO users (username, role, phone_number, registration_date) VALUES (:username, :role, :phone_number, NOW())";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->bindParam(':role', $_POST['role']);
        $stmt->bindParam(':phone_number', $_POST['phone_number']);

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
</head>
<body>
    <header>
        <h1>Add New User</h1>
    </header>
    <main class="admin-container">
        <?php include('common/navbar.php'); ?>
        <section class="admin-content">
            <h2>Enter User Details</h2>
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"><br><br>

                <label for="role">Role:</label>
                <input type="text" id="role" name="role"><br><br>

                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number"><br><br>

                <input type="submit" value="Add User">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
