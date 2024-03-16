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
        <li class="nav-item"><a href="about_us.php" class="nav-link">About Us</a></li>
        <li class="nav-item"><a href="admin/login.php" class="nav-link"><?php echo (empty($_SESSION['user_id'])) ? 'Login/Sign up' : '';?></a></li>
        <?php if(!empty($_SESSION['user_id'])) { ?>
            <li class="nav-item"><a href="admin/logout.php" class="nav-link">Logout</a></li><?php 
        }?>
    </ul>
</nav>