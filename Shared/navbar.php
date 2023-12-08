<?php 
include_once("database.php");

$database = new Database();

$pdo = $database->getConnection();

$stmt = $pdo->query("SELECT * FROM categories");

?>
<nav class="navbar navbar-expand">
    <ul class="navbar-nav">
        <li class="nav-item"><a href="./" class="nav-link">Home</a></li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <a class="dropdown-item" href="./open_category.php?id=<?php echo $data['category_id'] ?>"><?php echo $data['category_name'] ?></a>
                    <?php } ?>
                </div>
        </li>
        <li class="nav-item"><a href="about_us.php" class="nav-link">About</a></li>
        <li class="nav-item"><a href="admin/login.php" class="nav-link"><?php echo (empty($_SESSION['user_id'])) ? 'Login/Sign up' : 'Dashboard';?></a></li>
        <?php if(!empty($_SESSION['user_id'])) { ?>
            <li class="nav-item"><a href="admin/logout.php" class="nav-link">Logout</a></li><?php 
        }?>
    </ul>
</nav>