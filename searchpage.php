<?php

include_once 'Shared/database.php';




$database = new Database();




$pdo = $database->getConnection();




function searchPages($keyword, $category = null, $limit = 10, $offset = 0) {

    global $pdo;




    $sql = "SELECT * FROM pizzaRecipes WHERE (title LIKE :keyword OR instructions LIKE :keyword)";

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




    $sql = "SELECT COUNT(*) AS total FROM pizzaRecipes WHERE (title LIKE :keyword OR instructions LIKE :keyword)";

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




<main class="container-fluid mt-4 searchpage-main">

    <h1>Search Results</h1>

    <small>Showing <strong>"<?php echo $totalCount; ?>"</strong> results.</small><br><br>

    <?php

    if (empty($searchResults)) {

        echo '<center><h1>No results were found</h1><h5>Try for the some other query.</h5></center>';

    } else {
        ?>
     <div class="recipe-container">
        <?php foreach ($searchResults as $post) {				

            $date = date_create($post['created_at']);

            ?>

            <div class="col-md-10 blogShort">
			<?php if (!empty($post['image_url'])) {?>
				<img src="<?php echo $post['image_url'] ?>" width="250">
			<?php } ?>
			<h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>	
			<em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			<br><br>
			<a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">View Recipe</a> 
			</div>

    <?php } ?>
        </div>  
      <?php  } 

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