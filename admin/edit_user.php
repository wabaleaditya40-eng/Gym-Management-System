<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit;
}

$user_id = (int)$_GET['id'];

// Fetch user data
$user = $conn->query("SELECT * FROM users WHERE user_id=$user_id")->fetch_assoc();
if (!$user) {
    die("User not found.");
}

// Update user details
if (isset($_POST['update'])) {
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $gender    = $_POST['gender'];
    $dob       = $_POST['dob'];
    $status    = $_POST['status'];

    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=?, gender=?, dob=?, status=? WHERE user_id=?");
    $stmt->bind_param("ssssssi", $full_name, $email, $phone, $gender, $dob, $status, $user_id);
    $stmt->execute();

    header("Location: manage_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit User</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body {
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(120deg,#0f0c29,#302b63,#24243e);
    color:#fff;
}
.container {
    max-width: 500px;
    margin: 60px auto;
    background: rgba(0,0,0,0.7);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.6);
}
.container h2 {
    text-align: center;
    color: #ff9800;
    margin-bottom: 20px;
}
form label {
    display:block;
    margin:10px 0 5px;
    font-weight:bold;
}
form input, form select {
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    margin-bottom:15px;
}
button {
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#ff9800;
    color:#000;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}
button:hover { background:#e68900; }
.back-btn {
    display:block;
    text-align:center;
    margin-top:15px;
    color:#ff9800;
    text-decoration:none;
}
</style>
</head>
<body>
<div class="container">
    <h2>Edit User</h2>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="Male" <?= ($user['gender']=="Male"?"selected":"") ?>>Male</option>
            <option value="Female" <?= ($user['gender']=="Female"?"selected":"") ?>>Female</option>
        </select>

        <label>Date of Birth</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($user['dob']) ?>" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Active" <?= ($user['status']=="Active"?"selected":"") ?>>Active</option>
            <option value="Inactive" <?= ($user['status']=="Inactive"?"selected":"") ?>>Inactive</option>
        </select>

        <button type="submit" name="update">Update User</button>
    </form>
    <a href="manage_users.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>
</body>
</html>
