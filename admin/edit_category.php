<?php 
include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$category_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$query = "SELECT * FROM Categories WHERE category_id = :categoryId";

$stmt1 = $pdo->prepare($query);

$stmt1->bindParam(':categoryId', $category_id, PDO::PARAM_INT);

$stmt1->execute();

$data = $stmt1->fetch(PDO::FETCH_ASSOC);

?>

<?php
if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $category_name = $_POST['category_name'];
    $category_id = $_GET['id'];

    try {
        $sql = "UPDATE Categories SET 
        category_name = :categoryName
        WHERE category_id = :categoryId";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categoryName', $category_name);
    $stmt->bindParam(':categoryId', $category_id);

        
        echo $sql;
        $stmt->execute();

        echo "Category updated successfully!";
        header("Location: categories.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
                <!-- <li><a href="#">Comments</a></li> -->
            </ul>
        </div>

    <div class="add-recipe-container">
        <h2 class="add-recipe-title">Edit Category</h2>
        <form class="recipe-form" action="edit_category.php?id=<?php echo $data['category_id']?>" method="post">
        <div class="form-group">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" class="form-input" value="<?php echo $data['category_name']?>" required>
        </div>
            <input type="submit" value="Update Category" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>