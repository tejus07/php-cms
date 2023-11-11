<?php
require './includes/initialize.php';
try {
    $stmt = $pdo->prepare("SELECT phones.*, brands.name AS brand_name, brands.logo_url FROM phones INNER JOIN brands ON phones.brand_id = brands.id");
    $stmt->execute();

    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<?php
foreach ($phones as $phone) {
    echo '<div class="card">';
    echo '<svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img"
    aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false">
    <title>Placeholder</title>
    <rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">'.$phone['name'].'</text>
</svg>';
    echo '<div class="card-body">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">'.$phone['name'].'</h5>';
    echo '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s
    content.</p>';
    echo '<p>Release Date: ' . $phone['release_date'] . '</p>';
    echo '<p>Brand: ' . $phone['brand_name'] . '</p>';
    echo '<a href="view-phone.php?id='.$phone['id'].'" class="btn btn-primary">View</a>';
    echo '</div>';
    echo '</div></div>';
  }
?>