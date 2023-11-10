<?php
include_once 'shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$recipesList = $pdo->query('SELECT * FROM recipes');

?>
    <?php include('shared/header.php');?>

    <main>
        <?php
        while ($post = $recipesList->fetch(PDO::FETCH_ASSOC)) {
			$date = date_create($post['created_at']);					
			$message = str_replace("\n\r", "<br><br>", $post['description']);
			?>
			<div class="col-md-10 blogShort">
			<h3><a href="view.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>		
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<em><strong>Category:</strong> <a href="#" target="_blank"><?php echo $post['difficulty_level']; ?></a></em>
			<br><br>
			<article>
			<p><?php echo $message; ?> 	</p>
			</article>
			<a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">READ MORE</a> 
			</div>
		<?php } ?>   
    </main>

    <?php include('shared/footer.php');?>

