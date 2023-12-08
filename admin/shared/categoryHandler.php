<?php 

class CategoryHandler {
    private $database;
    public $category_name;

    public function __construct($conn) {
        $this->database = $conn;
    }

    public function addCategory() {
        $pdo = $this->database->getConnection();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':category_name', $this->category_name);
                
                echo $sql;
                $stmt->execute();
        
                echo "Category added successfully!";
                
                header("Location: categories.php");
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function getCategories() {
        $pdo = $this->database->getConnection();
        $categories = [];
        $category_sql = "SELECT category_id, category_name FROM categories";
        $category_stmt = $pdo->query($category_sql);

        while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[$row['category_id']] = $row['category_name'];
        }

        return $categories;
    }

    public function getSingleCategories($category_id) {
        $pdo = $this->database->getConnection();
        
        $query = "SELECT * FROM categories WHERE category_id = :categoryID";
        $stmt1 = $pdo->prepare($query);
        
        $stmt1->bindParam(':categoryID', $category_id, PDO::PARAM_INT);
        
        $stmt1->execute();
        
        $user = $stmt1->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

}

?>