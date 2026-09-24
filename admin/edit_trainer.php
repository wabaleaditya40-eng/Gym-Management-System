<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_trainers.php");
    exit;
}

$trainer_id = (int)$_GET['id'];

// Fetch trainer data
$trainer = $conn->query("SELECT * FROM trainers WHERE trainer_id=$trainer_id")->fetch_assoc();
if (!$trainer) {
    die("Trainer not found.");
}

// Update trainer details
if (isset($_POST['update'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];

    $stmt = $conn->prepare("UPDATE trainers SET full_name=?, email=?, phone=?, specialization=? WHERE trainer_id=?");
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $specialization, $trainer_id);
    $stmt->execute();

    header("Location: manage_trainers.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Trainer</title>
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
form input {
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
    <h2>Edit Trainer</h2>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($trainer['full_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($trainer['email']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($trainer['phone']) ?>" required>

        <label>Specialization</label>
        <input type="text" name="specialization" value="<?= htmlspecialchars($trainer['specialization']) ?>" required>

        <button type="submit" name="update">Update Trainer</button>
    </form>
    <a href="manage_trainers.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>
</body>
</html>
