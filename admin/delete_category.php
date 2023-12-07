<?php

include_once 'shared/categoryHandler.php';

$categoryHandler = new CategoryHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];

    $deleteResult = $categoryHandler->deleteCategory($category_id); 

    if ($deleteResult) {
        echo "Category deleted successfully!";
        header("Location: categories.php");
        exit();
    } else {
        echo "Error deleting category.";
    }
}

?>
