<?php
$title = 'Admin';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once 'admin-navbar.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

// Delete logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        // Redirect to prevent duplicate form submissions
        header("Location: users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: ".$e->getMessage();
}
?>
<div class="container-fluid">
    <div class="row">
        <?php
        require 'admin-sidebar.php';
        ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Users</h1>
                <a href="add-new-user.php" class="btn btn-primary">Add New User</a>
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
                    foreach($users as $user) {
                        echo '<tr>';
                        echo '<th scope="row">'.$user['id'].'</th>';
                        echo '<td>'.$user['username'].'</td>';
                        echo '<td>'.$user['email'].'</td>';
                        echo '<td><a href="edit-user.php?id=' . $user['id'] . '" class="btn btn-primary">Edit</a></td>';
                        echo '<td>
                                <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this user?\')">
                                    <input type="hidden" name="user_id" value="'.$user['id'].'">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
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
require_once '../includes/footer.php';
?>
