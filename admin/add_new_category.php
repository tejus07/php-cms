<?php
include_once 'shared/categoryHandler.php';

if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
}

$categoryHandler = new CategoryHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $categoryHandler->category_name = $_POST['category_name'];

    $categoryHandler->addCategory();

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
        <h2 class="add-recipe-title">Add Category</h2>
        <form class="recipe-form" action="add_new_category.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" class="form-input" required>
        </div>
            <input type="submit" value="Add Recipe" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>