<?php 

include_once '../Shared/database.php';
include_once 'shared/image_handler.php';
include_once 'shared/recipeHandler.php';
include_once 'shared/categoryHandler.php';
include_once 'shared/userHandler.php';

if(empty($_SESSION['user_id']) || empty($_SESSION['user_role'])) {
    header('Location: login.php');
}


$conn = new Database();
$imageHandler = new ImageHandler();
$recipeHandler = new RecipeHandler($conn);
$categoryHandler = new CategoryHandler($conn);
$userHandler = new UserHandler($conn);

$users = $userHandler->getUsers();

$categories = $categoryHandler->getCategories();

$recipe_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$data = $recipeHandler->getSingleRecipe($recipe_id);

    $error_message = (isset($_GET['error'])) ? $_GET['error'] : null;
    $title = (isset($_GET['error'])) ? $_GET['title'] : $data['title'];
    $description = (isset($_GET['error'])) ? $_GET['description'] : $data['description'];
    $preparation_time = (isset($_GET['error'])) ? $_GET['preparation_time'] : $data['preparation_time'];
    $cooking_time = (isset($_GET['error'])) ? $_GET['cooking_time'] : $data['cooking_time'];
    $servings = (isset($_GET['error'])) ? $_GET['servings'] : $data['servings'];
    $difficulty_level = (isset($_GET['error'])) ? $_GET['difficulty_level'] : $data['difficulty_level'];
    $cuisine = (isset($_GET['error'])) ? $_GET['cuisine'] : $data['cuisine'];
    $course = (isset($_GET['error'])) ? $_GET['course'] : $data['course'];
    $instructions = (isset($_GET['error'])) ? $_GET['instructions'] : $data['instructions'];
    $ingredients = (isset($_GET['error'])) ? $_GET['ingredients'] : $data['ingredients'];
    $category_id = (isset($_GET['error'])) ? $_GET['category_id'] : $data['category_id'];
    $user_id = (isset($_GET['error'])) ? $_GET['user_id'] : $data['user_id'];

$users = $userHandler->getUsers();

$categories = $categoryHandler->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $image_url = $data['image_url'];

    if (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] !== UPLOAD_ERR_NO_FILE && !isset($_POST['delete_image'])) {

        $returned_value = $imageHandler->upload_image($_FILES['uploadFile']);
        if($returned_value) {
            $image_url = $returned_value;
        }
    } else if(isset($_POST['delete_image'])) {
        $image_path = "../" . $image_url;
        if (file_exists($image_path)) {
            unlink($image_path);
            echo "Image deleted successfully!";
        } else {
            echo "Image not found.";
        }

        $image_url = null;
    }

    $recipe_id = $_GET['id'];
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

        $recipeHandler->image_url = $image_url;

        $requestStatus = $recipeHandler->editRecipe($recipe_id);

        if ($requestStatus === true) {
            header("Location: recipes.php");
            exit();
        }
    } else {
        $error_message = "Please enter all required fields";
        header("Location: edit_recipe.php?id=". $recipe_id . "&error=" . urlencode($error_message) . "&title=" . urlencode($_POST['title']) . "&description=" . urlencode($_POST['description-hidden']) . "&preparation_time=" . urlencode($_POST['preparation_time']) . "&cooking_time=" . urlencode($_POST['cooking_time']) . "&servings=" . urlencode($_POST['servings']) . "&difficulty_level=" . urlencode($_POST['difficulty_level']) . "&cuisine=" . urlencode($_POST['cuisine']) . "&course=" . urlencode($_POST['course']) . "&instructions=" . urlencode($_POST['instructions']) . "&ingredients=" . urlencode($_POST['ingredients']) . "&category_id=" . urlencode($_POST['category_id']) . "&user_id=" . urlencode($_POST['user_id']));
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
</script>

    <div class="add-recipe-container">
                
        <?php if (isset($_GET['error'])) {?>
            <div class='col-md-9 ml-sm-auto col-lg-10 px-md-4'>
                <div class='error-message'><?php echo $error_message; ?></div>
            </div>
        <?php } ?>
        <h2 class="add-recipe-title">Edit Recipe</h2>
        <form class="recipe-form" action="edit_recipe.php?id=<?php echo $recipe_id; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" value="<?php echo $title; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description-hidden" name="description-hidden"><?php echo $description; ?></textarea>

        </div>
        <?php if (!empty($data['image_url'])) {?>
        <div class="form-group">
            <label for="image_url">Uploaded Image:</label>
            <span class="image-container"><img src="../<?php echo $data['image_url']?>" width="100"></span>
        </div>
        <div class="form-group">
            <label for="delete_image">Delete Image: </label>
            <span class="delete-checkbox">
                <input type="checkbox" id="delete_image" name="delete_image" value="delete">
            </span>            
        </div>
        <?php }?>

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
            <input type="number" id="preparation_time" name="preparation_time" class="form-input" value="<?php echo $preparation_time; ?>" required>
        </div>
        <div class="form-group">
            <label for="cooking_time">Cooking Time (minutes):</label>
            <input type="number" id="cooking_time" name="cooking_time" class="form-input" value="<?php echo $cooking_time; ?>" required>
        </div>
        <div class="form-group">
            <label for="servings">Servings:</label>
            <input type="number" id="servings" name="servings" class="form-input" value="<?php echo $servings; ?>" required>
        </div>
        <div class="form-group">
            <label for="difficulty_level">Difficulty Level:</label>
            <select id="difficulty_level" name="difficulty_level" class="form-input" value="<?php echo $difficulty_level; ?>" required>
                <option value="Easy" <?php if($difficulty_level == "Easy") { echo "Selected"; } ?>>Easy</option>
                <option value="Medium" <?php if($difficulty_level == "Medium") { echo "Selected"; } ?>>Medium</option>
                <option value="Hard" <?php if($difficulty_level == "Hard") { echo "Selected"; } ?>>Hard</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cuisine">Cuisine:</label>
            <input type="text" id="cuisine" name="cuisine" class="form-input" value="<?php echo $cuisine; ?>" required>
        </div>
        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" class="form-input" value="<?php echo $course; ?>" required>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" class="form-input" required><?php echo $instructions; ?></textarea>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" class="form-input" required><?php echo $ingredients; ?></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Select Category</label>
            <select id="category_id" name="category_id" value="<?php echo $category_id; ?>">
            <?php foreach ($categories as $categoryId => $categoryName) : ?>
                <option value="<?php echo $categoryId; ?>" <?php if($category_id == $categoryId) { echo "Selected"; } ?>><?php echo $categoryName; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                <?php foreach ($users as $userId => $username) : ?>
                    <option value="<?php echo $userId; ?>" <?php if($user_id == $userId) { echo "Selected"; } ?>><?php echo $username; ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
            <input type="submit" value="Update Recipe" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>