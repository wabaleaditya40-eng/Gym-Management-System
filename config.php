<?php
$host = "localhost";
$user = "root";  // change if different
$pass = "";      // change if password set in phpMyAdmin
$db   = "gym_management";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>