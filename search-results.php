<?php
$title = 'Search';
require_once './includes/header.php';
require './includes/db.php';
require './functions/function.php';
require './navbar.php';
try {
    $search = isset($_GET['search']) ? trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING)) : '';

    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'name-ASC';
    $sort = explode('-', $sortOrder);
    $sortColumn = isset($sort[0]) ? $sort[0] : 'name';
    $sortDirection = isset($sort[1]) ? $sort[1] : 'ASC';

    $brandFilter = isset($_GET['brandFilter']) ? $_GET['brandFilter'] : '';

    $resultsPerPage = 2;

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $resultsPerPage;

    $stmt = $pdo->prepare("SELECT phones.*, brands.name AS brand_name 
                        FROM phones 
                        INNER JOIN brands ON phones.brand_id = brands.id 
                        WHERE (phones.name LIKE :search OR brands.name LIKE :search)
                        " . ($brandFilter ? 'AND (brands.id = :brandFilter)' : '') .
        "ORDER BY $sortColumn " . ($sortDirection === 'ASC' ? 'ASC' : 'DESC') . "
                        LIMIT :offset, :limit");

    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
    if ($brandFilter):
        $stmt->bindValue(':brandFilter', $brandFilter, PDO::PARAM_INT);
    endif;
    $stmt->execute();

    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countQuery = "SELECT COUNT(*) AS total FROM phones 
    INNER JOIN brands ON phones.brand_id = brands.id 
    WHERE (phones.name LIKE :search OR brands.name LIKE :search)
    " . ($brandFilter ? 'AND (brands.id = :brandFilter)' : '');

    $stmtCount = $pdo->prepare($countQuery);
    $stmtCount->bindValue(':search', '%' . $search . '%');
    if ($brandFilter) {
        $stmtCount->bindValue(':brandFilter', $brandFilter, PDO::PARAM_INT);
    }
    $stmtCount->execute();

    $totalResults = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalResults / $resultsPerPage);

    $brands = [];
    $brands_sql = "SELECT id, name FROM brands";
    $brands_stmt = $pdo->query($brands_sql);

    while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
        $brands[$row['id']] = $row['name'];
    }

    $paginationLink = 'search-results.php?search=' . urlencode($search) . '&sort=' . $sortOrder;
    $filterLink = $paginationLink . '&brandFilter=' . $brandFilter;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<div class="search-container">
    <div class="row my-2">
        <div class="col">
            <form method="GET" action="search-results.php">
                <div class="form-row justify-content-end">
                <div class="form-group col-md-4 d-flex">
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <input type="hidden" name="brandFilter" value="<?php echo $brandFilter; ?>">
                    <input type="hidden" name="page" value="<?php echo $page; ?>">
                    <select class="form-control mr-2" name="sort" id="sort">
                        <?php
                        $selectedSort = isset($_GET['sort']) ? $_GET['sort'] : '';

                        $options = [
                            'name-ASC' => 'Name (Ascending)',
                            'name-DESC' => 'Name (Descending)',
                            'created_at-ASC' => 'Created At (Ascending)',
                            'created_at-DESC' => 'Created At (Descending)',
                            'release_date-ASC' => 'Released At (Ascending)',
                            'release_date-DESC' => 'Released At (Descending)'
                        ];

                        foreach ($options as $value => $label) {
                            $selected = ($value === $selectedSort) ? 'selected' : '';
                            echo "<option value=\"$value\" $selected>$label</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-outline-primary">Sort</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <form method="GET"
                action="<?php echo generateLink('search-results.php', $search, $sortOrder, $brandFilter, $page) ?>">
                <input type="hidden" name="search" value="<?php echo htmlentities($search); ?>">
                <label for="brandFilter">Filter by Brand:</label>
                <select name="brandFilter" class="form-control mr-2" id="brandFilter">
                    <?php
                    echo "<option value='' " . ($brandFilter === '' ? 'selected' : '') . ">All</option>"; // All option
                    foreach ($brands as $id => $brandName) {
                        $selected = ($id == $brandFilter) ? 'selected' : ''; // Highlight selected option
                        echo "<option value='" . $id . "' $selected>$brandName</option>";
                    }
                    ?>
                </select>
                <br>
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </form>
        </div>

        <div class="col-10">
            <div class="row row-cols-2">
                <?php
                foreach ($phones as $phone) {
                    echo '<div class="col"><div class="card">';
                    if ($phone['image_url']) {
                        echo '<img src="./' . $phone['image_url'] . '" class="bd-placeholder-img card-img-top" width="100%" height="180" alt="' . $phone['name'] . '">';
                    } else {
                        echo '<svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img"
    aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false">
    <title>Placeholder</title>
    <rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">' . $phone['name'] . '</text>
</svg>';
                    }
                    echo '<div class="card-body">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $phone['name'] . '</h5>';
                    echo '<p class="card-text">' . $phone['description'] . '</p>';
                    echo '<p>Release Date: ' . $phone['release_date'] . '</p>';
                    echo '<p>Brand: ' . $phone['brand_name'] . '</p>';
                    echo '<a href="view-phone.php?id=' . $phone['id'] . '" class="btn btn-primary">View</a>';
                    echo '</div>';
                    echo '</div></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    if ($totalResults > $resultsPerPage) {
        echo '<nav>';
        echo '<ul class="pagination justify-content-center mt-2">';

        // Previous page link
        if ($page > 1) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="' . $paginationLink . '&page=' . ($page - 1) . '">Previous</a>';
            echo '</li>';
        }

        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<li class="page-item ' . (($page == $i) ? "active" : "") . '">';
            echo '<a class="page-link" href="' . $paginationLink . '&page=' . $i . '">' . $i . '</a>';
            echo '</li>';
        }

        // Next page link
        if ($page < $totalPages) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="' . $paginationLink . '&page=' . ($page + 1) . '">Next</a>';
            echo '</li>';
        }

        echo '</ul>';
        echo '</nav>';
    }
    ?>
</div>
<?php
require_once 'includes/footer.php';
?>