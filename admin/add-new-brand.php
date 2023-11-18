<?php
include_once 'common/isUserLoggedIn.php';

$host = 'localhost';
$dbname = "rentandgodb";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO brands (brand_name) VALUES (:brand_name)");

    $stmt->bindParam(':brand_name', $_POST['brand_name']);

    $stmt->execute();

    echo "New brand added successfully!";
    header("Location: manage-brands.php");
} 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Brand</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Add New Brand</h1>
    </header>
    <main class="admin-container">
	<?php include('common/navbar.php');?>
        <section class="admin-content">
            <form class="add-new-form" action="add-new-brand.php" method="post">
                <label for="brand_name">Brand Name:</label>
                <input type="text" id="brand_name" name="brand_name" required><br><br>

                <input type="submit" value="Submit">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
