<?php
$title = 'Info';
require_once 'includes/header.php';
require 'includes/db.php';
require 'navbar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * 
    FROM users  
    WHERE users.id = :user_id");

    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

<div class="container-fluid px-5 mt-4">
  <div class="row">
    <div class="col">
      <h3 class="mb-4">User Information</h3>
      <div class="card my-4">
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>ID:</strong> <?php echo $data[0]['id']; ?></li>
            <li class="list-group-item"><strong>Username:</strong> <?php echo $data[0]['username']; ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo $data[0]['email']; ?></li>
            <li class="list-group-item"><strong>Role:</strong> <?php echo $data[0]['role'] === 1 ? 'admin' : 'user'; ?></li>
            <li class="list-group-item"><strong>Created At:</strong> <?php echo $data[0]['created_at']; ?></li>
            <li class="list-group-item"><strong>Updated At:</strong> <?php echo $data[0]['updated_at']; ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
require_once 'includes/footer.php';
?>