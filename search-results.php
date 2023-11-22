<?php
$title = 'Search';
require_once 'includes/header.php';
require 'db.php';
require 'navbar.php';
try {
    $search = isset($_GET['search']) ? trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING)) : '';
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'name-ASC';
    $sort = explode('-', $sortOrder);
    $sortColumn = isset($sort[0]) ? $sort[0] : 'name';
    $sortDirection = isset($sort[1]) ? $sort[1] : 'ASC';
    $resultsPerPage = 1;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $resultsPerPage;

    $stmt = $pdo->prepare("SELECT phones.*, brands.name AS brand_name 
                        FROM phones 
                        INNER JOIN brands ON phones.brand_id = brands.id 
                        WHERE phones.name LIKE :search OR brands.name LIKE :search
                        ORDER BY $sortColumn " . ($sortDirection === 'ASC' ? 'ASC' : 'DESC') . "
                        LIMIT :offset, :limit");

    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalResults = count($phones);
    $totalPages = ceil($totalResults / $resultsPerPage);

    $brands = [];
    $brands_sql = "SELECT id, name FROM brands";
    $brands_stmt = $pdo->query($brands_sql);

    while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
        $brands[$row['id']] = $row['name'];
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<div class="container">
    <div class="row">
        <div class="col">
            <form method="GET">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort">
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
                <button type="submit">Sort</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form method="GET" action="search-results.php">
                <!-- <label for="phoneFilter">Filter by Phone:</label> -->
                <!-- <select name="phoneFilter" id="phoneFilter"> -->

                <!-- Add more options as needed -->
                <!-- </select> -->
                <!-- <br> -->
                <label for="brandFilter">Filter by Brand:</label>
                <select name="brandFilter" id="brandFilter">
                    <?php
                    foreach ($brands as $id => $brandName) {
                        echo "<option value='" . $id . "'>$brandName</option>";
                    }
                    ?>
                </select>
                <br>
                <button type="submit">Search</button>
            </form>

        </div>
        <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <?php
            foreach ($phones as $phone) {
                echo '<div class="card">';
                if ($phone['image_url']) {
                    echo '<img src="./uploads/' . $phone['image_url'] . '" class="bd-placeholder-img card-img-top" width="100%" height="180" alt="' . $phone['name'] . '">';
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
                echo '</div></div>';
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'includes/footer.php';
?>