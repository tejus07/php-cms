<?php
include_once './shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

function searchPages($keyword, $category = null, $limit = 10, $offset = 0) {
    global $pdo;

    $sql = "SELECT * FROM recipes WHERE (title LIKE :keyword OR description LIKE :keyword)";
    $params = array(':keyword' => '%' . $keyword . '%');

    if ($category !== null && $category != 'all') {
        $sql .= " AND category_id = :category";
        $params[':category'] = $category;
    }

    $sql .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array();
    }
}

function getTotalCount($keyword, $category = null) {
    global $pdo;

    $sql = "SELECT COUNT(*) AS total FROM recipes WHERE (title LIKE :keyword OR description LIKE :keyword)";
    $params = array(':keyword' => '%' . $keyword . '%');

    if ($category !== null && $category != 'all') {
        $sql .= " AND category_id = :category";
        $params[':category'] = $category;
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}


$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$totalCount = getTotalCount($keyword, $category);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 5;
$offset = ($currentPage - 1) * $perPage;

$searchResults = searchPages($keyword, $category, $perPage, $offset);

?>

<?php include('shared/header.php');?>

<main class="container-fluid mt-4">
    <h1>Search Results</h1>
    <small>Showing <strong>"<?php echo $totalCount; ?>"</strong> results.</small><br><br>
    
    <div class="row">
    <?php
    if (empty($searchResults)) {
        echo '<center><h1>Sorry no results were found for the query</h1></center>';
    } else {
        foreach ($searchResults as $post) {
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
    
       <?php } 
        $totalPages = ceil($totalCount / $perPage);
        if ($totalPages > 1) {
            echo '<center><div class="pagination">';
            if ($currentPage > 1) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . ($currentPage - 1) . '" class="page-item prev-link">Prev</a>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . $i . '" class="page-item '. (($currentPage == $i) ? 'active' : '') .'">' . $i . '</a>';
            }
            
            if ($currentPage < $totalPages) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . ($currentPage + 1) . '" class="page-item next-link">Next</a>';
            }
            echo '</div></center>';
        }?>
</main>

<?php include('shared/footer.php');?>