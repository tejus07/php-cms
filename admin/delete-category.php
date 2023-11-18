<?php
$host = 'localhost';
$dbname = "rentandgodb";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];

        try {
            $sql = "DELETE FROM Categories WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();

            echo "Category deleted successfully!";
            header("Location: manage-categories.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
} 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
