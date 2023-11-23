<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RentAndGo - Your Car Rental Solution</title>
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
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Rent the Perfect Car for Your Adventure</h2>
            <p>Find a wide range of vehicles for rent at competitive rates.</p>
            <a href="vehicles-listing.php" class="btn">Get Started</a>
        </section>

        <section class="features">
            <h2>Why RentAndGo?</h2>
            <div class="feature">
                <h3>Easy Booking</h3>
                <p>Our platform makes booking a car hassle-free.</p>
            </div>
            <div class="feature">
                <h3>Diverse Fleet</h3>
                <p>Choose from various vehicle types to suit your needs.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
