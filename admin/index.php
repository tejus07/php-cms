<?php
include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();
$categories = $pdo->query('SELECT * FROM categories');
$users = $pdo->query('SELECT * FROM users');
?>
<?php include('shared/sidebar.php');?>

<div class="content">
    <header>
        <h2>Welcome, Admin User!</h2>
    </header>
    <main class="home-main">
    <div class="list-container">
        <h2 class="user-list-title">Browse recipies by Categories</h2>
        <ul class="category-list">
        <?php
        while ($post = $categories->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <li class="user-item-category">
                <span class="user-name"><?php echo $post['title']?></span>
            </li>
		<?php } ?>
        </ul>
    </div>
    
    <div class="list-container">
        <h2 class="user-list-title">Browse recipies by User</h2>
        <ul class="user-list">
        <?php
        while ($post = $users->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <li class="user-item">
                <span class="user-name"><?php echo $post['username']?></span>
            </li>
		<?php } ?>
        </ul>
    </div>
    </main>
</div>

        
<?php include('shared/footer.php');?>
