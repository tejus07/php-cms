<?php
include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$results = $pdo->query('SELECT * FROM categories');

?>

<?php include('shared/sidebar.php');?>

<div class="content">
    <header>
        <h2>Category Page</h2>
        <a href="logout.php">Logout</a>
    </header>
    <main>
    <div class="user-list-container">
        <h2 class="user-list-title">Categories List</h2>
        <button class="add-new-recipe-btn edit-button"><a href="add_new_category.php">Add New</a></button>
        <ul class="user-list">
        <?php
        while ($post = $results->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <li class="user-item">
                <span class="user-name"><?php echo $post['category_name']?></span>
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