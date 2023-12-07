<?php 
include_once 'shared/categoryHandler.php';

// Check if user is logged in
if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Create an instance of CategoryHandler
$categoryHandler = new CategoryHandler();

// Retrieve category data based on the provided category ID ($_GET['id'])
$category_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$data = $categoryHandler->getCategoryById($category_id);

// Check if the category data is valid
if ($data === false) {
    echo "Category not found!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from the form
    $title = $_POST['title'];

    // Update category using CategoryHandler
    $updateResult = $categoryHandler->updateCategory($category_id, $title);

    if ($updateResult) {
        echo "Category updated successfully!";
        header("Location: categories.php");
        exit();
    } else {
        echo "Failed to update category.";
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
    <title>Edit Category</title>
</head>
<body>
<?php include('shared/sidebar.php');?>

<div class="edit-category-container">
    <h2 class="edit-category-title">Edit Pizza Category</h2>
    <form class="category-form" action="edit_category.php?id=<?php echo $data['category_id']; ?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" value="<?php echo $data['title']; ?>" required>
        </div>
        <input type="submit" value="Update Category" class="submit-button">
    </form>
</div>

<?php include('shared/footer.php');?>
</body>
</html>
