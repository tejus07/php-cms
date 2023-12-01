<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RentAndGo - Your Car Rental Solution</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1 class="site-logo"><a href="index.php">RentAndGo</a></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="vehicles-listing.php">Vehicles</a></li>
                <li class="dropdown">
                    <a class="dropbtn">Brands</a>
                    <div class="dropdown-content">
                        <?php
                        try {
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "rentandgodb";

                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT * FROM brands");
                            $stmt->execute();
                            $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($brands) > 0):
                                foreach ($brands as $brand):
                                    echo "<a href='brands.php?brand_id=" . $brand["brand_id"] . "'>" . $brand["brand_name"] . "</a>";
                                endforeach;
                            else:
                                echo "0 results";
                            endif;
                        } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }
                        ?>
                    </div>
                </li>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="admin/login.php">Login</a></li>
                <li>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "rentandgodb";

                    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                    $categories = [];
                    $category_sql = "SELECT category_id, category_name FROM Categories";
                    $category_stmt = $pdo->query($category_sql);

                    while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $categories[$row['category_id']] = $row['category_name'];
                    }

                    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                    $category_id = isset($_GET['category']) ? $_GET['category'] : 'all';
                    ?>

                    <form class="searchbar" action="searchpage.php" method="GET">
                        <div class="search-category-container">
                            <select name="category">
                                <option value="all">All Categories</option>
                                <?php foreach ($categories as $categoryId => $categoryName): ?>
                                    <option value="<?php echo $categoryId; ?>" <?php echo $category_id == $categoryId ? 'selected' : '' ?>>
                                        <?php echo $categoryName; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="partition-bar"></div>
                        <div class="search-bar-container">
                            <input type="text" name="keyword" placeholder="Enter keyword"
                                value="<?php echo $keyword; ?>">
                        </div>
                        <button class="search-btn" type="submit">Search</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rentandgodb";

    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


    function searchPages($keyword, $category = null, $limit = 10, $offset = 0)
    {
        global $pdo;

        $sql = "SELECT * FROM vehicles WHERE (model LIKE :keyword OR description LIKE :keyword)";
        $params = array(':keyword' => '%' . $keyword . '%');

        if ($category !== null && $category != 'all') {
            $sql .= " AND category_id = :category";
            $params[':category'] = $category;
        }

        $sql .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array();
        }
    }

    function getTotalCount($keyword, $category = null)
    {
        global $pdo;

        $sql = "SELECT COUNT(*) AS total FROM vehicles WHERE (model LIKE :keyword OR description LIKE :keyword)";
        $params = array(':keyword' => '%' . $keyword . '%');

        if ($category !== null && $category != 'all') {
            $sql .= " AND category_id = :category";
            $params[':category'] = $category;
        }

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }


    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : 'all';

    $totalCount = getTotalCount($keyword, $category);

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 5;
    $offset = ($currentPage - 1) * $perPage;

    $searchResults = searchPages($keyword, $category, $perPage, $offset);

    ?>

    <main>
        <h1>Search Results</h1>
        <small>Showing <strong>"
                <?php echo $totalCount; ?>"
            </strong> results.</small><br><br>
        <?php
        if (empty($searchResults)) {
            echo '<center><h1>Sorry no results were found for the query</h1></center>';
        } else {
            foreach ($searchResults as $post) {
                $date = date_create($post['created_at']);
                $message = str_replace("\n\r", "<br><br>", $post['description']);
                ?>
                <div class="col-md-10 blogShort">
                    <img src="<?php echo $post['image_url'] ?>" width="250">
                    <h3><a href="view_post.php?id=<?php echo $post['vehicle_id']; ?>">
                            <?php echo $post['model']; ?>
                        </a></h3>
                    <em><strong>Published on</strong>:
                        <?php echo date_format($date, "d F Y"); ?>
                    </em>
                    <em><strong>Category:</strong> <a href="#" target="_blank">
                            <?php echo $post['difficulty_level']; ?>
                        </a></em>
                    <br><br>
                    <article>
                        <p>
                            <?php echo $message; ?>
                        </p>
                    </article>
                    <a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">READ MORE</a>
                </div>
            <?php }
        }
        $totalPages = ceil($totalCount / $perPage);
        if ($totalPages > 1) {
            echo '<center><div class="pagination">';
            if ($currentPage > 1) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . ($currentPage - 1) . '" class="page-item prev-link">Prev</a>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . $i . '" class="page-item ' . (($currentPage == $i) ? 'active' : '') . '">' . $i . '</a>';
            }

            if ($currentPage < $totalPages) {
                echo '<a href="searchpage.php?keyword=' . urlencode($keyword) . '&category=' . urlencode($category) . '&page=' . ($currentPage + 1) . '" class="page-item next-link">Next</a>';
            }
            echo '</div></center>';
        } ?>
    </main>
    <footer>
        <p>&copy; 2023 RentAndGo. All rights reserved.</p>
    </footer>
</body>

</html>