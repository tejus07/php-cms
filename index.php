<?php
try {

include_once 'shared/database.php';

$database = new Database();

$pdo = $database->getConnection();
$perPage = 5;
$isUserLoggedIn = isset($_SESSION['user_id']);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 5;
$offset = ($currentPage - 1) * $perPage;

$sortOrder = 'title__ASC';

$query = "SELECT * FROM pizzaRecipes LIMIT " . intval($perPage) . " OFFSET " . intval($offset);
	

	if ($isUserLoggedIn) {
		$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'title__ASC';

		$sort = explode('__', $sortOrder);

		$sortColumn = isset($sort[0]) ? $sort[0] : 'created_at';
		$sortDirection = isset($sort[1]) ? $sort[1] : 'ASC';

		if (!in_array($sortColumn, ['created_at', 'title']) || !in_array($sortDirection, ['ASC', 'DESC'])) {
    		throw new Exception("Invalid sorting parameters.");
    	}
		$query = "SELECT * 
		FROM pizzaRecipes
		ORDER BY $sortColumn " . ($sortDirection === 'ASC' ? 'ASC' : 'DESC');
	}
	$query .= " LIMIT " . intval($perPage) . " OFFSET " . intval($offset);
    $stmt = $pdo->prepare($query);

    $stmt->execute();

    $recipesList = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$totleQuery = "SELECT COUNT(*) AS total FROM pizzaRecipes";

	$totalstmt = $pdo->prepare($totleQuery);
	$totalstmt->execute();
	$result = $totalstmt->fetch(PDO::FETCH_ASSOC);
	$totalCount = $result['total'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
    <?php include('shared/header.php');?>

    <main class="container-fluid mt-4">
		<div class="header-container">
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
		<?php }?>
			<div class="recipe-count">
			<?php echo "Total Recipes: " . $totalCount; ?>
			</div>
		
			</div>
		<div class="row recipe-container">
        <?php
        foreach ($recipesList as $post) {
			$date = date_create($post['created_at']);					
			?>
			<div class="col-md-3"><div class="blogshort">
			<?php if (!empty($post['image_url'])) {?>
				<img src="<?php echo $post['image_url'] ?>" width="250">
			<?php } ?>
			<h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>	
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<br><br>
			<a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">View Recipe</a> 
			</div>
		</div>
		<?php } ?> 
		</div>  
		<?php 
		function generatePaginationLink($page, $sortOrder)
		{
			return "index.php?page=$page&sort=$sortOrder";
		}

        $totalPages = ceil($totalCount / $perPage);
        if ($totalPages > 1) {
			echo '<center><div class="pagination">';
			if ($currentPage > 1) {
				echo '<a href="' . generatePaginationLink($currentPage - 1, $sortOrder) . '" class="page-item prev-link">Prev</a>';
			}
			for ($i = 1; $i <= $totalPages; $i++) {
				echo '<a href="' . generatePaginationLink($i, $sortOrder) . '" class="page-item ' . (($currentPage == $i) ? 'active' : '') . '">' . $i . '</a>';
			}
			if ($currentPage < $totalPages) {
				echo '<a href="' . generatePaginationLink($currentPage + 1, $sortOrder) . '" class="page-item next-link">Next</a>';
			}
			echo '</div></center>';
		}
		?>
    </main>

    <?php include('shared/footer.php');?>

