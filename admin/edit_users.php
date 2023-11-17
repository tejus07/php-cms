<?php 
include_once '../shared/database.php';

$database = new Database();
$pdo = $database->getConnection();

$user_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$query = "SELECT * FROM users WHERE user_id = :user_id";

$stmt1 = $pdo->prepare($query);
$stmt1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt1->execute();
$data = $stmt1->fetch(PDO::FETCH_ASSOC);

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
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
    $user_id = $_GET['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $is_admin = $_POST['is_admin'];

    try {
        // Update the recipe in the database
        $sql = "UPDATE users SET 
            username = :username,
            password = :password,
            email = :email,
            is_admin = :is_admin
            WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':is_admin', $is_admin);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        echo "User updated successfully!";
        header("Location: users.php");
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
        <h2 class="add-recipe-title">Edit User Details</h2>
        <form class="recipe-form" action="edit_users.php?id=<?php echo $data['user_id']?>" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-input" value="<?php echo $data['username']?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" class="form-input" value="<?php echo $data['password']?>" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" class="form-input" value="<?php echo $data['email']?>" required>
        </div>
        <div class="form-group">
            <label for="is_admin">Admin access:</label>
            <div class="form-group-radio">
            <input type="radio" id="admin" name="is_admin" class="form-input" value="1" <?php if ($data['is_admin'] == 1) echo 'checked'; ?>>
            <label for="admin">Admin</label>
            <input type="radio" id="user" name="is_admin" class="form-input" value="0" <?php if ($data['is_admin'] == 0) echo 'checked'; ?>>
            <label for="user">User</label>
            </div>
        </div>      
            <input type="submit" value="Save" class="submit-button">
        </form>
    </div>

<?php include('shared/footer.php');?>