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

    $vehicle_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
    $query = "SELECT * FROM Vehicles WHERE vehicle_id = :vehicle_id";

    $stmt1 = $pdo->prepare($query);

    $stmt1->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);

    $stmt1->execute();

    $data = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sanitize
        $owner_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
        $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $rental_rate = filter_input(INPUT_POST, 'rental_rate', FILTER_VALIDATE_FLOAT);
        $availability_status = filter_input(INPUT_POST, 'availability_status', FILTER_SANITIZE_STRING);
        
        // Validate 
        if (
            $owner_id === false || $category_id === false || $brand_id === false ||
            empty($model) || empty($description) || $rental_rate === false || empty($availability_status)
        ):
            echo "Invalid input data. Please check the provided information.";
            exit();
        endif;


        $image_url = $data['image_url'];

        if (!empty($_FILES['file_upload']) && !isset($_POST['delete_image'])) {

            $image_obj = new Manage_image();

            $returned_value = $image_obj->get_image_url($_FILES['file_upload']);
            if ($returned_value) {
                $image_url = $returned_value;
            }
        } else {
            $image_path = "../" . $image_url;
            if (file_exists($image_path)) {
                unlink($image_path);
                echo "Image deleted successfully!";
            } else {
                echo "Image file not found.";
            }

            $image_url = null;
        }

        $stmt = $pdo->prepare("UPDATE Vehicles SET owner_id = :owner_id, category_id = :category_id, brand_id = :brand_id, model = :model, description = :description, rental_rate = :rental_rate, availability_status = :availability_status, image_url = :image_url WHERE vehicle_id = :vehicle_id");

        $stmt->bindParam(':vehicle_id', $vehicle_id);
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
    <title>Edit Vehicle</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
</head>

<body>
    <header>
        <h1>Edit Vehicle</h1>
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
        <?php include('common/navbar.php'); ?>
        <section class="admin-content">
            <form class="add-new-form" action="edit-vehicle.php?id=<?php echo $data['vehicle_id'] ?>" method="post"
                enctype="multipart/form-data">

                <?php if (!empty($data['image_url'])) { ?>
                    <label for="uploaded_image">Uploaded Image:</label>
                    <img src="../<?php echo $data['image_url'] ?>" alt="<?php echo $data['image_url'] ?>" width="300">

                    <label for="delete_image">Delete Image: <input type="checkbox" id="delete_image" name="delete_image"
                            value="delete"></label>
                <?php } ?>

                <label for="file_upload">Upload Image:</label>
                <input type="file" id="file_upload" name="file_upload">

                <label for="owner_id">Select User:</label>
                <select id="user_id" name="user_id" value="<?php echo $data['owner_id'] ?>">
                    <?php foreach ($users as $userId => $username): ?>
                        <option value="<?php echo $userId; ?>" <?php echo $userId == $data['owner_id'] ? 'selected' : '' ?>>
                            <?php echo $username; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br><br>

                <label for="category_id">Select Category:</label>
                <select id="category_id" name="category_id" value="<?php echo $data['category_id'] ?>">
                    <?php foreach ($categories as $category_id => $category_name): ?>
                        <option value="<?php echo $category_id; ?>" <?php echo $category_id == $data['category_id'] ? 'selected' : '' ?>>
                            <?php echo $category_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br><br>

                <label for="brand_id">Select Brand:</label>
                <select id="brand_id" name="brand_id" value="<?php echo $data['brand_id'] ?>">
                    <?php foreach ($brands as $brand_id => $brand_name): ?>
                        <option value="<?php echo $brand_id; ?>" <?php echo $brand_id == $data['brand_id'] ? 'selected' : '' ?>>
                            <?php echo $brand_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br><br>

                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="<?php echo $data['model'] ?>" required><br><br>

                <label for="description">Description:</label><br>
                <textarea id="description" name="description"><?php echo $data['description'] ?></textarea><br><br>

                <label for="rental_rate">Rental Rate:</label>
                <input type="text" id="rental_rate" name="rental_rate" value="<?php echo $data['rental_rate'] ?>"
                    required><br><br>

                <label for="availability_status">Availability Status:</label>
                <select id="availability_status" name="availability_status" class="form-input"
                    value="<?php echo $data['availability_status'] ?>" required>
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