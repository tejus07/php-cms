<?php
$host = 'localhost';
$dbname = "rentandgodb";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id'];

        try {
            $sql = "DELETE FROM Vehicles WHERE vehicle_id = :vehicle_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':vehicle_id', $vehicle_id);
            $stmt->execute();

            echo "Vehicle deleted successfully!";
            header("Location: manage-vehicles.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
} 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
