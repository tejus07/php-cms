<?php
$title = 'Sign In';
require_once 'includes/header.php';
require_once 'navbar.php';
require 'includes/db.php';

if (isset($_GET['error']) && $_GET['error'] === '1') {
    echo '<p style="color: red;">Invalid username or password. Please try again.</p>';
}
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Sign In</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="./functions/process_login.php" method="post">
                <div class="form-group">
                    <label for="username">Username or Email:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>