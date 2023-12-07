<?php
include_once 'shared/categoryHandler.php';

if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$categoryHandler = new CategoryHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $categoryHandler->title = $_POST['title'];

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
<?php include('shared/sidebar.php');?>

    <div class="add-category-container">
        <h2 class="add-category-title">Add New Pizza Category</h2>
        <form class="category-form" action="add_new_categories.php" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" required>
        </div>
            <input type="submit" value="Add Category" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>