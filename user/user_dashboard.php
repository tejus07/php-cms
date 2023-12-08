<?php include('shared/header.php');

if (isset($_SESSION['login_success'])) {
    $login_message = $_SESSION['login_success'];
    echo '<span class="login-success-message">' . $login_message . '</span>';
    unset($_SESSION['login_success']);
}

include_once '../shared/database.php';
include_once '../admin/shared/userHandler.php';

$conn = new Database();
$userHandler = new UserHandler($conn);

$user_id = $_SESSION['user_id'];

$userInfo = $userHandler->getUserInfo($user_id);
?>
        <main class="col-md-9 main-container">
            <section class="user-info">
                <h2>User Information</h2>
                <p>User Name: <?php echo $userInfo['username'] ?></p>
                <p>Email: <?php echo $userInfo['email'] ?></p>
            </section>
        </main>
    </div>
</div>

<?php include('../shared/footer.php'); ?>