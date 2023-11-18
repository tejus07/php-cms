<?php
$host = 'localhost';
$dbname = "rentandgodb";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_brand'])) {
    $brand_id = $_POST['brand_id'];

        try {
            $sql = "DELETE FROM Brands WHERE brand_id = :brand_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':brand_id', $brand_id);
            $stmt->execute();

            echo "Brand deleted successfully!";
            header("Location: manage-brands.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
} 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
