<?php
$phone_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

require './includes/initialize.php';
require_once 'includes/header.php';
require 'navbar.php';
try {

    $query = "SELECT phones.*, 
    phone_specs.processor, phone_specs.RAM, phone_specs.storage, phone_specs.camera, phone_specs.display, phone_specs.battery, phone_specs.operating_system,
    brands.name AS brand_name
    FROM phones
    INNER JOIN phone_specs ON phone_specs.phone_id = phones.id
    INNER JOIN brands ON brands.id = phones.brand_id 
    WHERE phones.id = :phoneId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':phoneId', $phone_id, PDO::PARAM_INT);
    $stmt->execute();

    $phone = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<div class="container">
    <div class="row">
        <div class="col">
            <?php
            echo '<div class="card">';
            echo '<svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img"
            aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">'.$phone['name'].'</text>
        </svg>';
            // echo '<img src="' . $phone['image_url'] . '" class="bd-placeholder-img card-img-top" width="100%" height="180" alt="' . $phone['name'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $phone['name'] . '</h5>';
            echo '<p class="card-text">' . $phone['description'] . '</p>';
            echo '<p>Release Date: ' . $phone['release_date'] . '</p>';
            echo '<p>Brand: ' . $phone['brand_name'] . '</p>';
            echo '<p>Processor: ' . $phone['processor'] . '</p>';
            echo '<p>RAM: ' . $phone['RAM'] . ' GB</p>';
            echo '<p>Storage: ' . $phone['storage'] . ' GB</p>';
            echo '<p>Camera: ' . $phone['camera'] . '</p>';
            echo '<p>Display: ' . $phone['display'] . '</p>';
            echo '<p>Battery: ' . $phone['battery'] . '</p>';
            echo '<p>Operating System: ' . $phone['operating_system'] . '</p>';
            echo '</div>';
            echo '</div>';
            ?>
        </div>
    </div>
</div>

