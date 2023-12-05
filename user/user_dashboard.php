<?php include('shared/header.php'); ?>

<link rel="stylesheet" type="text/css" href="../css/styles.css">
<style>
.sidebar {
    width: 250px;
    background-color: #fff; /* White sidebar background */
    padding: 15px;
    border-right: 1px solid #ccc; /* Light border */
}

.sidebar h2 {
    margin-bottom: 15px;
    color: #333; /* Dark text color */
}

.sidebar ul {
    list-style: none;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    color: #333; /* Dark text color */
    text-decoration: none;
    display: block;
    padding: 8px 0;
    transition: background-color 0.3s ease;
}

.sidebar ul li a:hover {
    background-color: #f0f0f0; /* Hover background color */
}

.main-container {
    display: flex;
    flex-direction: row;
}

.user-dashboard {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    padding: 20px;
}

.content {
    flex: 1;
    padding: 20px;
}

</style>

<?php
    include_once '../shared/database.php';
    include_once '../admin/shared/userHandler.php';

    $conn = new Database();
    $userHandler = new UserHandler($conn);

    $user_id = $_SESSION['user_id'];

    $userInfo = $userHandler->getUserInfo($user_id);

?>

    <div class="user-dashboard">
        <aside class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="my_post.php">My Post</a></li>
                <li><a href="add_new_post.php">Add New Post</a></li>
            </ul>
        </aside>

        <main class="main-container">
            <section class="user-info">
                <h2>User Information</h2>
                <p>User Name: <?php echo $userInfo['username'] ?></p>
                <p>Email: <?php echo $userInfo['email'] ?></p>
                <p>Joined: <?php echo $userInfo['created_at']; ?></p>
            </section>
        </main>
    </div>

<?php include('../shared/footer.php');?>