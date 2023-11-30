<?php
$title = 'Add New Phone';
require_once '../includes/header.php';
require '../db.php';
require_once '../functions/function.php';
require '../navbar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description-hidden'];
    $release_date = $_POST['release_date'];
    $brand_id = $_POST['brand_id'];
    $user_id = $_POST['user_id'];
    $image_url = isset($_FILES['uploadFile']) ? upload_image($_FILES['uploadFile']) : null;
    $processor = $_POST['processor'];
    $RAM = $_POST['RAM'];
    $storage = $_POST['storage'];
    $camera = $_POST['camera'];
    $display = $_POST['display'];
    $battery = $_POST['battery'];
    $operating_system = $_POST['operating_system'];
    try {
        // ensure data consistency
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO phones (brand_id, name, description, release_date, image_url, user_id) VALUES (:brand_id, :name, :description, :release_date, :image_url, :user_id)");
        $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $release_date, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $phone_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO phone_specs (phone_id, processor, RAM, storage, camera, display, battery, operating_system) VALUES (:phone_id, :processor, :RAM, :storage, :camera, :display, :battery, :operating_system)");
        $stmt->bindParam(':phone_id', $phone_id, PDO::PARAM_INT);
        $stmt->bindParam(':processor', $processor, PDO::PARAM_STR);
        $stmt->bindParam(':RAM', $RAM, PDO::PARAM_INT);
        $stmt->bindParam(':storage', $storage, PDO::PARAM_INT);
        $stmt->bindParam(':camera', $camera, PDO::PARAM_STR);
        $stmt->bindParam(':display', $display, PDO::PARAM_STR);
        $stmt->bindParam(':battery', $battery, PDO::PARAM_STR);
        $stmt->bindParam(':operating_system', $operating_system, PDO::PARAM_STR);
        $stmt->execute();

        $pdo->commit();

        echo "Phone added successfully!";
        // header("Location: phones.php");
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        echo "<div class='error-message'>$error_message</div>";
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


                function updateHiddenTextarea() {
                    var hiddenTextarea = document.getElementById('description-hidden');
                    var content = tinymce.get('description').getContent();
                    hiddenTextarea.value = content;
                }

                document.querySelector('form').addEventListener('submit', updateHiddenTextarea);
            </script>
            <div class="container">
                <h2 class="add-phone-title">Add Phone</h2>
                <form class="phone-form" action="add-new-phone.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description-hidden" name="description-hidden"></textarea>

                    </div>
                    <div class="form-group">
                        <label for="release_date">Release Date:</label>
                        <input type="date" id="release_date" name="release_date" class="form-input" required>
                    </div>
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
                        <input type="text" id="processor" name="processor" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="RAM">RAM:</label>
                        <input type="number" id="RAM" name="RAM" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="storage">Storage:</label>
                        <input type="number" id="storage" name="storage" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="camera">Camera:</label>
                        <input type="text" id="camera" name="camera" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="display">Display:</label>
                        <input type="text" id="display" name="display" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="battery">Battery:</label>
                        <input type="text" id="battery" name="battery" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="operating_system">Operating System:</label>
                        <input type="text" id="operating_system" name="operating_system" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="brand_id">Select Brand</label>
                        <select id="brand_id" name="brand_id">
                            <?php foreach ($brands as $brandId => $brandName): ?>
                                <option value="<?php echo $brandId; ?>">
                                    <?php echo $brandName; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Select User:</label>
                        <select id="user_id" name="user_id">
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