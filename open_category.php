
<?php
try {
	include_once 'Shared/database.php';
	include_once 'admin/shared/categoryHandler.php';

	$database = new Database();
	$categoryHandler = new CategoryHandler($database);
	$pdo = $database->getConnection();

	$isUserLoggedIn = isset($_SESSION['user_id']);

    $category_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
	$category = $categoryHandler->getSingleCategories($category_id);
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

    <main class="container-fluid mt-4">
	<?php
			if ($isUserLoggedIn) { 
		?>
		<form class="form-inline mb-4" method="GET" >
			<label class="mr-2" for="sort">Sort by:</label>
    		<select class="form-control mr-2" name="sort" id="sort">
        		<option value="title__ASC" <?php echo ($sortOrder === 'title__ASC') ? 'selected' : ''; ?>>Title: A to Z</option>
        		<option value="title__DESC" <?php echo ($sortOrder === 'title__DESC') ? 'selected' : ''; ?>>Title: Z to A</option>
        		<option value="created_at__DESC" <?php echo ($sortOrder === 'created_at__DESC') ? 'selected' : ''; ?>>Date: New to Old</option>
        		<option value="created_at__ASC" <?php echo ($sortOrder === 'created_at__ASC') ? 'selected' : ''; ?>>Date: Old to New</option>
    		</select>
    		<button class="btn btn-primary" type="submit">Sort</button>
		</form>
		<script>
    		let currentURL = new URL(window.location.href);
    		let idParam = currentURL.searchParams.get('id');

    		document.getElementById('sortForm').addEventListener('submit', function(event) {
				event.preventDefault();
        		let sortValue = document.getElementById('sort').value;

        		location.replace(`open_category.php?id=${idParam}}&sort=${sortValue}`);
    		});
		</script>
		<?php }?>

		<h2><?php echo $category['title']; ?></h2>
		<div class="row">
		
       <div class="recipe-container">
        <?php
        foreach ($recipesList as $post) {
			$date = date_create($post['created_at']);					
			$instructions = str_replace("\n\r", "<br><br>", $post['instructions']);
			?>
			<div class="col-md-3"><div class="blogShort">
			<img src="<?php echo $post['image_url'] ?>" width="200">
			<h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>	
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<br><br>
			<a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">View Recipe</a> 
			</div></div>
		<?php } ?> 
		</div>  
    </main>

    <?php include('shared/footer.php');?>