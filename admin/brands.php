<?php
$title = 'Admin';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once 'admin-navbar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM brands");
    $stmt->execute();

    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!-- <div class="content">
    <div class="user-list-container">
        <h2 class="user-list-title">Categories List</h2>
        <ul class="user-list">
        <?php
        foreach ($brands as $brand) {
            ?>
            <li class="user-item">
                <span class="user-name"><?php echo $brand['name'] ?></span>
                <div class="user-actions">
                    <button class="edit-button">Edit</button>
                    <button class="delete-button">Delete</button>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
</div> -->
<div class="container-fluid">
    <div class="row">
        <?php
        require 'admin-sidebar.php'
            ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Brands</h1>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($brands as $brand) {
                        echo '<tr>';
                        echo '<th scope="row">' . $brand['id'] . '</th>';
                        echo '<td>' . $brand['name'] . '</td>';
                        echo '<td>' . $brand['description'] . '</td>';
                        echo '<td>
                        <a href="#" class="btn btn-primary">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
    </div>
    </main>
</div>
</div>