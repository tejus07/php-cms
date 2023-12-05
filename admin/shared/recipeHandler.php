<?php 

class RecipeHandler {
    private $database;
    public $title;
    public $description;
    public $image_url;
    public $preparation_time;
    public $cooking_time;
    public $servings;
    public $difficulty_level;
    public $cuisine;
    public $course;
    public $instructions;
    public $ingredients;
    public $category_id;
    public $user_id;
    public $created_at;
    public $updated_at;



    public function __construct($conn) {
        $this->database = $conn;
    }

    public function addRecipe() {
        $pdo = $this->database->getConnection();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $sql = "INSERT INTO Recipes (title, description, image_url, preparation_time, cooking_time, servings, difficulty_level, cuisine, course, instructions, ingredients, category_id, user_id, created_at, updated_at) VALUES (:title, :description, :image_url, :preparation_time, :cooking_time, :servings, :difficulty_level, :cuisine, :course, :instructions, :ingredients, :category_id, :user_id, NOW(), NOW())";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':description', $this->description);
                $stmt->bindParam(':image_url', $this->image_url);
                $stmt->bindParam(':preparation_time', $this->preparation_time);
                $stmt->bindParam(':cooking_time', $this->cooking_time);
                $stmt->bindParam(':servings', $this->servings);
                $stmt->bindParam(':difficulty_level', $this->difficulty_level);
                $stmt->bindParam(':cuisine', $this->cuisine);
                $stmt->bindParam(':course', $this->course);
                $stmt->bindParam(':instructions', $this->instructions);
                $stmt->bindParam(':ingredients', $this->ingredients);
                $stmt->bindParam(':category_id', $this->category_id);
                $stmt->bindParam(':user_id', $this->user_id);

                $stmt->execute();

                echo "Recipe added successfully!";
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function editRecipe($recipe_id) {
        $pdo = $this->database->getConnection();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $sql = "UPDATE Recipes SET 
                title = :title,
                description = :description,
                preparation_time = :preparation_time,
                cooking_time = :cooking_time,
                servings = :servings,
                difficulty_level = :difficulty_level,
                cuisine = :cuisine,
                course = :course,
                instructions = :instructions,
                ingredients = :ingredients,
                category_id = :category_id,
                user_id = :user_id,
                image_url = :image_url,
                updated_at = NOW()
                WHERE recipe_id = :recipe_id";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':description', $this->description);
                $stmt->bindParam(':image_url', $this->image_url);
                $stmt->bindParam(':preparation_time', $this->preparation_time);
                $stmt->bindParam(':cooking_time', $this->cooking_time);
                $stmt->bindParam(':servings', $this->servings);
                $stmt->bindParam(':difficulty_level', $this->difficulty_level);
                $stmt->bindParam(':cuisine', $this->cuisine);
                $stmt->bindParam(':course', $this->course);
                $stmt->bindParam(':instructions', $this->instructions);
                $stmt->bindParam(':ingredients', $this->ingredients);
                $stmt->bindParam(':category_id', $this->category_id);
                $stmt->bindParam(':user_id', $this->user_id);
                $stmt->bindParam(':recipe_id', $recipe_id);

                $stmt->execute();

                echo "Recipe updated successfully!";
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function getAllRecipes($user_id) {
        $pdo = $this->database->getConnection();

        $query = "SELECT * FROM Recipes WHERE user_id = :userId";

        $stmt1 = $pdo->prepare($query);
        
        $stmt1->bindParam(':userId', $user_id, PDO::PARAM_INT);
        
        $stmt1->execute();
        
        $recipe = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        return $recipe;
    }

    public function getSingleRecipe($recipe_id) {
        $pdo = $this->database->getConnection();

        $query = "SELECT * FROM Recipes WHERE recipe_id = :recipeId";

        $stmt1 = $pdo->prepare($query);
        
        $stmt1->bindParam(':recipeId', $recipe_id, PDO::PARAM_INT);
        
        $stmt1->execute();
        
        $recipe = $stmt1->fetch(PDO::FETCH_ASSOC);

        return $recipe;
    }

}

?>