<?php
include_once '../shared/database.php';

$database = new Database();

$pdo = $database->getConnection();

$results = $pdo->query('SELECT * FROM categories');

?>

<?php include('shared/sidebar.php');?>

<div class="content">
    <main>
    <div class="list-container">
        <h2 class="user-list-title">Categories List</h2>
        <button class="add-new-category-btn edit-button"><a href="add_new_categories.php">Add New</a></button>
        <ul class="category-list">
        <?php
        while ($post = $results->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <li class="user-item-category">
                <span class="user-name"><?php echo $post['title']?></span>
                <div class="user-actions">
                    <button class="edit-button"><a href="edit_category.php?id=<?php echo $post['category_id']?>">Edit</a></button>
                    <form method="post" action="delete_category.php">
                        <input type="hidden" name="category_id" value="<?php echo $post['category_id']?>">
                        <input type="submit" class="delete-button" name="delete_category" value="Delete Category" onclick="return confirm('Delete this pizza category?');">
                    </form>
                </div>
            </li>
		<?php } ?>
        </ul>
    </div>
    </main>
</div>

        
<?php include('shared/footer.php');?>