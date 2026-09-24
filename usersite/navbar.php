<?php
session_start(); // start session if not already started
?>

<nav style="background:#1a1a1a;color:white;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;box-shadow:0 2px 8px rgba(0,0,0,0.6);">
    <a href="index.php" style="color:yellow;font-size:22px;font-weight:bold;text-decoration:none;">🏋️ FitLife Gym</a>
    <ul style="list-style:none;display:flex;gap:20px;margin:0;padding:0;">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="services.php" style="color:yellow;font-weight:bold;">Services</a></li>
        <li><a href="plans.php">Plans</a></li>
        <li><a href="trainers.php">Trainers</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li>
            <?php
            if(isset($_SESSION['user_id'])) {
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
            ?>
        </li>
    </ul>
</nav>
