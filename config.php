<?php
// Database configuration - Update with your credentials
$host = 'localhost';
$dbname = 'online_exam';
$username = 'root';  // Default for XAMPP/WAMP
$password = '';      // Default for XAMPP/WAMP (change if needed)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Start session for admin login
session_start();
?>
