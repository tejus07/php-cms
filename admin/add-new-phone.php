<?php
$title = 'Add New Phone';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once 'admin-navbar.php';

$users = [];
$user_sql = "SELECT id, username FROM Users";
$user_stmt = $pdo->query($user_sql);

while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
    $users[$row['id']] = $row['username'];
}

$brands = [];
$brands_sql = "SELECT id, name FROM brands";
$brands_stmt = $pdo->query($brands_sql);

while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
    $brands[$row['id']] = $row['name'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from the form
    $name = $_POST['name'];
    $description = $_POST['description-hidden'];
    $release_date = $_POST['release_date'];
    $image_url = $_POST['image_url'];
    $processor = $_POST['processor'];
    $RAM = $_POST['RAM'];
    $storage = $_POST['storage'];
    $camera = $_POST['camera'];
    $display = $_POST['display'];
    $battery = $_POST['battery'];
    $operating_system = $_POST['operating_system'];
    $brand_id = $_POST['brand_id'];
    $user_id = $_POST['user_id'];
    try {
        $sql = "INSERT INTO phone_specs (phone_id, processor, RAM, storage, camera, display, battery, operating_system) VALUES (:title, :description, :preparation_time, :cooking_time, :servings, :difficulty_level, :cuisine, :course, :instructions, :ingredients, :category_id, :user_id, NOW(), NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':preparation_time', $preparation_time);
        $stmt->bindParam(':cooking_time', $cooking_time);
        $stmt->bindParam(':servings', $servings);
        $stmt->bindParam(':difficulty_level', $difficulty_level);
        $stmt->bindParam(':cuisine', $cuisine);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':instructions', $instructions);
        $stmt->bindParam(':ingredients', $ingredients);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':user_id', $user_id);

        
        echo $sql;
        $stmt->execute();

        echo "Phone added successfully!";
    
        header("Location: phones.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<div class="container-fluid">
    <div class="row">
        <?php
        require 'admin-sidebar.php'
            ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <script>
                tinymce.init({
                    selector: 'textarea#description-hidden',
                    plugins: 'advlist autolink lists link image charmap print preview anchor',
                    toolbar_mode: 'floating',
                });


                function updateHiddenTextarea() {
                    var hiddenTextarea = document.getElementById('description-hidden');
                    var content = tinymce.get('description').getContent();
                    hiddenTextarea.value = content;
                }

                document.querySelector('form').addEventListener('submit', updateHiddenTextarea);
            </script>
            <div class="container">
                <h2 class="add-phone-title">Add Phone</h2>
                <form class="phone-form" action="add-new-phone.php" method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description-hidden" name="description-hidden"></textarea>

                    </div>
                    <div class="form-group">
                        <label for="release_date">Release Date:</label>
                        <input type="date" id="release_date" name="release_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="image_url">Image URL:</label>
                        <input type="text" id="image_url" name="image_url" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="processor">Processor:</label>
                        <input type="text" id="processor" name="processor" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="RAM">RAM:</label>
                        <input type="number" id="RAM" name="RAM" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="storage">Storage:</label>
                        <input type="number" id="storage" name="storage" class="form-input"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="camera">Camera:</label>
                        <input type="text" id="camera" name="camera" class="form-input"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="display">Display:</label>
                        <input type="text" id="display" name="display" class="form-input"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="battery">Battery:</label>
                        <input type="text" id="battery" name="battery" class="form-input"
                           required>
                    </div>
                    <div class="form-group">
                        <label for="operating_system">Operating System:</label>
                        <input type="text" id="operating_system" name="operating_system" class="form-input"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="brand_id">Select Brand</label>
                        <select id="brand_id" name="brand_id">
                            <?php foreach ($brands as $brandId => $brandName): ?>
                                <option value="<?php echo $brandId; ?>">
                                    <?php echo $brandName; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Select User:</label>
                        <select id="user_id" name="user_id">
                            <?php foreach ($users as $userId => $username): ?>
                                <option value="<?php echo $userId; ?>">
                                    <?php echo $username; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" value="Save" class="submit-button">
                </form>
            </div>
        </main>
    </div>
</div>