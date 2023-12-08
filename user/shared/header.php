<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>PizzaPals</title>
</head>
<body class="home-user-dashboard">
    <header class="container-fluid text-light py-3">
    <div class="row align-items-center header-container">
        <div class="col-md-4">
            <h3 class="site-logo"><a href="./" class="text-dark">PizzaPals</a></h3>
        </div>
        <div class="col-md-4">
            <!-- <?php include_once('searchbar.php'); ?> -->
        </div>
        <div class="col-md-4">
            <?php include_once('navbar.php'); ?>
        </div>
    </div>
</header>

<div class="main-container container-fluid">
    <div class="row user-dashboard">
        <aside class="col-md-3 sidebar">
            <h2>Sidebar</h2>
            <ul class="list-unstyled">
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="my_post.php">My Post</a></li>
                <li><a href="add_new_post.php">Add New Post</a></li>
            </ul>
        </aside>