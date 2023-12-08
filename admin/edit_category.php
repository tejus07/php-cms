<?php 
include_once '../shared/database.php';

$database = new Database();
$pdo = $database->getConnection();

$category_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$query = "SELECT * FROM categories WHERE category_id = :category_id";

$stmt1 = $pdo->prepare($query);
$stmt1->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt1->execute();
$data = $stmt1->fetch(PDO::FETCH_ASSOC);

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
if ($data === false) {
    echo "Category not found!";
    exit();
}

$users = [];
$user_sql = "SELECT user_id, username FROM users";
$user_stmt = $pdo->query($user_sql);

while ($row = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
    $users[$row['user_id']] = $row['username'];
}

$categories = [];
$category_sql = "SELECT category_id, title FROM categories";
$category_stmt = $pdo->query($category_sql);

while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[$row['category_id']] = $row['title'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from the form
    $category_id = $_GET['id'];
    $title = $_POST['title'];

    try {
        // Update the category in the database
        $sql = "UPDATE categories SET 
            title = :title
            WHERE category_id = :category_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':category_id', $category_id);

        $stmt->execute();

        echo "category updated successfully!";
        header("Location: categories.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <link rel="stylesheet" href="css/admin-panel.css">
    <title>Admin Panel</title>
</head>
<body>
<?php include('shared/sidebar.php');?>

    <div class="add-recipe-container">
        <h2 class="add-category-title">Edit Pizza Category</h2>
        <form class="category-form" action="edit_category.php?id=<?php echo $data['category_id']?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-input" value="<?php echo $data['title']?>" required>
        </div>
            <input type="submit" value="Add category" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>