<?php
$title = 'Edit Phone';
require_once '../includes/header.php';
require '../db.php';
require '../navbar.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$phone_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$query = "SELECT phones.*, 
phone_specs.processor, phone_specs.RAM, phone_specs.storage, phone_specs.camera, phone_specs.display, phone_specs.battery, phone_specs.operating_system,
brands.name AS brand_name
FROM phones
INNER JOIN phone_specs ON phone_specs.phone_id = phones.id
INNER JOIN brands ON brands.id = phones.brand_id 
WHERE phones.id = :phoneId
AND phones.user_id = :userId";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':phoneId', $phone_id, PDO::PARAM_INT);
$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);
if (empty($data)) {
    header("Location: phones.php");
    exit();
}

$brands = [];
$brands_sql = "SELECT id, name FROM brands";
$brands_stmt = $pdo->query($brands_sql);

while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
    $brands[$row['id']] = $row['name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $phone_id = $_GET['id'];
    $name = $_POST['name'];
    $description = $_POST['description-hidden'];
    $release_date = $_POST['release_date'];
    $image_url = $_POST['image_url'];
    $processor = $_POST['processor'];
    $RAM = $_POST['RAM'];
    $storage = $_POST['storage'];
    $camera = $_POST['camera'];
    $display = $_POST['display'];
    $battery = $_POST['battery'];
    $operating_system = $_POST['operating_system'];
    $brand_id = $_POST['brand_id'];

    try {
        $pdo->beginTransaction();
        $sql = "UPDATE phones SET 
        name = :name,
        description = :description,
        release_date = :release_date,
        image_url = :image_url,
        brand_id = :brand_id
        WHERE id = :phone_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':release_date', $release_date);
        $stmt->bindValue(':image_url', $image_url);
        $stmt->bindValue(':brand_id', $brand_id);
        $stmt->bindValue(':phone_id', $phone_id);
        $stmt->execute();

        $sql1 = "UPDATE phone_specs SET
        processor = :processor,
        RAM = :RAM,
        storage = :storage,
        camera = :camera,
        display = :display,
        battery = :battery,
        operating_system = :operating_system
        WHERE phone_id = :phone_id";

        $stmt = $pdo->prepare($sql1);
        $stmt->bindValue(':processor', $processor);
        $stmt->bindValue(':RAM', $RAM);
        $stmt->bindValue(':storage', $storage);
        $stmt->bindValue(':camera', $camera);
        $stmt->bindValue(':display', $display);
        $stmt->bindValue(':battery', $battery);
        $stmt->bindValue(':operating_system', $operating_system);
        $stmt->bindValue(':phone_id', $phone_id);
        $stmt->execute();

        $pdo->commit();
        echo "Phone updated successfully!";
        header("Location: phones.php");
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <script>
                tinymce.init({
                    selector: 'textarea#description-hidden',
                    plugins: 'advlist autolink lists link image charmap print preview anchor',
                    toolbar_mode: 'floating',
                });
            </script>
            <div class="container">
                <h2 class="edit-phone-title">Edit Phone</h2>
                <form class="phone-form" action="edit-phone.php?id=<?php echo $data['id'] ?>" method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-input" value="<?php echo $data['name'] ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description-hidden"
                            name="description-hidden"><?php echo $data['description'] ?></textarea>

                    </div>
                    <div class="form-group">
                        <label for="release_date">Release Date:</label>
                        <input type="date" id="release_date" name="release_date" class="form-input"
                            value="<?php echo $data['release_date'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="image_url">Image URL:</label>
                        <input type="text" id="image_url" name="image_url" class="form-input"
                            value="<?php echo $data['image_url'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="processor">Processor:</label>
                        <input type="text" id="processor" name="processor" class="form-input"
                            value="<?php echo $data['processor'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="RAM">RAM:</label>
                        <input type="number" id="RAM" name="RAM" class="form-input" value="<?php echo $data['RAM'] ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="storage">Storage:</label>
                        <input type="number" id="storage" name="storage" class="form-input"
                            value="<?php echo $data['storage'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="camera">Camera:</label>
                        <input type="text" id="camera" name="camera" class="form-input"
                            value="<?php echo $data['camera'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="display">Display:</label>
                        <input type="text" id="display" name="display" class="form-input"
                            value="<?php echo $data['display'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="battery">Battery:</label>
                        <input type="text" id="battery" name="battery" class="form-input"
                            value="<?php echo $data['battery'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="operating_system">Operating System:</label>
                        <input type="text" id="operating_system" name="operating_system" class="form-input"
                            value="<?php echo $data['operating_system'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="brand_id">Select Brand</label>
                        <select id="brand_id" name="brand_id">
                            <?php foreach ($brands as $brandId => $brandName): ?>
                                <option value="<?php echo $brandId; ?>" <?php echo ($brandId == $data['brand_id']) ? 'selected' : ''; ?>>
                                    <?php echo $brandName; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" value="Save" class="submit-button">
                </form>
            </div>
        </main>
    </div>
</div>