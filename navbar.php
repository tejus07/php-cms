<?php
require 'db.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM brands");
    $stmt->execute();

    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$currentFilePath = $_SERVER['SCRIPT_FILENAME'];
$directoryPath = dirname($currentFilePath);
$parts = explode('/', $directoryPath);
$projectName = $parts[3];
$search = isset($_GET['search']) ? $_GET['search'] : '';

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo '/' . $projectName . '/' ?>index.php">Phone Specs Hub</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li> -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu">
                    <?php
                    if (count($brands) > 0) {
                        foreach ($brands as $brand) {
                            echo "<a class=\"dropdown-item\" href=\"/". $projectName."/brands.php?id=" . $brand['id'] . "\">" . $brand['name'] . "</a>";
                        }
                    } else {
                        echo "No records found.";
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    User Actions
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/<?php echo $projectName; ?>/user/phones.php">My Posts</a>
                    <a class="dropdown-item" href="/<?php echo $projectName; ?>/user/info.php">My Info</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="search-results.php">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
            <button class="btn btn-outline-success my-2 mr-sm-2" type="submit">Search</button>
        </form>

        <!-- Session check and buttons -->
        <?php session_start();
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $logoutPath = '/' . $projectName . '/index.php?action=logout';
            echo '<a href="' . $logoutPath . '" class="btn btn-primary my-2 mr-sm-2">Log out</a>';
        } else {
            echo '<a href="/' . $projectName . '/sign-in.php" class="btn btn-primary my-2 mr-sm-2">Sign In</a>
            <a href="/' . $projectName . '/sign-up.php" class="btn btn-primary my-2 mr-sm-2">Sign Up</a>';
        }
        ?>
    </div>
</nav>