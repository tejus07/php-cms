<?php
include_once 'Shared/database.php';

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

<main>
    <h1>Search Results</h1>
    <small>Showing <strong>"<?php echo $totalCount; ?>"</strong> results.</small><br><br>
    <?php
    if (empty($searchResults)) {
        echo '<center><h1>Sorry no results were found for the query</h1></center>';
    } else {
        foreach ($searchResults as $post) {
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
    <?php } 
        } 
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