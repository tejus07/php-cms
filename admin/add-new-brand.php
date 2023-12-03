<?php
$title = 'Add New Brand';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once '../functions/function.php';
require_once 'admin-navbar.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])):
    $brandName = isset($_POST['brand_name']) ? filter_var($_POST['brand_name'], FILTER_SANITIZE_STRING) : null;
    $brandDescription = isset($_POST['brand_description']) && validateString($_POST['brand_description'], 1, 1000) ? $_POST['brand_description'] : null;

    if (
        empty($brandName) || empty($brandDescription)
    ):
        $error_message = "Please enter all required fields and brand description cannot be exceed 1000 characters";
        header("Location: add-new-brand.php?error=" . urlencode($error_message) . "&brandName=" . urlencode($brandName) . "&brandDescription=" . urlencode($brandDescription));
        exit();
    else:
        try {

            $stmt = $pdo->prepare("INSERT INTO brands (name, description) VALUES (:name, :description)");
            $stmt->bindValue(':name', $brandName);
            $stmt->bindValue(':description', $brandDescription);
            $stmt->execute();
            header("Location: brands.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    endif;

endif;
?>

<div class="container-fluid">
    <div class="row">
        <?php require 'admin-sidebar.php'; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Brand</h1>
            </div>
            <form method="post">
                <div class="form-group">
                    <label for="brandName">Name:</label>
                    <input type="text" class="form-control" id="brandName" name="brand_name" required>
                </div>
                <div class="form-group">
                    <label for="brandDescription">Description:</label>
                    <textarea class="form-control" id="brandDescription" name="brand_description" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Add Brand</button>
            </form>
        </main>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>