<?php
include_once '../shared/database.php';

if(empty($_SESSION['user_id']) || empty($_SESSION['user_role'])) {
    header('Location: login.php');
}

$database = new Database();

$pdo = $database->getConnection();

$results = $pdo->query('SELECT * FROM recipes');

?>

<?php include('shared/sidebar.php');?>

<div class="content">
    <header>
        <h2>Recipes Page</h2>
        <a href="logout.php">Logout</a>
    </header>
    <main>
    <div class="recipe-list-container">
        <h2 class="recipe-list-title">Recipe List</h2>
        <button class="add-new-recipe-btn edit-button"><a href="add_new_recipe.php">Add New</a></button>
        <ul class="recipe-list">
            <?php
            while ($post = $results->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <li class="recipe-item">
                <?php if (!empty($post['image_url'])) { ?>
                    <img src="../<?php echo $post['image_url'] ?>" width="150">
                <?php } ?>
                <span class="recipe-title"><?php echo $post['title'] ?></span>
                <span class="recipe-description"><?php echo $post['description'] ?></span>
                <div class="recipe-actions">
                    <button class="edit-button"><a href="edit_recipe.php?id=<?php echo $post['recipe_id']?>">Edit</a></button>
                    <form method="post" action="delete_recipe.php">
                        <input type="hidden" name="recipe_id" value="<?php echo $post['recipe_id']?>">
                        <input type="submit" class="delete-button" name="delete_recipe" value="Delete Recipe" onclick="return confirm('Are you sure you want to delete this recipe?');">
                    </form>
                    <!-- <button class="delete-button"><a href="delete_recipe.php?id=">Delete</a></button> -->
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
    </main>
</div>

        
<?php include('shared/footer.php');?>