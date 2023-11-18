<?php
include_once 'common/isUserLoggedIn.php';

$host = 'localhost';
$dbname = "rentandgodb";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $category_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
    $query = "SELECT * FROM Categories WHERE category_id = :category_id";

    $stmt1 = $pdo->prepare($query);

    $stmt1->bindParam(':category_id', $category_id, PDO::PARAM_INT);

    $stmt1->execute();

    $data = $stmt1->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("UPDATE categories SET  category_name = :category_name WHERE category_id = :category_id");

    $stmt->bindParam(':category_id', $category_id);
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
            <form class="add-new-form" action="edit-category.php?id=<?php echo $data['category_id']?>" method="post">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" value="<?php echo $data['category_name']?>" required><br><br>

                <input type="submit" value="Submit">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
