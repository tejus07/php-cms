<?php
require './includes/initialize.php';
try {
    $stmt = $pdo->prepare("SELECT phones.*, brands.name AS brand_name, brands.logo_url FROM phones INNER JOIN brands ON phones.brand_id = brands.id");
    $stmt->execute();

    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

echo var_dump($phones);
?>