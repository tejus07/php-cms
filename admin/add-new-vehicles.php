<?php
include_once 'common/isUserLoggedIn.php';
include_once 'common/manage_image.php';
include_once 'common/database.php';
include_once 'class/vehicle.php';
include_once 'class/brand.php';
include_once 'class/category.php';
include_once 'class/user.php';

try {

    $conn = new Database();

    $pdo = $conn->setupConnection();
    
    $vehicle_obj = new Vehicle($pdo);
    $brand_obj = new Brand($pdo);
    $category_obj = new Category($pdo);
    $user_obj = new User($pdo);

    $vehicle_stmt = $vehicle_obj->getListOfVehicles();
    $brands_stmt = $brand_obj->getListOfBrand();
    $category_stmt = $category_obj->getListOfCategories();
    $user_stmt = $user_obj->getListOfUsers();

// try {
    // $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // $users = [];
    // $user_sql = "SELECT user_id, username FROM Users";
    // $user_stmt = $pdo->query($user_sql);

    // while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $users[$row['user_id']] = $row['username'];
    // }

    // $brands = [];
    // $brands_sql = "SELECT brand_id, brand_name FROM Brands";
    // $brands_stmt = $pdo->query($brands_sql);

    // while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $brands[$row['brand_id']] = $row['brand_name'];
    // }
    
    // $vehicles_sql = "SELECT COUNT(*) AS total_entries FROM vehicles;";
    // $vehicles_stmt = $pdo->query($vehicles_sql);
    // $result = $vehicles_stmt->fetch(PDO::FETCH_ASSOC);

    // $totalEntries = $result['total_entries'];
    // $total = $totalEntries + 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $image_url = null;

    if (isset($_FILES['file_upload'])) {

        $image_obj = new Manage_image();

        $image_url = $image_obj->get_image_url($_FILES['file_upload']);
    }
    $stmt = $pdo->prepare("INSERT INTO Vehicles (owner_id, brand_id, category_id, model, description, rental_rate, availability_status, created_at, image_url) VALUES (:owner_id, :brand_id, :category_id, :model, :description, :rental_rate, :availability_status, NOW(), :image_url)");

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
                    <?php while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?></option>
                    <?php } ?>
                </select>
                <br><br>
                
                <label for="category_id">Select Category:</label>
                <select id="category_id" name="category_id">
                    <?php while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                    <?php } ?>
                </select>
                <br><br>

                <label for="brand_id">Select Brand:</label>
                <select id="brand_id" name="brand_id">
                    <?php while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
                    <?php } ?>
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
