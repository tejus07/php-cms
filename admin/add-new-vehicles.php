<?php
include_once 'common/isUserLoggedIn.php';
include_once 'common/manage_image.php';

$host = 'localhost';
$dbname = "rentandgodb";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $users = [];
    $user_sql = "SELECT user_id, username FROM Users";
    $user_stmt = $pdo->query($user_sql);

    while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[$row['user_id']] = $row['username'];
    }

    $brands = [];
    $brands_sql = "SELECT brand_id, brand_name FROM Brands";
    $brands_stmt = $pdo->query($brands_sql);

    while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
        $brands[$row['brand_id']] = $row['brand_name'];
    }

    $categories = [];
    $category_sql = "SELECT category_id, category_name FROM Categories";
    $category_stmt = $pdo->query($category_sql);

    while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
        $categories[$row['category_id']] = $row['category_name'];
    }
    
    $vehicles_sql = "SELECT COUNT(*) AS total_entries FROM vehicles;";
    $vehicles_stmt = $pdo->query($vehicles_sql);
    $result = $vehicles_stmt->fetch(PDO::FETCH_ASSOC);

    $totalEntries = $result['total_entries'];
    $total = $totalEntries + 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $image_url = null;

    if (isset($_FILES['file_upload'])) {

        $image_obj = new Manage_image();

        $image_url = $image_obj->get_image_url($_FILES['file_upload']);
    }
    $stmt = $pdo->prepare("INSERT INTO Vehicles (vehicle_id, owner_id, brand_id, category_id, model, description, rental_rate, availability_status, created_at, image_url) VALUES (:vehicle_id, :owner_id, :brand_id, :category_id, :model, :description, :rental_rate, :availability_status, NOW(), :image_url)");

    $stmt->bindParam(':vehicle_id', $total);
    $stmt->bindParam(':owner_id', $_POST['user_id']);
    $stmt->bindParam(':category_id', $_POST['category_id']);
    $stmt->bindParam(':brand_id', $_POST['brand_id']);
    $stmt->bindParam(':model', $_POST['model']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':rental_rate', $_POST['rental_rate']);
    $stmt->bindParam(':availability_status', $_POST['availability_status']);
    $stmt->bindParam(':image_url', $image_url);

    $stmt->execute();

    echo "New vehicle added successfully!";
    header("Location: manage-vehicles.php");
} 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Vehicle</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
</head>
<body>
    <header>
        <h1>Add New Vehicle</h1>
    </header>
    <main class="admin-container">
    <script>
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'advlist autolink lists link image charmap print preview anchor',
            toolbar_mode: 'floating',
            setup: function (editor) {
                editor.on('change', function () {
                    if (editor.getContent().trim().length === 0) {
                        console.log('The content is empty!');
                    }
                });
            }
        });
    </script>
	<?php include('common/navbar.php');?>
        <section class="admin-content">
            <form class="add-new-form" action="add-new-vehicles.php" method="post" enctype="multipart/form-data">
                
                <label for="file_upload">Upload Image:</label>
                <input type="file" id="file_upload" name="file_upload">
                
                <label for="owner_id">Select User:</label>
                <select id="user_id" name="user_id">
                    <?php foreach ($users as $userId => $username) : ?>
                        <option value="<?php echo $userId; ?>"><?php echo $username; ?></option>
                    <?php endforeach; ?>
                </select>
                <br><br>
                
                <label for="category_id">Select Category:</label>
                <select id="category_id" name="category_id">
                    <?php foreach ($categories as $category_id => $category_name) : ?>
                        <option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <br><br>

                <label for="brand_id">Select Brand:</label>
                <select id="brand_id" name="brand_id">
                    <?php foreach ($brands as $brand_id => $brand_name) : ?>
                        <option value="<?php echo $brand_id; ?>"><?php echo $brand_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <br><br>

                <label for="model">Model:</label>
                <input type="text" id="model" name="model" required><br><br>

                <label for="description">Description:</label><br>
                <textarea id="description" name="description"></textarea><br><br>

                <label for="rental_rate">Rental Rate:</label>
                <input type="text" id="rental_rate" name="rental_rate" required><br><br>

                <label for="availability_status">Availability Status:</label>
                <select id="availability_status" name="availability_status" class="form-input" required>
                    <option value="Available">Available</option>
                    <option value="Not available">Not available</option>
                </select>

                <input type="submit" value="Submit">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
