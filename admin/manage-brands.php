<?php 
include_once 'common/isUserLoggedIn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brand Management</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Brand Management</h1>
    </header>
    <main class="admin-container">
	<?php include('common/navbar.php');?>
        <section class="admin-content">
            <h2>Manage Vehicles</h2>
            <table class="vehicle-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $host = 'localhost';
                    $dbname = "rentandgodb";
                    $username = 'root';
                    $password = '';

                    try {
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $stmt = $pdo->query("SELECT * FROM Brands"); 

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['brand_id'] . "</td>";
                            echo "<td>" . $row['brand_name'] . "</td>";
                            echo "<td><button class='edit-btn'><a href='edit-brand.php?id=". $row['brand_id'] ."'>Edit</a></button></td>";
                            ?>
                            <td><form method="post" action="delete-brand.php">
                                <input type="hidden" name="brand_id" value="<?php echo $row['brand_id']?>">
                                <input type="submit" class="delete-button" name="delete_brand" value="Delete" onclick="return confirm('Are you sure you want to delete this Brand?');">
                            </form></td>
                            <?php 
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
