<?php 
include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$recipe_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$query = "SELECT * FROM Recipes WHERE category_id = :recipeId";

$stmt1 = $pdo->prepare($query);

$stmt1->bindParam(':recipeId', $recipe_id, PDO::PARAM_INT);

$stmt1->execute();

$data = $stmt1->fetch(PDO::FETCH_ASSOC);

    // $stmt = $pdo->prepare($sqlQuery);
    // $stmt->execute([$query]);
    // $data = $stmt->fetchAll();

?>

<?php
if(empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
?>
<?php

$users = [];
$user_sql = "SELECT user_id, username FROM Users";
$user_stmt = $pdo->query($user_sql);

while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
    $users[$row['user_id']] = $row['username'];
}

$categories = [];
$category_sql = "SELECT category_id, category_name FROM Categories";
$category_stmt = $pdo->query($category_sql);

while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[$row['category_id']] = $row['category_name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $imageFileName = $_FILES['uploadFile']['name'];
    // $imageTempName = $_FILES['uploadFile']['tmp_name'];
    // $folder = "../uploads/images/".$imageFileName;
    // move_uploaded_file($imageTempName, $folder);

    $recipe_id = $_GET['id'];
    $title = $_POST['title'];
    $description = $_POST['description-hidden'];
    // $image_url = $folder;
    $preparation_time = $_POST['preparation_time'];
    $cooking_time = $_POST['cooking_time'];
    $servings = $_POST['servings'];
    $difficulty_level = $_POST['difficulty_level'];
    $cuisine = $_POST['cuisine'];
    $course = $_POST['course'];
    $instructions = $_POST['instructions'];
    $ingredients = $_POST['ingredients'];
    $category_id = $_POST['category_id'];
    $user_id = $_POST['user_id'];

    try {
        $sql = "UPDATE Recipes SET 
        title = :title,
        description = :description,
        preparation_time = :preparation_time,
        cooking_time = :cooking_time,
        servings = :servings,
        difficulty_level = :difficulty_level,
        cuisine = :cuisine,
        course = :course,
        instructions = :instructions,
        ingredients = :ingredients,
        category_id = :category_id,
        user_id = :user_id
        WHERE recipe_id = :recipe_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    // $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':preparation_time', $preparation_time);
    $stmt->bindParam(':cooking_time', $cooking_time);
    $stmt->bindParam(':servings', $servings);
    $stmt->bindParam(':difficulty_level', $difficulty_level);
    $stmt->bindParam(':cuisine', $cuisine);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':instructions', $instructions);
    $stmt->bindParam(':ingredients', $ingredients);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':recipe_id', $recipe_id);

        
        echo $sql;
        $stmt->execute();

        echo "Recipe added successfully!";
        header("Location: recipes.php");
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
        <h2 class="add-recipe-title">Add Recipe</h2>
        <form class="recipe-form" action="edit_recipe.php?id=<?php echo $data['recipe_id']?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" value="<?php echo $data['title']?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description-hidden" name="description-hidden"><?php echo $data['description']?></textarea>

        </div>
        <?php if (!empty($data['image_url'])) {?>
        <div class="form-group">
            <label for="image_url">Uploaded Image:</label>
            <span class="image-container"><img src="<?php echo $data['image_url']?>" width="100"></span>
            <!-- <input type="file" id="image_url" name="uploadFile" class="form-input" value="<?php echo $image_url?>" required> -->
        </div>
        <?php }?>
        <div class="form-group">
            <label for="preparation_time">Preparation Time (minutes):</label>
            <input type="number" id="preparation_time" name="preparation_time" class="form-input" value="<?php echo $data['preparation_time']?>" required>
        </div>
        <div class="form-group">
            <label for="cooking_time">Cooking Time (minutes):</label>
            <input type="number" id="cooking_time" name="cooking_time" class="form-input" value="<?php echo $data['cooking_time']?>" required>
        </div>
        <div class="form-group">
            <label for="servings">Servings:</label>
            <input type="number" id="servings" name="servings" class="form-input" value="<?php echo $data['servings']?>" required>
        </div>
        <div class="form-group">
            <label for="difficulty_level">Difficulty Level:</label>
            <select id="difficulty_level" name="difficulty_level" class="form-input" value="<?php echo $data['difficulty_level']?>" required>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cuisine">Cuisine:</label>
            <input type="text" id="cuisine" name="cuisine" class="form-input" value="<?php echo $data['cuisine']?>" required>
        </div>
        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" class="form-input" value="<?php echo $data['course']?>" required>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" class="form-input" required><?php echo $data['instructions']?></textarea>
        </div>
        <div class="form-group">
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" class="form-input" required><?php echo $data['ingredients']?></textarea>
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
            <input type="submit" value="Add Recipe" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>