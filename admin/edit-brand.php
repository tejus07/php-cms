<?php
include_once 'common/isUserLoggedIn.php';

$host = 'localhost';
$dbname = "rentandgodb";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $brand_id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
    $query = "SELECT * FROM Brands WHERE brand_id = :brand_id";

    $stmt1 = $pdo->prepare($query);

    $stmt1->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);

    $stmt1->execute();

    $data = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sanitize
        $brand_name = filter_input(INPUT_POST, 'brand_name', FILTER_SANITIZE_STRING);

        // Validate
        if (empty($brand_name)) {
            echo "Brand Name is required.";
            exit();
        }

        $stmt = $pdo->prepare("UPDATE brands SET brand_name = :brand_name WHERE brand_id = :brand_id");

        $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
        $stmt->bindParam(':brand_name', $brand_name, PDO::PARAM_STR);
        $stmt->execute();

        echo "New brand added successfully!";
        header("Location: manage-brands.php");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Brand</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Edit Brand</h1>
    </header>
    <main class="admin-container">
        <?php include('common/navbar.php'); ?>
        <section class="admin-content">
            <form class="add-new-form" action="edit-brand.php?id=<?php echo $data['brand_id'] ?>" method="post">
                <label for="brand_name">Brand Name:</label>
                <input type="text" id="brand_name" name="brand_name" value="<?php echo $data['brand_name'] ?>"
                    required><br><br>

                <input type="submit" value="Submit">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>

</html>