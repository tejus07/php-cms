<?php
include_once '../shared/database.php';

if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$pdo = $database->getConnection();

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
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $image_url = ""; // Add logic to handle image upload if needed
    $user_id = $_POST['user_id'];
    $category_id = $_POST['category_id'];

    try {
        $sql = "INSERT INTO pizzaRecipes (title, ingredients, instructions, image_url, user_id, category_id, created_at) VALUES (:title, :ingredients, :instructions, :image_url, :user_id, :category_id, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':ingredients', $ingredients);
        $stmt->bindParam(':instructions', $instructions);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':category_id', $category_id);

        $stmt->execute();

        echo "Recipe added successfully!";
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
    });


    function updateHiddenTextarea() {
        var hiddenTextarea = document.getElementById('instructions-hidden');
        var content = tinymce.get('instructions').getContent();

        // Extract plain text from HTML content
        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;
        var plainText = tempDiv.textContent || tempDiv.innerText || '';

        hiddenTextarea.value = plainText.trim();

        // Update visible textarea for submission
        var visibleTextarea = document.getElementById('instructions');
        visibleTextarea.value = plainText.trim();
    }


    document.querySelector('form').addEventListener('submit', updateHiddenTextarea);
</script>

    <div class="add-recipe-container">
        <h2 class="add-recipe-title">Add New Pizza Recipe</h2>
        <form class="recipe-form" action="add_new_recipe.php" method="post">
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

            <input type="submit" value="Add Recipe" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>