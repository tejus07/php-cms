<?php require 'header.php'; 
$vehicle_id = isset($_GET['vehicle_id']) ? intval($_GET['vehicle_id']) : 0;

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM Vehicles WHERE Vehicles.vehicle_id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicle_id, PDO::PARAM_INT);
    $stmt->execute();
    $vehicleData = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<main>
    <section class="vehicle">
        <?php if (isset($vehicleData['model'])): ?>
            <h2>
                <?php echo $vehicleData['model']; ?>
            </h2>
            <div class="vehicle-info">
                <?php if (isset($vehicleData['image_url'])): ?>
                    <img src="<?php echo $vehicleData['image_url']; ?>" alt="<?php echo $vehicleData['model']; ?>">
                <?php endif; ?>
                <p><strong>License Plate:</strong>
                    <?php echo isset($vehicleData['license_plate']) ? $vehicleData['license_plate'] : ''; ?>
                </p>
                <p><strong>Description:</strong>
                    <?php echo isset($vehicleData['description']) ? $vehicleData['description'] : ''; ?>
                </p>
                <p><strong>Rental Rate:</strong> $
                    <?php echo isset($vehicleData['rental_rate']) ? $vehicleData['rental_rate'] : ''; ?> per day
                </p>
                <p><strong>Status:</strong>
                    <?php echo isset($vehicleData['availability_status']) ? $vehicleData['availability_status'] : ''; ?>
                </p>
            </div>
        <?php else: ?>
            <p>No vehicle details found</p>
        <?php endif; ?>
    </section>
</main>
<?php require 'footer.php' ?>