<?php
// Database configuration
$host = "localhost";      // XAMPP runs on localhost
$user = "root";           // Default MySQL user in XAMPP
$pass = "";               // Default MySQL password (empty in XAMPP)
$db   = "gym_management"; // Our database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: Set character encoding
$conn->set_charset("utf8");

?>
