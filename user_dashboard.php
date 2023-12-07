<?php include('shared/header.php'); ?>

<?php
    include_once 'shared/database.php';
    include_once 'admin/shared/recipeHandler.php';

    $conn = new Database();
    $recipeHandler = new RecipeHandler($conn);

    $user_id = $_SESSION['user_id'];

    $recipesList = $recipeHandler->getAllRecipes($user_id);
?>

    <div class="user-dashboard">

        <main class="main-container">

            <section class="content">
            <?php
        foreach ($recipesList as $user_post) {
			$date = date_create($user_post['created_at']);					
			?>
			<div class="col-md-10 blogShort">
			<?php if (!empty($user_post['image_url'])) {?>
				<img src="<?php echo $user_post['image_url'] ?>" width="250">
			<?php } ?>
			<h3><a href="view_post.php?id=<?php echo $user_post['recipe_id']; ?>"><?php echo $user_post['title']; ?></a></h3>	
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<br><br>
			<a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $user_post['recipe_id']; ?>">View Recipe</a> 
			</div>
		<?php } ?> 
            </section>
        </main>
    </div>

<?php include('shared/footer.php');?>