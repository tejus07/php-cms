<?php 

    include('shared/header.php'); 
    
    include_once '../shared/database.php';
    include_once '../admin/shared/recipeHandler.php';

    $conn = new Database();
    $recipeHandler = new RecipeHandler($conn);

    $user_id = $_SESSION['user_id'];

    $recipesList = [];

    $recipesList = $recipeHandler->getAllRecipes($user_id);

?>

    <div class="col-md-9 user-dashboard">
    <main class="container-fluid">
    <section class="row content">
    <?php
        foreach ($recipesList as $post) {
            $date = date_create($post['created_at']);
    ?>
        <div class="col-md-3"><div class="blogShort">
			<?php if (!empty($post['image_url'])) {?>
				<img src="<?php echo $post['image_url'] ?>" width="250">
			<?php } ?>
			<h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>	
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<br><br>
            <div class="recipe-actions">
                <button class="btn btn-primary edit-button"><a href="edit_post.php?id=<?php echo $post['recipe_id']?>">Edit</a></button>
                <form method="post" action="delete_post.php">
                    <input type="hidden" name="recipe_id" value="<?php echo $post['recipe_id']?>">
                    <input type="submit" class="btn btn-danger delete-button" name="delete_recipe" value="Delete Recipe" onclick="return confirm('Are you sure you want to delete this recipe?');">
                </form>
            </div>  </div>
        </div>
    <?php } ?>  
    </section>
</main>

    </div>

<?php include('../shared/footer.php');?>