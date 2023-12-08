<?php 
include_once 'common/isUserLoggedIn.php';

if (isset($_GET['success'])) {
    $login_success = "Logged in successfully";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - RentAndGo</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Dashboard Panel - RentAndGo</h1>
    </header>
    
    <?php if (isset($login_success)) { ?>
        <span class="login-successful-message"><?php echo $login_success; ?></span>
    <?php } ?>

    <main class="admin-container">
	<?php include('common/navbar.php');?>
        <section class="admin-content">
            <h2>Dashboard</h2>
            <p>Welcome to the Dashboard Panel. Choose an option from the sidebar.</p>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
