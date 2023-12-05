<?php require 'header.php'; ?>
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

            try {
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
<?php require 'footer.php' ?>