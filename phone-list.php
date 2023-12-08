<?php
require 'includes/initialize.php';

try {
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'name-ASC';
    $sort = explode('-', $sortOrder);
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sortColumn = isset($sort[0]) ? $sort[0] : 'name';
    $sortDirection = isset($sort[1]) ? $sort[1] : 'ASC';

    $stmt = $pdo->prepare("SELECT phones.*, brands.name AS brand_name 
                            FROM phones 
                            INNER JOIN brands ON phones.brand_id = brands.id 
                            ORDER BY $sortColumn " . ($sortDirection === 'ASC' ? 'ASC' : 'DESC'));

    $stmt->execute();

    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="row my-2">
        <div class="col">
            <form method="GET">
                <div class="form-row justify-content-end">
                    <div class="form-group col-md-4 d-flex">
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
                        <button class="btn btn-outline-primary" type="submit">Sort</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<div class="row row-cols-2">
    <?php
    foreach ($phones as $phone) {
        echo '<div class="col my-2"><div class="card">';
        if ($phone['image_url']) {
            echo '<div class="card-img-wrapper text-center">
            <img src="./' . $phone['image_url'] . '" class="mx-auto" alt="' . $phone['name'] . '">
            </div>';
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
        echo '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s
    content.</p>';
        echo '<p>Release Date: ' . $phone['release_date'] . '</p>';
        echo '<p>Brand: ' . $phone['brand_name'] . '</p>';
        echo '<a href="view-phone.php?id=' . $phone['id'] . '" class="btn btn-primary">View</a>';
        echo '</div>';
        echo '</div></div></div>';
    }
    ?>
</div>