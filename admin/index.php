<?php 
include_once 'common/isUserLoggedIn.php';
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
        <h1>Admin Panel - RentAndGo</h1>
    </header>
    <main class="admin-container">
	<?php include('common/navbar.php');?>
        <section class="admin-content">
            <h2>Dashboard</h2>
            <p>Welcome to the Admin Panel. Choose an option from the sidebar.</p>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>
</html>
