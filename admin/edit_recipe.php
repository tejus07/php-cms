<?php 
include_once '../shared/database.php';

$database = new Database();
$pdo = $database->getConnection();

$recipe_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$query = "SELECT * FROM pizzaRecipes WHERE recipe_id = :recipeId";

$stmt1 = $pdo->prepare($query);
$stmt1->bindParam(':recipeId', $recipe_id, PDO::PARAM_INT);
$stmt1->execute();
$data = $stmt1->fetch(PDO::FETCH_ASSOC);

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$users = [];
$user_sql = "SELECT user_id, username FROM users";
$user_stmt = $pdo->query($user_sql);

while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
    $users[$row['user_id']] = $row['username'];
}

$categories = [];
$category_sql = "SELECT category_id, title FROM categories";
$category_stmt = $pdo->query($category_sql);

while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[$row['category_id']] = $row['title'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from the form
    $recipe_id = $_GET['id'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $user_id = $_POST['user_id'];
    $category_id = $_POST['category_id'];

    try {
        // Update the recipe in the database
        $sql = "UPDATE pizzaRecipes SET 
            title = :title,
            ingredients = :ingredients,
            instructions = :instructions,
            user_id = :user_id,
            category_id = :category_id
            WHERE recipe_id = :recipe_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':ingredients', $ingredients);
        $stmt->bindParam(':instructions', $instructions);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':recipe_id', $recipe_id);

        $stmt->execute();

        echo "Recipe updated successfully!";
        header("Location: recipes.php");
        exit();
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
<?php include('shared/sidebar.php');?>
<script>
    tinymce.init({
        selector: 'textarea#instructions',
        plugins: 'advlist autolink lists link image charmap print preview anchor',
        toolbar_mode: 'floating',
        setup: function (editor) {
            editor.on('init', function () {
                // Get the existing instructions from PHP
                var existingInstructions = <?php echo json_encode($data['instructions']); ?>;
                // Set the existing instructions into the editor
                editor.setContent(existingInstructions);
            });
        }
    });
</script>

    <div class="add-recipe-container">
        <h2 class="add-recipe-title">Edit Pizza Recipe</h2>
        <form class="recipe-form" action="edit_recipe.php?id=<?php echo $data['recipe_id']?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" value="<?php echo $data['title']?>" required>
        </div>
        <div class="form-group">
            <label for="category_id">Select Category</label>
            <select id="category_id" name="category_id" value="<?php echo $data['category_id']?>">
            <?php foreach ($categories as $categoryId => $categoryName) : ?>
                <option value="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select id="user_id" name="user_id" value="<?php echo $data['user_id']?>">
                <?php foreach ($users as $userId => $username) : ?>
                    <option value="<?php echo $userId; ?>"><?php echo $username; ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" class="form-input" required><?php echo $data['ingredients']?></textarea>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" value="<?php echo $data['instructions']?>"></textarea>
        </div>
        <?php if (!empty($data['image_url'])) {?>
        <div class="form-group">
            <label for="image_url">Uploaded Image:</label>
            <span class="image-container"><img src="../<?php echo $data['image_url']?>" width="100"></span>
        </div>
        <?php }?>
            <input type="submit" value="Save" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>