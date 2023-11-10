<?php 

include_once 'shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$recipe_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
// $query = '';
// if($recipe_id) {		
//     $query = " AND p.recipe_id ='".$recipe_id."'";
// }
$query = "SELECT
    R.recipe_id,
    R.title AS recipe_title,
    R.description AS recipe_description,
    R.preparation_time,
    R.cooking_time,
    R.servings,
    R.difficulty_level,
    R.cuisine,
    R.course,
    R.instructions,
    R.ingredients,
    C.category_name,
    U.username AS user_username,
    U.email AS user_email
FROM Recipes R
INNER JOIN Categories C ON R.category_id = C.category_id
INNER JOIN Users U ON R.user_id = U.user_id
WHERE R.recipe_id = :recipeId";

$stmt = $pdo->prepare($query);


$stmt->bindParam(':recipeId', $recipe_id, PDO::PARAM_INT);


$stmt->execute();


$data = $stmt->fetch(PDO::FETCH_ASSOC);

    // $stmt = $pdo->prepare($sqlQuery);
    // $stmt->execute([$query]);
    // $data = $stmt->fetchAll();

?>

<?php include('shared/header.php');?>

<main>
<div class="container">
        <h1 class="recipe-title"><?php echo $data['recipe_title']; ?></h1>
        <p class="recipe-description"><?php echo $data['recipe_description']; ?></p>

        <h2 class="section-title">Recipe Details</h2>
        <ul class="details-list">
            <li class="detail-item">Preparation Time: <?php echo $data['preparation_time']; ?> minutes</li>
            <li class="detail-item">Cooking Time: <?php echo $data['cooking_time']; ?> minutes</li>
            <li class="detail-item">Servings: <?php echo $data['servings']; ?></li>
            <li class="detail-item">Difficulty Level: <?php echo $data['difficulty_level']; ?></li>
            <li class="detail-item">Cuisine: <?php echo $data['cuisine']; ?></li>
            <li class="detail-item">Course: <?php echo $data['course']; ?></li>
        </ul>

        <h2 class="section-title">Instructions</h2>
        <p class="instructions"><?php echo $data['instructions']; ?></p>

        <h2 class="section-title">Ingredients</h2>
        <p class="ingredients"><?php echo $data['ingredients']; ?></p>

        <h2 class="section-title">Category</h2>
        <p class="category"><?php echo $data['category_name']; ?></p>

        <h2 class="section-title">User Information</h2>
        <p class="user-info">Username: <?php echo $data['user_username']; ?></p>
        <p class="user-info">Email: <?php echo $data['user_email']; ?></p>

        <a class="btn" href="index.php">Back to Recipes</a>
    </div>

</main>

<?php include('shared/footer.php');?>