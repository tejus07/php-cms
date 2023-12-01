<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vehicles - RentAndGo</title>
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
        <section class="vehicle-list">
            <h2>Available Vehicles</h2>
            <form method="GET" action="vehicles-listing.php">
                <label for="sort">Sort by:</label>
                <select id="sort" name="sort">
                    <option value="model_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'model_asc')
                        echo 'selected'; ?>>Model (A-Z)</option>
                    <option value="model_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'model_desc')
                        echo 'selected'; ?>>Model (Z-A)</option>
                    <option value="rate_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'rate_asc')
                        echo 'selected'; ?>>Rental Rate (Low to High)</option>
                    <option value="rate_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'rate_desc')
                        echo 'selected'; ?>>Rental Rate (High to Low)</option>
                    <option value="created_at_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'created_at_asc')
                        echo 'selected'; ?>>Created At (Low to High)</option>
                    <option value="created_at_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'created_at_asc')
                        echo 'selected'; ?>>Created At (High to Low)</option>
                </select>
                <button type="submit">Sort</button>
            </form>
            <div class="vehicles-container">
                <?php
                $selectedSort = $_GET['sort'] ?? 'model_asc';

                // Define sorting conditions based on the selected option
                switch ($selectedSort) {
                    case 'model_asc':
                        $orderBy = 'model ASC';
                        break;
                    case 'model_desc':
                        $orderBy = 'model DESC';
                        break;
                    case 'rate_asc':
                        $orderBy = 'rental_rate ASC';
                        break;
                    case 'rate_desc':
                        $orderBy = 'rental_rate DESC';
                        break;
                    case 'created_at_asc':
                        $orderBy = 'created_at ASC';
                        break;
                    case 'created_at_desc':
                        $orderBy = 'created_at DESC';
                        break;
                    default:
                        $orderBy = 'model ASC';
                }

                // database connection and query execution
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "rentandgodb";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("SELECT * FROM Vehicles ORDER BY $orderBy");
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<div class='vehicle'>
                        <h3>" . $row["model"] . "</h3>
                        <p>Description: " . $row["description"] . "</p>
                        <p>Rental Rate: $" . $row["rental_rate"] . " per day</p>
                        <p>Availability: " . $row["availability_status"] . "</p>";

                            if (!empty($row["image_url"])) {
                                echo "<img src='" . $row["image_url"] . "' alt='Vehicle Image'>";
                            }
                            echo "<a href='view-vehicle.php?vehicle_id=" . $row["vehicle_id"] . "' class='view-button'>View Details</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "0 results";
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }

                $conn = null;
                ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>

</html>