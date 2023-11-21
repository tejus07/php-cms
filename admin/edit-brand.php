<?php
$title = 'Edit Brand';
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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])):
    try {
        $brandId = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM brands WHERE id = :id");
        $stmt->bindValue(':id', $brandId);
        $stmt->execute();

        $brand = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$brand):
            echo "Brand not found.";
            exit();
        endif;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }

elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])):
    try {
        $brandId = $_POST['brand_id'];
        $brandName = $_POST['brand_name'];
        $brandDescription = $_POST['brand_description'];

        $stmt = $pdo->prepare("UPDATE brands SET name = :name, description = :description WHERE id = :id");
        $stmt->bindValue(':name', $brandName);
        $stmt->bindValue(':description', $brandDescription);
        $stmt->bindValue(':id', $brandId);
        $stmt->execute();

        // Redirect to brands.php after successful update
        header("Location: brands.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
else:
    echo "Invalid request method or parameters.";
    exit();
endif;
?>

<div class="container-fluid">
    <div class="row">
    <?php
        require 'admin-sidebar.php'
            ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Brand</h1>
            </div>
            <form method="post">
                <input type="hidden" name="brand_id" value="<?= $brand['id'] ?>">
                <div class="form-group">
                    <label for="brandName">Name:</label>
                    <input type="text" class="form-control" id="brandName" name="brand_name"
                        value="<?= $brand['name'] ?>">
                </div>
                <div class="form-group">
                    <label for="brandDescription">Description:</label>
                    <textarea class="form-control" id="brandDescription"
                        name="brand_description"><?= $brand['description'] ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Update Brand</button>
            </form>
        </main>
    </div>
</div>