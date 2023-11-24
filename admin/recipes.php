<?php
include_once '../shared/database.php';

$database = new Database();
$pdo = $database->getConnection();

$recipesList = $pdo->query('SELECT * FROM pizzarecipes');
$recipeCount = $recipesList->rowCount(); // Count the number of recipes

?>

<?php include('shared/sidebar.php');?>

<div class="content">
    <main>
    <div class="list-container">
        <h2 class="recipe-list-title">Recipe List</h2>
        <button class="add-new-recipe-btn edit-button"><a href="add_new_recipe.php">Add New</a></button>
        <?php if ($recipeCount > 0) { ?> <!-- Check if recipes exist -->
            <ul class="recipe-list">
                <?php while ($post = $recipesList->fetch(PDO::FETCH_ASSOC)) { ?>
                    <li class="recipe-item">
                        <span class="recipe-title"><?php echo $post['title'] ?></span>
                        <span class="recipe-description"><?php echo $post['instructions'] ?></span>
                        <div class="recipe-actions">
                            <button class="edit-button"><a href="edit_recipe.php?id=<?php echo $post['recipe_id']?>">Edit</a></button>
                            <form method="post" action="delete_recipe.php">
                                <input type="hidden" name="recipe_id" value="<?php echo $post['recipe_id']?>">
                                <input type="submit" class="delete-button" name="delete_recipe" value="Delete Recipe" onclick="return confirm('Delete this pizza recipe?');">
                            </form>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No recipes available</p> <!-- Display if no recipes -->
        <?php } ?>
    </div>
    </main>
</div>

<?php include('shared/footer.php');?>
