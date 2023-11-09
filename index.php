<?php 
$title = 'Home';
require_once 'includes/header.php';
?>
<?php
    require 'db.php';

    try {
        $stmt = $pdo->prepare("SELECT * FROM brands");
        $stmt->execute();

        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Phone Specs Hub</a>
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
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" 
                        aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu">
                    <?php
                    if (count($brands) > 0) {
                        foreach ($brands as $brand) {
                            echo "<a class=\"dropdown-item\" href=\"#\">" . $brand['name'] . "</a>";
                        }
                    } 
                    else {
                        echo "No records found.";
                    }
                    ?>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    
    <div class="container">
        <div class="row">
            <div class="col">
            <h1>Hello, world!</h1>
            </div>
        
        </div>
   
    </div>

    <?php 
require_once 'includes/footer.php';
?>
