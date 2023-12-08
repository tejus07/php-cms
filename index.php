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

	$query = "SELECT * FROM recipes";

	if ($isUserLoggedIn) {
		$query .= " ORDER BY $sortColumn " . ($sortDirection === 'ASC' ? 'ASC' : 'DESC');
	}

	$query .= " LIMIT " . intval($perPage) . " OFFSET " . intval($offset);

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    $recipesList = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$totleQuery = "SELECT COUNT(*) AS total FROM recipes";
	
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
        		<option value="preparation_time__ASC" <?php echo ($sortOrder === 'preparation_time__ASC') ? 'selected' : ''; ?>>Preparation Time: Quickest to Longest</option>
        		<option value="preparation_time__DESC" <?php echo ($sortOrder === 'preparation_time__DESC') ? 'selected' : ''; ?>>Preparation Time: Longest to Quickest</option>
    		</select>
    		<button class="btn btn-primary" type="submit">Sort</button>
		</form>
		<?php }?>

		<div class="row">
        <?php
        foreach ($recipesList as $post) {
			$date = date_create($post['created_at']);					
			$message = str_replace("\n\r", "<br><br>", $post['description']);
			?>
			<div class="col-md-4 mb-4">
				<div class="card">
					<?php if (!empty($post['image_url'])) {?>
						<img class="card-img-top" src="<?php echo $post['image_url'] ?>" width="250">
        			<?php } ?>
					<div class="card-body">
						<h5 class="card-title"><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h5>
                        <p class="card-text"><?php echo $message; ?></p>
                        <a href="view_post.php?id=<?php echo $post['recipe_id']; ?>" class="btn btn-primary">Read More</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            <strong>Difficulty Level</strong>: <a href="#" target="_blank"><?php echo $post['difficulty_level']; ?></a><br>
                            <strong>Published on</strong>: <?php echo date_format($date, "d F Y"); ?>
                        </small>
                    </div>
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

