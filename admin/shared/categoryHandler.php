<?php 
include_once '../shared/database.php';

class CategoryHandler {
    private $database;
    public $title;

    public function __construct() {
        $this->database = new Database();
    }

    public function addCategory() {
        $pdo = $this->database->getConnection();
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $sql = "INSERT INTO categories (title) VALUES (:title)";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title', $this->title);
        
                $stmt->execute();
        
                echo "Category added successfully!";
                header("Location: categories.php");
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function getCategories() {
        $pdo = $this->database->getConnection();
        $categories = [];
        $category_sql = "SELECT category_id, title FROM categories";
        $category_stmt = $pdo->query($category_sql);

        while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[$row['category_id']] = $row['title'];
        }

        return $categories;
    }

    public function updateCategory($category_id, $title) {
        $pdo = $this->database->getConnection();

        try {
            $sql = "UPDATE categories SET 
                title = :title
                WHERE category_id = :category_id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false; 
        }
    }
    public function getCategoryById($category_id) {
        $pdo = $this->database->getConnection();

        try {
            $query = "SELECT * FROM categories WHERE category_id = :category_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->execute();

            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            return $category; // Return category data or false if not found
        } catch (PDOException $e) {
            // Handle the exception if needed
            return false;
        }
    }
    public function deleteCategory($category_id) {
        $pdo = $this->database->getConnection();
    
        try {
            $sql = "DELETE FROM categories WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    

}

?>