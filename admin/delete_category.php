<?php

include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];

        try {
            $sql = "DELETE FROM categories WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();

            echo "Category deleted successfully!";
            header("Location: categories.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
}

?>