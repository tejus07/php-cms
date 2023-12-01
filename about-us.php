<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - RentAndGo</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="template-about-us">
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
        <section class="about-section">
            <h2>Our Story</h2>
            <p>Welcome to RentAndGo, where car rentals meet unforgettable experiences. Our journey began with a simple idea: to create a platform where renting a vehicle is not just a transaction, but an adventure waiting to unfold.</p>
            <p>Driven by our passion for exploration, we believe that every road trip holds the potential for unforgettable moments. RentAndGo is more than just a car rental service; it's a community of fellow travelers sharing stories, discovering new horizons, and making memories that last a lifetime.</p>
        </section>

        <section class="mission-vision">
            <h2>Our Mission & Vision</h2>
            <p>Our mission is to revolutionize the car rental experience, offering a seamless platform that connects travelers with the perfect vehicle for their journey. We aim to provide a diverse range of vehicles, ensuring that every adventure seeker finds their ideal ride.</p>
            <p>At RentAndGo, our vision is to foster a community where travel enthusiasts connect, share, and inspire each other. We strive to create a space where the joy of exploration meets the ease of connection.</p>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
