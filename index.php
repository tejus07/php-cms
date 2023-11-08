<?php
require 'db.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM brands");
    $stmt->execute();

    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

    if (count($brands) > 0) {
        echo "<h2>Brands as:</h2>";
        echo "<ul>"; 
        foreach ($brands as $brand) {
            echo "<li>ID: " . $brand['id'] . ", Name: " . $brand['name'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No records found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}