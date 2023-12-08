
<?php include('shared/header.php'); ?>
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
$userHandler = new UserHandler($conn);

$users = $userHandler->getUsers();

$categories = $categoryHandler->getCategories();

$recipe_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$data = $recipeHandler->getSingleRecipe($recipe_id);


$error_message = (isset($_GET['error'])) ? $_GET['error'] : null;
$error_message = (isset($_GET['error'])) ? $_GET['error'] : null;
$title = (isset($_GET['error'])) ? $_GET['title'] : $data['title'];
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
    $recipeHandler->ingredients = htmlspecialchars($_POST['ingredients']);
    $recipeHandler->instructions = $_POST['instructions'];
    $recipeHandler->user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $recipeHandler->category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

    if ($recipeHandler->title && $recipeHandler->category_id !== false && $recipeHandler->user_id !== false) {

        $recipeHandler->image_url = (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] !== UPLOAD_ERR_NO_FILE) ? $imageHandler->upload_image($_FILES['uploadFile']) : null;

        $requestStatus = $recipeHandler->editRecipe($recipe_id);

        if ($requestStatus === true) {
            header("Location: my_post.php");
            exit();
        }
    } else {
        $error_message = "Please enter all required fields";
        header("Location: edit_post.php?id=". $recipe_id . "&error=" . urlencode($error_message) . "&title=" . urlencode($_POST['title']) . "&instructions=" . urlencode($_POST['instructions']) . "&preparation_time=" . urlencode($_POST['preparation_time']) . "&cooking_time=" . urlencode($_POST['cooking_time']) . "&servings=" . urlencode($_POST['servings']) . "&difficulty_level=" . urlencode($_POST['difficulty_level']) . "&cuisine=" . urlencode($_POST['cuisine']) . "&course=" . urlencode($_POST['course']) . "&instructions=" . urlencode($_POST['instructions']) . "&ingredients=" . urlencode($_POST['ingredients']) . "&category_id=" . urlencode($_POST['category_id']) . "&user_id=" . urlencode($_POST['user_id']));
        exit();
    }
}
?>

        <main class="main-container">
            <script>
                tinymce.init({
                    selector: 'textarea#instructions',
                    plugins: 'advlist autolink lists link image charmap print preview anchor',
                    toolbar_mode: 'floating',
                });
            </script>
            
            <div class="add-recipe-container">
    


                <h2 class="mt-4 mb-4">Edit Recipe</h2>
                <form class="recipe-form" action="edit_post.php?id=<?php echo $recipe_id; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?php echo $title; ?>">
                </div>
                <div class="form-group">
                    <label for="category_id">Select Category</label>
                    <select id="category_id" name="category_id" value="<?php echo $category_id?>">
                    <?php foreach ($categories as $categoryId => $categoryName) : ?>
                        <option value="<?php echo $categoryId; ?>" <?php if($category_id == $categoryId) { echo "Selected"; } ?>><?php echo $categoryName; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ingredients">Ingredients:</label>
                    <textarea id="ingredients" name="ingredients" class="form-control" required><?php echo $ingredients; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="instructions">instructions:</label>
                    <textarea id="instructions" name="instructions" class="form-control"><?php echo $instructions; ?></textarea>
        
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
                    <input type="file" id="image_url" name="uploadFile" class="form-control">
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
                    <input type="submit" value="Update Recipe" class="submit-button btn btn-primary">
                </form>
            </div>
        </main>
    </div>

<?php include('../shared/footer.php');?>