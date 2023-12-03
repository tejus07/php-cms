<?php 
$title = 'Admin';
require_once '../includes/header.php';
require_once '../includes/initialize.php';
require_once 'admin-navbar.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
  header("Location: ./login.php");
  exit();
}
?>
<div class="container-fluid">
  <div class="row">
    <?php
    require 'admin-sidebar.php'
    ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <!-- <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div> -->
      </div>
      </div>
    </main>
  </div>
</div>

<?php
require_once '../includes/footer.php';
?>