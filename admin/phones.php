<?php
$title = 'Admin';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once 'admin-navbar.php';

try {
    $stmt = $pdo->prepare("SELECT phones.*, brands.name AS brand_name, brands.logo_url FROM phones INNER JOIN brands ON phones.brand_id = brands.id");
    $stmt->execute();

    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<div class="container-fluid">
    <div class="row">
        <?php
        require 'admin-sidebar.php'
            ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Phones</h1>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($phones as $phone) {
                        echo '<tr>';
                        echo '<th scope="row">' . $phone['id'] . '</th>';
                        echo '<td>' . $phone['brand_name'] . '</td>';
                        echo '<td>' . $phone['name'] . '</td>';
                        echo '<td>' . $phone['description'] . '</td>';
                        echo '<td>
                        <a href="edit-phone.php?id='.$phone['id'].'" class="btn btn-primary">Edit</a>
                        <form method="post" action="delete-phone.php">
                            <input type="hidden" name="phone_id" value="'.$phone['id'].'">
                            <input type="submit" class="delete-button" name="delete_phone" value="Delete Phone" onclick="return confirm("Are you sure you want to delete this phone?");">
                </form>
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