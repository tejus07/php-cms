<?php
// database connection and query execution
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rentandgodb";
$vehicle_id = $_GET['vehicle_id'] ?? 0;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM Vehicles WHERE Vehicles.vehicle_id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicle_id, PDO::PARAM_INT);
    $stmt->execute();
    $vehicleData = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $vehicleData['model']; ?> - View Car</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
        <h1 class="site-logo"><a href="index.php">RentAndGo</a></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="vehicles-listing.php">Vehicles</a></li>
                <li class="dropdown">
                    <a class="dropbtn">Brands</a>
                    <div class="dropdown-content">
                        <?php
                        try {
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "rentandgodb";

                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT * FROM brands");
                            $stmt->execute();
                            $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($brands) > 0):
                                foreach ($brands as $brand):
                                    echo "<a href='brands.php?brand_id=" . $brand["brand_id"] . "'>" . $brand["brand_name"] . "</a>";
                                endforeach;
                            else:
                                echo "0 results";
                            endif;
                        } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }
                        ?>
                    </div>
                </li>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="admin/login.php">Login</a></li>
                <li>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "rentandgodb";

                    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                    $categories = [];
                    $category_sql = "SELECT category_id, category_name FROM Categories";
                    $category_stmt = $pdo->query($category_sql);

                    while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $categories[$row['category_id']] = $row['category_name'];
                    }

                    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                    $category_id = isset($_GET['category']) ? $_GET['category'] : 'all';
                    ?>

                    <form class="searchbar" action="searchpage.php" method="GET">
                        <div class="search-category-container">
                            <select name="category">
                                <option value="all">All Categories</option>
                                <?php foreach ($categories as $categoryId => $categoryName): ?>
                                    <option value="<?php echo $categoryId; ?>" <?php echo $category_id == $categoryId ? 'selected' : '' ?>>
                                        <?php echo $categoryName; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="partition-bar"></div>
                        <div class="search-bar-container">
                            <input type="text" name="keyword" placeholder="Enter keyword"
                                value="<?php echo $keyword; ?>">
                        </div>
                        <button class="search-btn" type="submit">Search</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="vehicle">
            <?php if(isset($vehicleData['model'])): ?>
            <h2><?php echo $vehicleData['model']; ?></h2>
            <div class="vehicle-info">
                <?php if(isset($vehicleData['image_url'])): ?>
                <img src="<?php echo $vehicleData['image_url']; ?>" alt="<?php echo $vehicleData['model']; ?>">
                <?php endif; ?>
                <p><strong>License Plate:</strong> <?php echo isset($vehicleData['license_plate']) ? $vehicleData['license_plate'] : ''; ?></p>
                <p><strong>Description:</strong> <?php echo isset($vehicleData['description']) ? $vehicleData['description'] : ''; ?></p>
                <p><strong>Rental Rate:</strong> $<?php echo isset($vehicleData['rental_rate']) ? $vehicleData['rental_rate'] : ''; ?> per day</p>
                <p><strong>Status:</strong> <?php echo isset($vehicleData['availability_status']) ? $vehicleData['availability_status'] : ''; ?></p>
                <!-- Display other details as needed -->
            </div>
            <?php else: ?>
            <p>No vehicle details found</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>