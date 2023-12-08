<?php 
include_once 'database.php';

$database = new Database();

$pdo = $database->getConnection();

$categories = [];
$category_sql = "SELECT category_id, category_name FROM Categories";
$category_stmt = $pdo->query($category_sql);

while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[$row['category_id']] = $row['category_name'];
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category_id = isset($_GET['category']) ? $_GET['category'] : 'all';
?>

        
<form class="form-inline" action="searchpage.php" method="GET">
    <div class="form-group mr-2">
        <select name="category" class="form-control">
            <option value="all">All Categories</option>
                <?php foreach ($categories as $categoryId => $categoryName) : ?>
                    <option value="<?php echo $categoryId; ?>" <?php echo $category_id == $categoryId ? 'selected' : '' ?>><?php echo $categoryName; ?></option>
                <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group mr-2">
        <input type="text" name="keyword" class="form-control" placeholder="Enter keyword" value="<?php echo $keyword; ?>">
    </div>
    <button class="btn btn-primary" type="submit">Search</button>
</form>