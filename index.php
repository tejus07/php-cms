<?php
try {
	include_once 'shared/database.php';

	$database = new Database();

	$pdo = $database->getConnection();

	$isUserLoggedIn = isset($_SESSION['user_id']);

	$query = 'SELECT * FROM recipes';

	if ($isUserLoggedIn) {
		$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'title__DESC';

		$sort = explode('__', $sortOrder);

		$sortColumn = isset($sort[0]) ? $sort[0] : 'created_at';
		$sortDirection = isset($sort[1]) ? $sort[1] : 'ASC';

		if (!in_array($sortColumn, ['created_at', 'title', "preparation_time"]) || !in_array($sortDirection, ['ASC', 'DESC'])) {
    		throw new Exception("Invalid sorting parameters.");
    	}
		$query = "SELECT * 
		FROM recipes
		ORDER BY $sortColumn " . ($sortDirection === 'ASC' ? 'ASC' : 'DESC');
	}

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    $recipesList = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
    <?php include('shared/header.php');?>

    <main>
		<?php
			if ($isUserLoggedIn) { 
		?>
		<form method="GET" >
			<label for="sort">Sort by:</label>
    		<select name="sort" id="sort">
        		<option value="title__ASC" <?php echo ($sortOrder === 'title__ASC') ? 'selected' : ''; ?>>Title: A to Z</option>
        		<option value="title__DESC" <?php echo ($sortOrder === 'title__DESC') ? 'selected' : ''; ?>>Title: Z to A</option>
        		<option value="created_at__ASC" <?php echo ($sortOrder === 'created_at__ASC') ? 'selected' : ''; ?>>Date: New to Old</option>
        		<option value="created_at__DESC" <?php echo ($sortOrder === 'created_at__DESC') ? 'selected' : ''; ?>>Date: Old to New</option>
        		<option value="preparation_time__ASC" <?php echo ($sortOrder === 'preparation_time__ASC') ? 'selected' : ''; ?>>Preparation Time: Quickest to Longest</option>
        		<option value="preparation_time__DESC" <?php echo ($sortOrder === 'preparation_time__DESC') ? 'selected' : ''; ?>>Preparation Time: Longest to Quickest</option>
    		</select>
    		<button type="submit">Sort</button>
		</form>
		<?php }?>
        <?php
        foreach ($recipesList as $post) {
			$date = date_create($post['created_at']);					
			$message = str_replace("\n\r", "<br><br>", $post['description']);
			?>
			<div class="col-md-10 blogShort">
			<img src="<?php echo $post['image_url'] ?>" width="250">
			<h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>		
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

