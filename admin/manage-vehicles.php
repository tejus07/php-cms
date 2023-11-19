<?php 
include_once 'common/isUserLoggedIn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicle Management</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Vehicle Management</h1>
    </header>
    <main class="admin-container">
	<?php include('common/navbar.php');?>
        <section class="admin-content">
            <h2>Manage Vehicles</h2>
            <table class="vehicle-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Owner</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>Rental Rate</th>
                        <th>Availability Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    @include_once 'common/database.php';
                    @include_once 'class/vehicle.php';

                    try {

                        $conn = new Database();

                        $pdo = $conn->setupConnection();
                        
                        $vehicle_obj = new Vehicle($pdo);
                        $stmt = $vehicle_obj->getListOfVehicles();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['vehicle_id'] . "</td><td>";

                            if(!empty($row['image_url'])) {
                            ?>
                            <img src="../<?php echo $row['image_url'] ?>" width="100">
                            <?php }
                            echo "</td><td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['brand_name'] . "</td>";
                            echo "<td>" . $row['category_name'] . "</td>";
                            echo "<td>" . $row['model'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['rental_rate'] . "</td>";
                            echo "<td>" . $row['availability_status'] . "</td>";
                            echo "<td><button class='edit-btn'><a href='edit-vehicle.php?id=". $row['vehicle_id'] ."'>Edit</a></button></td>";
                            ?>
                            <td><form method="post" action="delete-vehicle.php">
                                <input type="hidden" name="vehicle_id" value="<?php echo $row['vehicle_id']?>">
                                <input type="submit" class="delete-button" name="delete_vehicle" value="Delete" onclick="return confirm('Are you sure you want to delete this Vehicle?');">
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
