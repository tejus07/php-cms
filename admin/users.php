<?php
include_once '../shared/database.php';

$database = new Database();

if(empty($_SESSION['user_id']) || empty($_SESSION['role'])) {
    header('Location: login.php');
}

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
        <button class="add-new-user-btn edit-button"><a href="add_new_user.php">Add New</a></button>
        <ul class="user-list">
            <li class="user-item">
                <span class="user-name">Username</span>
                <span class="user-name">Email</span>
                <span class="user-name">Role</span>
                <span class="user-name">Actions</span>
            </li>
        <?php
        while ($post = $results->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <li class="user-item">
                <span class="user-name"><?php echo $post['username']?></span>
                <span class="user-email"><?php echo $post['email']?></span>
                <span class="user-role"><?php echo $post['role']?></span>
                <div class="user-actions">
                    <button class="edit-button"><a href="edit_user.php?id=<?php echo $post['user_id']?>">Edit</a></button>
                    <form method="post" action="delete_user.php">
                        <input type="hidden" name="user_id" value="<?php echo $post['user_id']?>">
                        <input type="submit" class="delete-button" name="delete_user" value="Delete User" onclick="return confirm('Are you sure you want to delete this user?');">
                    </form>
                </div>
            </li>
		<?php } ?>
        </ul>
    </div>
    </main>
</div>


<?php include('shared/footer.php');?>