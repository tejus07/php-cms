<?php
$current_page = basename($_SERVER['PHP_SELF']);
$pages = [
  'index.php' => 'Dashboard',
  'brands.php' => 'Brands',
  'phones.php' => 'Phones',
  'users.php' => 'Users',
];
echo var_dump($current_page);
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
        <?php
            foreach ($pages as $url => $label) {
                $class = ($current_page === $url) ? 'active' : '';
                echo '<li class="nav-item">';
                echo '<a class="nav-link ' . $class . '" href="' . $url . '">';
                echo '<span data-feather="home"></span>';
                echo $label;
                echo '</a>';
                echo '</li>';
            }
            ?>
        </ul>
      </div>
    </nav>