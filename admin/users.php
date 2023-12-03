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
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        echo '<tr>';
                        echo '<th scope="row">' . $user['id'] . '</th>';
                        echo '<td>' . $user['username'] . '</td>';
                        echo '<td>' . $user['email'] . '</td>';
                        echo '<td><a href="#" class="btn btn-primary">Edit</a></td>
                        <td><a href="#" class="btn btn-danger">Delete</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
    </div>
    </main>
</div>
</div>
<?php
require_once '../includes/footer.php';
?>