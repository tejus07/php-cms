<?php
include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$results = $pdo->query('SELECT * FROM users');

?>

<?php include('shared/sidebar.php');?>

<div class="content">
    <header>
        <h2>Users Page</h2>
        <a href="logout.php">Logout</a>
    </header>
    <main>
    <div class="user-list-container">
        <h2 class="user-list-title">User List</h2>
        <ul class="user-list">
        <?php
        while ($post = $results->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <li class="user-item">
                <span class="user-name"><?php echo $post['username']?></span>
                <span class="user-email"><?php echo $post['email']?></span>
                <div class="user-actions">
                    <button class="edit-button">Edit</button>
                    <button class="delete-button">Delete</button>
                </div>
            </li>
		<?php } ?>
        </ul>
    </div>
    </main>
</div>

        
<?php include('shared/footer.php');?>