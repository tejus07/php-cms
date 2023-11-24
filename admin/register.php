<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/login_register.css">
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Register</h2>
        <form class="form" method="post" action="register_process.php">
            <div class="input-container">
                <label for="username">Username:</label>
                <input class="input-field" type="text" name="username" id="username" required>
            </div>
            <div class="input-container">
                <label for="email">Email:</label>
                <input class="input-field" type="email" name="email" id="email" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input class="input-field" type="password" name="password" id="password" required>
            </div>
            <button class="form-button" type="submit">Register</button>
        </form>
        <p class="form-link">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
