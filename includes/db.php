<?php
$dbHost = 'localhost'; 
$dbName = 'phone_specs_hub'; // Update with your database name
$dbUser = 'root'; // Update with your database username
$dbPassword = ''; // Update with your database password

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("set names utf8");
} catch (PDOException $e) {
    echo 'failed';
    die("Database connection failed: " . $e->getMessage());
}
