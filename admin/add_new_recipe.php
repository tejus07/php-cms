<?php
include_once '../Shared/database.php';
include_once 'shared/userHandler.php';
include_once 'shared/image_handler.php';
include_once 'shared/recipeHandler.php';
include_once 'shared/categoryHandler.php';

if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
}

$conn = new Database();
$imageHandler = new ImageHandler();
$recipeHandler = new RecipeHandler($conn);
$categoryHandler = new CategoryHandler();
$userHandler = new UserHandler();

$users = $userHandler->getUsers();

$categories = $categoryHandler->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image_url = null;

    if (!empty($_FILES['uploadFile']['name'])) {
        $imageHandler = new ImageHandler();
        $image_url = $imageHandler->upload_image($_FILES['uploadFile']);
    }

    $recipeHandler->title = $_POST['title'];
    $recipeHandler->ingredients = $_POST['ingredients'];
    $recipeHandler->instructions = $_POST['instructions'];
    $recipeHandler->user_id = $_POST['user_id'];
    $recipeHandler->category_id = $_POST['category_id'];
    $recipeHandler->image_url = $image_url;

    $recipeHandler->addRecipe();
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
<script>
    tinymce.init({
        selector: 'textarea#instructions',
        plugins: 'advlist autolink lists link image charmap print preview anchor',
        toolbar_mode: 'floating',
    });

    function updateHiddenTextarea() {
        var hiddenTextarea = document.getElementById('instructions-hidden');
        var content = tinymce.get('instructions').getContent();

        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;
        var plainText = tempDiv.textContent || tempDiv.innerText || '';

        hiddenTextarea.value = plainText.trim();

        var visibleTextarea = document.getElementById('instructions');
        visibleTextarea.value = plainText.trim();
    }

    document.querySelector('form').addEventListener('submit', updateHiddenTextarea);
</script>

<div class="add-recipe-container">
        <h2 class="add-recipe-title">Add New Pizza Recipe</h2>
        <form class="recipe-form" action="add_new_recipe.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="category_id">Select Category</label>
            <select id="category_id" name="category_id">
                <?php foreach ($categories as $categoryId => $categoryName) : ?>
                    <option value="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select id="user_id" name="user_id">
                <?php foreach ($users as $userId => $username) : ?>
                    <option value="<?php echo $userId; ?>"><?php echo $username; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" class="form-input" required></textarea>
        </div>        
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions"></textarea>
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
        <input type="submit" value="Add Recipe" class="submit-button">
    </form>
</div>

<?php include('shared/footer.php');?>
</body>
</html>
