<?php
session_start();
include "config.php"; // DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert into messages table
    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "✅ Your message has been sent successfully!";
    } else {
        $_SESSION['error'] = "❌ Something went wrong. Please try again later.";
    }

    // Redirect back to contact.php
    header("Location: contact.php");
    exit();
} else {
    // If someone tries to access this page directly
    header("Location: contact.php");
    exit();
}
?>
