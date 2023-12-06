<?php
$title = 'Add New Phone';
require_once 'includes/header.php';
require 'db.php';
require_once 'functions/function.php';
require 'navbar.php';

if (session_status() == PHP_SESSION_NONE):
    session_start();
endif;

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])):
    header("Location: ./login.php");
    exit();
endif;

if (isset($_GET['error'])):
    $error_message = $_GET['error'];
    echo "<div class='row'><div class='col-md-9 ml-sm-auto col-lg-10 px-md-4'>
    <div class='error-message'>$error_message</div>
    </div></div>";
endif;


$brands = [];
$brands_sql = "SELECT id, name FROM brands";
$brands_stmt = $pdo->query($brands_sql);

while ($row = $brands_stmt->fetch(PDO::FETCH_ASSOC)) {
    $brands[$row['id']] = $row['name'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize
    $name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : null;
    $description = isset($_POST['description-hidden']) && validateString($_POST['description-hidden'], 1, 1000) ? $_POST['description-hidden'] : null;
    $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : null;
    $image_url = isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] !== UPLOAD_ERR_NO_FILE ? upload_image($_FILES['uploadFile']) : null;
    $brand_id = isset($_POST['brand_id']) && is_numeric($_POST['brand_id']) ? (int) $_POST['brand_id'] : null;
    $user_id = isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    $processor = isset($_POST['processor']) ? $_POST['processor'] : null;
    $RAM = isset($_POST['RAM']) ? $_POST['RAM'] : null;
    $storage = isset($_POST['storage']) ? $_POST['storage'] : null;
    $camera = isset($_POST['camera']) ? $_POST['camera'] : null;
    $display = isset($_POST['display']) ? $_POST['display'] : null;
    $battery = isset($_POST['battery']) ? $_POST['battery'] : null;
    $operating_system = isset($_POST['operating_system']) ? $_POST['operating_system'] : null;

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
        header("Location: add-new-phone.php?error=" . urlencode($error_message) . "&name=" . urlencode($name) . "&brand_id=" . urlencode($brand_id) . "&user_id=" . urlencode($user_id) . "&processor=" . urlencode($processor) . "&RAM=" . urlencode($RAM) . "&storage=" . urlencode($storage) . "&camera=" . urlencode($camera) . "&display=" . urlencode($display) . "&battery=" . urlencode($battery) . "&operating_system=" . urlencode($operating_system));
        exit();
    else:
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
            header("Location: phones.php");
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            echo "<div class='error-message'>$error_message</div>";
        }
    endif;
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
                    <input type="submit" value="Save" class="submit-button">
                </form>
            </div>
        </main>
    </div>
</div>
<?php
require_once 'includes/footer.php';
?>