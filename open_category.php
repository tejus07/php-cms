
<?php
try {
	include_once 'shared/database.php';

	$database = new Database();

	$pdo = $database->getConnection();

	$isUserLoggedIn = isset($_SESSION['user_id']);

    $category_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

	$query = 'SELECT * FROM pizzarecipes where category_id = :category_id';

	if ($isUserLoggedIn) {
		$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'title__ASC';

		$sort = explode('__', $sortOrder);

		$sortColumn = isset($sort[0]) ? $sort[0] : 'created_at';
		$sortDirection = isset($sort[1]) ? $sort[1] : 'ASC';

		if (!in_array($sortColumn, ['created_at', 'title', "preparation_time"]) || !in_array($sortDirection, ['ASC', 'DESC'])) {
    		throw new Exception("Invalid sorting parameters.");
    	}
		$query = $query . " ORDER BY $sortColumn " . ($sortDirection === 'ASC' ? 'ASC' : 'DESC');
	}

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

    $stmt->execute();

    $recipesList = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
    <?php include('shared/header.php');?>

    <main>
       <div class="recipe-container">
        <?php
        foreach ($recipesList as $post) {
			$date = date_create($post['created_at']);					
			$instructions = str_replace("\n\r", "<br><br>", $post['instructions']);
			?>
			<div class="col-md-10 blogShort">
			<img src="<?php echo $post['image_url'] ?>" width="250">
			<h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>	
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<br><br>
			<a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">View Recipe</a> 
			</div>
		<?php } ?> 
		</div>  
    </main>

    <?php include('shared/footer.php');?>