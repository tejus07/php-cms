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
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="admin/login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="vehicle-list">
            <h2>Available Vehicles</h2>
            <div class="vehicles-container">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "rentandgodb";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("SELECT * FROM Vehicles");
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {

                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<div class='vehicle'>
                                    <h3>" . $row["model"] . "</h3>
                                    <p>Description: " . $row["description"] . "</p>
                                    <p>Rental Rate: $" . $row["rental_rate"] . " per day</p>
                                    <p>Availability: " . $row["availability_status"] . "</p>";
                                    ?>
                                    <?php if (!empty($row["image_url"])) {?>
                                        <img src="<?php echo $row["image_url"]?>" alt='Vehicle Image'>
                                        <?php }?>
                                    <?php echo "</div>";
                        }
                    } else {
                        echo "0 results";
                    }
                } catch(PDOException $e) {
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
