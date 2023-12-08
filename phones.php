<?php
$title = 'My Posts';
require_once 'includes/header.php';
require 'includes/db.php';
require 'navbar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT phones.*, brands.name AS brand_name, brands.logo_url 
    FROM phones 
    INNER JOIN brands ON phones.brand_id = brands.id 
    WHERE phones.user_id = :user_id");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

<div class="container-fluid">
    <div class="row">
        <main role="main" class="col ml-sm-auto px-md-5">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Phones</h1>
                <a href="add-new-phone.php" class="btn btn-primary">Add New Phone</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Image</th>
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
                        if ($phone['image_url'] === null || empty($phone['image_url'])) {
                            echo '<td>No Image Available</td>';
                        } else {
                            echo '<td><img src="' . $phone['image_url'] . '" alt="Phone Image" style="max-width: 100px;"></td>'; // Display the image
                        }
                        echo '<td>' . $phone['name'] . '</td>';
                        echo '<td>' . $phone['description'] . '</td>';
                        echo '<td>
                        <a href="edit-phone.php?id=' . $phone['id'] . '" class="btn btn-primary">Edit</a>
                        <form method="post" action="delete-phone.php">
                            <input type="hidden" name="phone_id" value="' . $phone['id'] . '">
                </form>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>