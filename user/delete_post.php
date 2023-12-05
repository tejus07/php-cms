<?php

include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_recipe'])) {
    $recipe_id = $_POST['recipe_id'];

        try {
            $sql = "DELETE FROM Recipes WHERE recipe_id = :recipe_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':recipe_id', $recipe_id);
            $stmt->execute();

            echo "Recipe deleted successfully!";
            header("Location: my_post.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
}

?>
