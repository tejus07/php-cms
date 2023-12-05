<?php require 'header.php';

function searchPages($keyword, $category = null, $limit = 10, $offset = 0)
{
    global $conn;

    $sql = "SELECT * FROM vehicles WHERE (model LIKE :keyword OR description LIKE :keyword)";
    $params = array(':keyword' => '%' . $keyword . '%');

    if ($category !== null && $category != 'all') {
        $sql .= " AND category_id = :category";
        $params[':category'] = $category;
    }

    $sql .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array();
    }
}

function getTotalCount($keyword, $category = null)
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total FROM vehicles WHERE (model LIKE :keyword OR description LIKE :keyword)";
    $params = array(':keyword' => '%' . $keyword . '%');

    if ($category !== null && $category != 'all') {
        $sql .= " AND category_id = :category";
        $params[':category'] = $category;
    }

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch (PDOException $e) {
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

<main>
    <section class="vehicle-list">
        <h1>Search Results</h1>
        <small>Showing <strong>"
                <?php echo $totalCount; ?>"
            </strong> results.</small><br><br>
        <?php
        if (empty($searchResults)) {
            echo '<center><h1>Sorry no results were found for the query</h1></center>';
        } else {
            echo '<div class="vehicles-container">';
            foreach ($searchResults as $post) {
                $date = date_create($post['created_at']);
                $message = str_replace("\n\r", "<br><br>", $post['description']);
                ?>
                <div class="vehicle">
                    <h3>
                        <?php echo $post['model']; ?>
                    </h3>
                    <p>Description:
                        <?php echo $post['description']; ?>
                    </p>
                    <p>Rental Rate: $
                        <?php echo $post["rental_rate"]; ?> per day
                    </p>
                    <p>Availability:
                        <?php echo $post["availability_status"]; ?>
                    </p>
                    <?php
                    if (!empty($post["image_url"])) {
                        echo "<img src='" . $post["image_url"] . "' alt='Vehicle Image'>";
                    }
                    echo "<a href='view-vehicle.php?vehicle_id=" . $post["vehicle_id"] . "' class='view-button'>View Details</a>"; ?>
                </div>
            <?php }
            echo '</div>';
        }
        ?>

        <?php
        $totalPages = ceil($totalCount / $perPage);
        if ($totalPages > 1) {
            echo '<center><div class="pagination">';
            if ($currentPage > 1) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . ($currentPage - 1) . '" class="page-item prev-link">Prev</a>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . $i . '" class="page-item ' . (($currentPage == $i) ? 'active' : '') . '">' . $i . '</a>';
            }

            if ($currentPage < $totalPages) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . ($currentPage + 1) . '" class="page-item next-link">Next</a>';
            }
            echo '</div></center>';
        } ?>
    </section>
</main>
<?php require 'footer.php' ?>