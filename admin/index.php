<?php
$title = 'Admin';
require_once 'includes/header.php';
require_once '../includes/initialize.php';
require_once 'admin-navbar.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (
  !isset($_SESSION['user_id']) || empty($_SESSION['user_id'])
  || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'
):
  header("Location: ./login.php");
  exit();
endif;

try {
  $stmt = $pdo->prepare("SELECT COUNT(*) AS user_count FROM users");
  $stmt->execute();
  $user_count = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];
} catch (PDOException $e) {
  $user_count = 0;
}

try {
  $stmt = $pdo->prepare("SELECT COUNT(*) AS brand_count FROM brands");
  $stmt->execute();
  $brand_count = $stmt->fetch(PDO::FETCH_ASSOC)['brand_count'];
} catch (PDOException $e) {
  $brand_count = 0;
}

try {
  $phone_counts = [];
  $stmt = $pdo->prepare("SELECT id, name FROM brands");
  $stmt->execute();
  $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($brands as $brand) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS phone_count FROM phones WHERE brand_id = :brand_id");
    $stmt->bindParam(':brand_id', $brand['id']);
    $stmt->execute();
    $phone_counts[$brand['name']] = $stmt->fetch(PDO::FETCH_ASSOC)['phone_count'];
  }
} catch (PDOException $e) {
  $phone_counts = [];
}

?>
<div class="container-fluid">
  <div class="row">
    <?php
    require 'admin-sidebar.php'
      ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Users</h5>
              <p class="card-text">
                <?php echo $user_count; ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Brands</h5>
              <p class="card-text">
                <?php echo $brand_count; ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Phones by Brand</h5>
              <ul class="list-group">
                <?php foreach ($phone_counts as $brand_name => $phone_count): ?>
                  <li class="list-group-item">
                    <?php echo $brand_name . ': ' . $phone_count; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php
require_once 'includes/footer.php';
?>