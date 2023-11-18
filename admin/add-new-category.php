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

    $category_sql = "SELECT COUNT(*) AS total_entries FROM categories;";
    $category_stmt = $pdo->query($category_sql);
    $result = $category_stmt->fetch(PDO::FETCH_ASSOC);

    $totalEntries = $result['total_entries'];
    $total = $totalEntries + 1;

    $stmt = $pdo->prepare("INSERT INTO categories (category_id, category_name) VALUES (:category_id, :category_name)");

    $stmt->bindParam(':category_id', $total);
    $stmt->bindParam(':category_name', $_POST['category_name']);

    $stmt->execute();

    echo "New category added successfully!";
    header("Location: manage-categories.php");
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
            <form class="add-new-form" action="add-new-category.php" method="post">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" required><br><br>

                <input type="submit" value="Submit">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
