<?php

include_once '../shared/database.php';
include_once '../admin/shared/image_handler.php';
include_once '../admin/shared/recipeHandler.php';
include_once '../admin/shared/categoryHandler.php';
include_once '../admin/shared/userHandler.php';

if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
}

$conn = new Database();
$imageHandler = new ImageHandler();
$recipeHandler = new RecipeHandler($conn);
$categoryHandler = new CategoryHandler($conn);

$users_id = $_SESSION['user_id'];

$categories = $categoryHandler->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $recipeHandler->image_url = (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] !== UPLOAD_ERR_NO_FILE) ? $imageHandler->upload_image($_FILES['uploadFile']) : null;
    $recipeHandler->title = $_POST['title'];
    $recipeHandler->description = $_POST['description-hidden'];
    $recipeHandler->preparation_time = $_POST['preparation_time'];
    $recipeHandler->cooking_time = $_POST['cooking_time'];
    $recipeHandler->servings = $_POST['servings'];
    $recipeHandler->difficulty_level = $_POST['difficulty_level'];
    $recipeHandler->cuisine = $_POST['cuisine'];
    $recipeHandler->course = $_POST['course'];
    $recipeHandler->instructions = $_POST['instructions'];
    $recipeHandler->ingredients = $_POST['ingredients'];
    $recipeHandler->category_id = $_POST['category_id'];
    $recipeHandler->user_id = $users_id;

    $requestStatus = $recipeHandler->addRecipe();

    if ($requestStatus === true) {
        header("Location: my_post.php");
    }

}
?>

<?php include('shared/header.php'); ?>

<link rel="stylesheet" type="text/css" href="../css/styles.css">
<style>
.sidebar {
    width: 250px;
    background-color: #fff; /* White sidebar background */
    padding: 15px;
    border-right: 1px solid #ccc; /* Light border */
}

.sidebar h2 {
    margin-bottom: 15px;
    color: #333; /* Dark text color */
}

.sidebar ul {
    list-style: none;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    color: #333; /* Dark text color */
    text-decoration: none;
    display: block;
    padding: 8px 0;
    transition: background-color 0.3s ease;
}

.sidebar ul li a:hover {
    background-color: #f0f0f0; /* Hover background color */
}

.main-container {
    display: flex;
    flex-direction: row;
}

.user-dashboard {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    padding: 20px;
}

.content {
    flex: 1;
    padding: 20px;
}

</style>

<?php
    include_once '../shared/database.php';
    include_once '../admin/shared/recipeHandler.php';

    $conn = new Database();
    $recipeHandler = new RecipeHandler($conn);

    $user_id = $_SESSION['user_id'];

    $recipesList = [];

    $recipesList = $recipeHandler->getAllRecipes($user_id);

?>

    <div class="user-dashboard">
        <aside class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="my_post.php">My Post</a></li>
                <li><a href="add_new_post.php">Add New Post</a></li>
            </ul>
        </aside>

        <main class="main-container">
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
        <h2 class="add-recipe-title">Add Recipe</h2>
        <form class="recipe-form" action="add_new_post.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description-hidden" name="description-hidden"></textarea>

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
            <input type="number" id="preparation_time" name="preparation_time" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="cooking_time">Cooking Time (minutes):</label>
            <input type="number" id="cooking_time" name="cooking_time" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="servings">Servings:</label>
            <input type="number" id="servings" name="servings" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="difficulty_level">Difficulty Level:</label>
            <select id="difficulty_level" name="difficulty_level" class="form-input" required>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cuisine">Cuisine:</label>
            <input type="text" id="cuisine" name="cuisine" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" class="form-input" required></textarea>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" class="form-input" required></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Select Category</label>
            <select id="category_id" name="category_id">
            <?php foreach ($categories as $categoryId => $categoryName) : ?>
                <option value="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
            <input type="submit" value="Add Recipe" class="submit-button">
        </form>
    </div>
        </main>
    </div>

<?php include('shared/footer.php');?>