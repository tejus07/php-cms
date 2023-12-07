<?php
include_once 'common/isUserLoggedIn.php';

// Check if user_id is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect if user_id is missing
    header("Location: manage-users.php");
    exit();
}

$user_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating user details
    $host = 'localhost';
    $dbname = 'rentandgodb';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update user details in the database based on the user_id
        $query = "UPDATE users SET username = :username, role = :role, phone_number = :phone_number WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->bindParam(':role', $_POST['role']);
        $stmt->bindParam(':phone_number', $_POST['phone_number']);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the update
        $stmt->execute();

        // Redirect to manage-users.php after successful update
        header("Location: manage-users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch user details to pre-fill the form
try {
    $host = 'localhost';
    $dbname = 'rentandgodb';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Edit User</h1>
    </header>
    <main class="admin-container">
        <?php include('common/navbar.php'); ?>
        <section class="admin-content">
            <h2>Edit User Details</h2>
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>"><br><br>

                <label for="role">Role:</label>
                <input type="text" id="role" name="role" value="<?php echo $user['role']; ?>"><br><br>

                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>"><br><br>

                <input type="submit" value="Update">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
