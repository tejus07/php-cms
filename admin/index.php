<?php
session_start();
?>
<?php include('shared/sidebar.php');

if(empty($_SESSION['user_id']) || empty($_SESSION['user_role'])) {
    header('Location: login.php');
}

if (isset($_SESSION['login_success'])) {
    $login_message = $_SESSION['login_success'];
    echo '<span class="login-success-message">'. $login_message .'</span>';
    unset($_SESSION['login_success']);
}

?>

<div class="content">
    <header>
        <h2>Welcome, Admin User</h2>
        <a href="logout.php">Logout</a>
    </header>
    <main>
    </main>
</div>

        
<?php include('shared/footer.php');?>
