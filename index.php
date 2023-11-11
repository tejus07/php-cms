<?php
include_once 'shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$recipesList = $pdo->query('SELECT * FROM pizzarecipes');

?>
    <?php include('shared/header.php');?>

    <main>
        <?php
        while ($post = $recipesList->fetch(PDO::FETCH_ASSOC)) {
			$date = date_create($post['created_at']);					
			$instructions = str_replace("\n\r", "<br><br>", $post['instructions']);
			?>
			<div class="col-md-10 blogShort">
			<h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>		
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<br><br>
			<article>
			<p><?php echo $instructions; ?> 	</p>
			</article>
			<a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">READ MORE</a> 
			</div>
		<?php } ?>   
    </main>

    <?php include('shared/footer.php');?>

