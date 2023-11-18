<?php 
include_once 'common/isUserLoggedIn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Category Management</h1>
    </header>
    <main class="admin-container">
	<?php include('common/navbar.php');?>
        <section class="admin-content">
            <h2>Manage Category</h2>
            <table class="vehicle-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
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

                        $stmt = $pdo->query("SELECT * FROM Categories"); 

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['category_id'] . "</td>";
                            echo "<td>" . $row['category_name'] . "</td>";
                            echo "<td><button class='edit-btn'><a href='edit-category.php?id=". $row['category_id'] ."'>Edit</a></button></td>";
                            ?>
                            <td><form method="post" action="delete-category.php">
                                <input type="hidden" name="category_id" value="<?php echo $row['category_id']?>">
                                <input type="submit" class="delete-button" name="delete_category" value="Delete" onclick="return confirm('Are you sure you want to delete this Category?');">
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
