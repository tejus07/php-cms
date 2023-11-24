<?php 
include_once("database.php");

$database = new Database();

$pdo = $database->getConnection();

$stmt = $pdo->query("SELECT * FROM categories");

?>
<nav>
    <ul class="navbar">
        <li><a href="./">Home</a></li>
        <li class="dropdown">
            <a class="dropbtn">Categories</a>
            <div class="dropdown-content">
                <?php while($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <a href="./open_category.php?id=<?php echo $data['category_id'] ?>"><?php echo $data['title'] ?></a>
                <?php } ?>
            </div>
        </li>
        <li><a>About</a></li>
        <li><a>Contact</a></li>
        <li><a href="admin/login.php">Login</a></li>
    </ul>
</nav>