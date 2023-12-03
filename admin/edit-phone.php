<?php
$title = 'Edit Phone';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once '../functions/function.php';
require_once 'admin-navbar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

if (isset($_GET['error'])):
    $error_message = $_GET['error'];
    echo "<div class='row'><div class='col-md-9 ml-sm-auto col-lg-10 px-md-4'>
    <div class='error-message'>$error_message</div>
    </div></div>";
endif;


$phone_id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

if (!$phone_id) :
    header("Location: phones.php");
    exit();
endif;

$query = "SELECT phones.*, 
    phone_specs.processor, phone_specs.RAM, phone_specs.storage, phone_specs.camera, 
    phone_specs.display, phone_specs.battery, phone_specs.operating_system,
    brands.name AS brand_name FROM phones
    INNER JOIN phone_specs ON phone_specs.phone_id = phones.id
    INNER JOIN brands ON brands.id = phones.brand_id 
    WHERE phones.id = :phoneId";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':phoneId', $phone_id, PDO::PARAM_INT);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);

$users = [];
$user_sql = "SELECT id, username FROM Users";
$user_stmt = $pdo->query($user_sql);

while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
    $users[$row['id']] = $row['username'];
}

$brands = [];
$brands_sql = "SELECT id, name FROM brands";
$brands_stmt = $pdo->query($brands_sql);

while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
    $brands[$row['id']] = $row['name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    $phone_id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

    if (!$phone_id) {
        header("Location: phones.php");
        exit();
    }

    $name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : null;
    $description = isset($_POST['description-hidden']) && validateString($_POST['description-hidden'], 1, 1000) ? $_POST['description-hidden'] : null;
    $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : null;
    $brand_id = isset($_POST['brand_id']) && is_numeric($_POST['brand_id']) ? (int) $_POST['brand_id'] : null;
    $user_id = isset($_POST['user_id']) && is_numeric($_POST['user_id']) ? (int) $_POST['user_id'] : null;
    $processor = isset($_POST['processor']) ? $_POST['processor'] : null;
    $RAM = isset($_POST['RAM']) ? $_POST['RAM'] : null;
    $storage = isset($_POST['storage']) ? $_POST['storage'] : null;
    $camera = isset($_POST['camera']) ? $_POST['camera'] : null;
    $display = isset($_POST['display']) ? $_POST['display'] : null;
    $battery = isset($_POST['battery']) ? $_POST['battery'] : null;
    $operating_system = isset($_POST['operating_system']) ? $_POST['operating_system'] : null;
    $imageUpdated = isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] !== UPLOAD_ERR_NO_FILE;
    $image_url = $data['image_url'];


    if ($release_date && !validateDate($release_date, 'Y-m-d')):
        header("Location: add-new-phone.php?error=Invalid release date");
        exit();
    endif;

    if (
        empty($name) || empty($description) || empty($brand_id) ||
        empty($user_id) || empty($processor) || empty($RAM) || empty($RAM) ||
        empty($storage) || empty($camera) || empty($display) || empty($battery) || empty($operating_system)
    ):
        $error_message = "Please enter all required fields";
        header("Location: edit-phone.php?error=" . urlencode($error_message) . "&name=" . urlencode($name) . "&brand_id=" . urlencode($brand_id) . "&user_id=" . urlencode($user_id) . "&processor=" . urlencode($processor) . "&RAM=" . urlencode($RAM) . "&storage=" . urlencode($storage) . "&camera=" . urlencode($camera) . "&display=" . urlencode($display) . "&battery=" . urlencode($battery) . "&operating_system=" . urlencode($operating_system));
        exit();
    endif;

    if ($imageUpdated) {

        if (!empty($_FILES['uploadFile']) && !isset($_POST['delete_image'])) {
            $returned_value = upload_image($_FILES['uploadFile']);
            if ($returned_value) {
                $image_url = $returned_value;
            }
        } else {
            $image_path = "../" . $image_url;
            if (file_exists($image_path)) {
                unlink($image_path);
                echo "Image deleted successfully!";
            } else {
                echo "Image not found.";
            }

            $image_url = null;
        }
    }


    try {
        $sql = "UPDATE phones SET 
        name = :name,
        description = :description,
        release_date = :release_date,
        image_url = :image_url,
        brand_id = :brand_id,
        user_id = :user_id
        WHERE id = :phone_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':release_date', $release_date);
        $stmt->bindValue(':image_url', $image_url);
        $stmt->bindValue(':brand_id', $brand_id);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':phone_id', $phone_id, PDO::PARAM_INT);
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

        echo "Phone updated successfully!";
        header("Location: phones.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        echo "<div class='error-message'>$error_message</div>";
    }
endif;
?>
<div class="container-fluid">
    <div class="row">
        <?php
        require 'admin-sidebar.php'
            ?>

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
                <form class="phone-form" action="edit-phone.php?id=<?php echo $data['id'] ?>" method="post"
                    enctype="multipart/form-data">
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
                    <!-- <div class="form-group">
                        <label for="image_url">Uploaded Image:</label>
                        <?php if (!empty($data['image_url'])): ?>
                            <img src="../uploads/<?php echo $data['image_url']; ?>" alt="Uploaded Image" width="200">
                        <?php else: ?>
                            <p>No image uploaded</p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="image_url">Upload Image:</label>
                        <input type="file" id="image_url" name="image_url" class="form-input">
                    </div> -->
                    <?php if (!empty($data['image_url'])): ?>
                        <div class="form-group">
                            <label for="image_url">Uploaded Image:</label>
                            <span class="image-container"><img src="../<?php echo $data['image_url'] ?>" width="100"></span>
                        </div>
                        <div class="form-group">
                            <label for="delete_image">Delete Image: </label>
                            <span class="delete-checkbox">
                                <input type="checkbox" id="delete_image" name="delete_image" value="delete">
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="image_url">Upload Image:</label>
                        <input type="file" id="image_url" name="uploadFile" class="form-input">
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('image_url').addEventListener('change', function () {
                                const fileInput = document.getElementById('image_url');
                                const filePath = fileInput.value;
                                const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

                                if (!allowedExtensions.exec(filePath)) {
                                    alert('Please upload files having extensions .jpg/.jpeg/.png/.gif only.');
                                    fileInput.value = '';
                                    throw new Error('Incorrect file format');
                                }
                            });
                        });
                    </script>
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

                    <div class="form-group">
                        <label for="user_id">Select User:</label>
                        <select id="user_id" name="user_id" value="<?php echo $data['user_id'] ?>">
                            <?php foreach ($users as $userId => $username): ?>
                                <option value="<?php echo $userId; ?>">
                                    <?php echo $username; ?>
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
<?php
require_once '../includes/footer.php';
?>