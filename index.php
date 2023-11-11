<?php
$title = 'Home';
require_once 'includes/header.php';
require 'db.php';
require 'navbar.php';
?>

<div class="container">
    <div class="row">
        <div class="col">
            <?php require_once 'phone-list.php' ?>
        </div>

    </div>

</div>

<?php
require_once 'includes/footer.php';
?>