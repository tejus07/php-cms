<?php 

include_once 'shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$recipe_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$query = "SELECT
    R.recipe_id,
    R.title AS recipe_title,
    R.instructions,
    R.ingredients,
    C.title, 
    U.username AS user_username,
    U.email AS user_email
FROM pizzarecipes R
INNER JOIN Categories C ON R.category_id = C.category_id
INNER JOIN Users U ON R.user_id = U.user_id
WHERE R.recipe_id = :recipeId";

$stmt = $pdo->prepare($query);


$stmt->bindParam(':recipeId', $recipe_id, PDO::PARAM_INT);


$stmt->execute();


$data = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<?php include('shared/header.php');?>

<main>
<div class="container">
        <h1 class="recipe-title"><?php echo $data['recipe_title']; ?></h1>
        <!-- <p class="recipe-description">
        </p> -->

        <h2 class="section-title">User Information</h2>
        <ul class="details-list">
            <li class="detail-item">Pizza reciepe by: 
        <p class="user-info">Username: <?php echo $data['user_username']; ?></p>
        <p class="user-info">Email: <?php echo $data['user_email']; ?></p></li>
        </ul>

        <h2 class="section-title">Instructions</h2>
        <p class="instructions"><?php echo $data['instructions']; ?></p>

        <h2 class="section-title">Ingredients</h2>
        <p class="ingredients"><?php echo $data['ingredients']; ?></p>

        <h2 class="section-title">Category</h2>
        <p class="category"><?php echo $data['title']; ?></p>

        <a class="btn" href="index.php">Back to Recipes</a>
    </div>

</main>

<?php include('shared/footer.php');?>