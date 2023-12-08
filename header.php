<?php
include_once 'connect.php';

$database = new Database();

$conn = $database->getConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RentAndGo - Your Car Rental Solution</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="row align-items-center">
        <div class="col-md-2 logo-wrapper">
        <div class="site-logo"><a href="index.php">RentAndGo</a></div>
        </div>
        <div class="col-md-4 nav-bar-wrapper">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="vehicles-listing.php">Vehicles</a></li>
                <li class="dropdown">
                    <a class="dropbtn">Brands</a>
                    <div class="dropdown-content">
                        <?php
                        try {
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
                
            </ul>
        </nav>
        </div>
        <div class="col-md-4">
            <div class="searchbar-wrapper">
                <?php
                    $categories = [];
                    $category_sql = "SELECT category_id, category_name FROM Categories";
                    $category_stmt = $conn->query($category_sql);

                    while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $categories[$row['category_id']] = $row['category_name'];
                    }

                    $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword'], ENT_QUOTES) : '';
                    $category_id = isset($_GET['category']) ? ($_GET['category'] === 'all' ? 'all' : intval($_GET['category'])) : 'all';

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
                        <button class="btn btn-primary search-btn" type="submit">Search</button>
                    </form>
            </div>
        </div>
    </header>