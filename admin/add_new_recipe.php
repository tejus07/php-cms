<?php
include_once '../Shared/database.php';
include_once 'shared/image_handler.php';
include_once 'shared/recipeHandler.php';
include_once 'shared/categoryHandler.php';
include_once 'shared/userHandler.php';

if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
}

if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
    $title = $_GET['title'];
    $description = $_GET['description'];
    $preparation_time = $_GET['preparation_time'];
    $cooking_time = $_GET['cooking_time'];
    $servings = $_GET['servings'];
    $difficulty_level = $_GET['difficulty_level'];
    $cuisine = $_GET['cuisine'];
    $course = $_GET['course'];
    $instructions = $_GET['instructions'];
    $ingredients = $_GET['ingredients'];
    $category_id = $_GET['category_id'];
    $user_id = $_GET['user_id'];
}

$conn = new Database();
$imageHandler = new ImageHandler();
$recipeHandler = new RecipeHandler($conn);
$categoryHandler = new CategoryHandler($conn);
$userHandler = new UserHandler($conn);

$users = $userHandler->getUsers();

$categories = $categoryHandler->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $recipeHandler->title = htmlspecialchars($_POST['title']);
    $recipeHandler->description = $_POST['description-hidden'];
    $recipeHandler->preparation_time = filter_input(INPUT_POST, 'preparation_time', FILTER_VALIDATE_INT);
    $recipeHandler->cooking_time = filter_input(INPUT_POST, 'cooking_time', FILTER_VALIDATE_INT);
    $recipeHandler->servings = filter_input(INPUT_POST, 'servings', FILTER_VALIDATE_INT);
    $recipeHandler->difficulty_level = htmlspecialchars($_POST['difficulty_level']);
    $recipeHandler->cuisine = htmlspecialchars($_POST['cuisine']);
    $recipeHandler->course = htmlspecialchars($_POST['course']);
    $recipeHandler->instructions = htmlspecialchars($_POST['instructions']);
    $recipeHandler->ingredients = htmlspecialchars($_POST['ingredients']);
    $recipeHandler->category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $recipeHandler->user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

    if ($recipeHandler->title && $recipeHandler->description && $recipeHandler->preparation_time !== false &&
        $recipeHandler->cooking_time !== false && $recipeHandler->servings !== false &&
        $recipeHandler->category_id !== false && $recipeHandler->user_id !== false) {

        $recipeHandler->image_url = (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] !== UPLOAD_ERR_NO_FILE) ? $imageHandler->upload_image($_FILES['uploadFile']) : null;

        $requestStatus = $recipeHandler->addRecipe();

        if ($requestStatus === true) {
            header("Location: recipes.php");
            exit();
        }
    } else {
        $error_message = "Please enter all required fields";
        header("Location: add_new_recipe.php?error=" . urlencode($error_message) . "&title=" . urlencode($_POST['title']) . "&description=" . urlencode($_POST['description-hidden']) . "&preparation_time=" . urlencode($_POST['preparation_time']) . "&cooking_time=" . urlencode($_POST['cooking_time']) . "&servings=" . urlencode($_POST['servings']) . "&difficulty_level=" . urlencode($_POST['difficulty_level']) . "&cuisine=" . urlencode($_POST['cuisine']) . "&course=" . urlencode($_POST['course']) . "&instructions=" . urlencode($_POST['instructions']) . "&ingredients=" . urlencode($_POST['ingredients']) . "&category_id=" . urlencode($_POST['category_id']) . "&user_id=" . urlencode($_POST['user_id']));
        exit();
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
<script>
    tinymce.init({
        selector: 'textarea#description-hidden',
        plugins: 'advlist autolink lists link image charmap print preview anchor',
        toolbar_mode: 'floating',
    });


    function updateHiddenTextarea() {
        var hiddenTextarea = document.getElementById('description-hidden');
        var content = tinymce.get('description').getContent();
        hiddenTextarea.value = content;
    }

    document.querySelector('form').addEventListener('submit', updateHiddenTextarea);
</script>

    <div class="add-recipe-container">
        
        <?php if (isset($_GET['error'])) {?>
            <div class='col-md-9 ml-sm-auto col-lg-10 px-md-4'>
                <div class='error-message'><?php echo $error_message; ?></div>
            </div>
        <?php } ?>

        <h2 class="add-recipe-title">Add Recipe</h2>
        <form class="recipe-form" action="add_new_recipe.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" <?php if(isset($_GET['error']) && $title) { echo 'value="' . $title . '"';}?>>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description-hidden" name="description-hidden"><?php if(isset($_GET['error']) && $description) { echo $description; }?></textarea>

        </div>
        <div class="form-group">
            <label for="image_url">Upload Image:</label>
            <input type="file" id="image_url" name="uploadFile" class="form-input">
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', ()=>{
                document.getElementById('image_url').addEventListener('change', function() {
                    const fileInput = document.getElementById('image_url');
                    const filePath = fileInput.value;
                    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

                    if (!allowedExtensions.exec(filePath)) {
                        alert('Please upload files having extensions .jpg/.jpeg/.png/.gif only.');
                        fileInput.value = '';
                        throw new Error('Incorrect file format');
                    }
                });
            });
        </script>

        <div class="form-group">
            <label for="preparation_time">Preparation Time (minutes):</label>
            <input type="number" id="preparation_time" name="preparation_time" class="form-input" <?php if(isset($_GET['error']) && $preparation_time) { echo 'value="' . $preparation_time . '"';}?> required>
        </div>
        <div class="form-group">
            <label for="cooking_time">Cooking Time (minutes):</label>
            <input type="number" id="cooking_time" name="cooking_time" class="form-input" <?php if(isset($_GET['error']) && $cooking_time) { echo 'value="' . $cooking_time . '"';}?> required>
        </div>
        <div class="form-group">
            <label for="servings">Servings:</label>
            <input type="number" id="servings" name="servings" class="form-input" <?php if(isset($_GET['error']) && $servings) { echo 'value="' . $servings . '"';}?> required>
        </div>
        <div class="form-group">
            <label for="difficulty_level">Difficulty Level:</label>
            <select id="difficulty_level" name="difficulty_level" class="form-input" required>
                <option value="Easy" <?php if(isset($_GET['error']) && $difficulty_level && $difficulty_level == "Easy") { echo "Selected"; } ?>>Easy</option>
                <option value="Medium" <?php if(isset($_GET['error']) && $difficulty_level && $difficulty_level == "Medium") { echo "Selected"; } ?>>Medium</option>
                <option value="Hard" <?php if(isset($_GET['error']) && $difficulty_level && $difficulty_level == "Hard") { echo "Selected"; } ?>>Hard</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cuisine">Cuisine:</label>
            <input type="text" id="cuisine" name="cuisine" class="form-input" <?php if(isset($_GET['error']) && $cuisine) { echo 'value="' . $cuisine . '"';}?> required>
        </div>
        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" class="form-input" <?php if(isset($_GET['error']) && $course) { echo 'value="' . $course . '"';}?> required>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" class="form-input" required><?php if(isset($_GET['error']) && $instructions) { echo $instructions; }?></textarea>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" class="form-input" required><?php if(isset($_GET['error']) && $ingredients) { echo $ingredients; }?></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Select Category</label>
            <select id="category_id" name="category_id">
            <?php foreach ($categories as $categoryId => $categoryName) : ?>
                <option value="<?php echo $categoryId; ?>" <?php if(isset($_GET['error']) && $category_id && $category_id == $categoryId) { echo "Selected"; } ?>><?php echo $categoryName; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select id="user_id" name="user_id">
                <?php foreach ($users as $userId => $username) : ?>
                    <option value="<?php echo $userId; ?>" <?php if(isset($_GET['error']) && $user_id && $user_id == $userId) { echo "Selected"; } ?>><?php echo $username; ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
            <input type="submit" value="Add Recipe" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>