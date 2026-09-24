<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle Add Trainer
$add_msg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_trainer'])) {
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $specialization = $conn->real_escape_string(trim($_POST['specialization']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $status = $_POST['status'] ?? 'Active';

    // Check if email exists
    $check = $conn->query("SELECT trainer_id FROM trainers WHERE email='$email'");
    if ($check->num_rows > 0) {
        $add_msg = "Email already exists.";
    } else {
        $conn->query("INSERT INTO trainers (full_name, specialization, phone, email, status) 
                      VALUES ('$full_name','$specialization','$phone','$email','$status')");
        $add_msg = "Trainer added successfully!";
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM trainers WHERE trainer_id=$delete_id");
    header("Location: manage_trainers.php");
    exit;
}

// Fetch trainers
$trainers = $conn->query("SELECT * FROM trainers ORDER BY trainer_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Trainers - Gym Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body {
    margin:0;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(120deg,#0f0c29,#302b63,#24243e);
    color:#fff;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: rgba(0,0,0,0.85);
    backdrop-filter: blur(10px);
    padding: 30px 20px;
    position: fixed;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 2px 0 20px rgba(0,0,0,0.7);
    z-index: 10;
}
.sidebar h2 { text-align:center; margin-bottom:30px; color:#ff9800; }
.sidebar ul { list-style:none; padding:0; margin:0; }
.sidebar ul li { margin-bottom:20px; }
.sidebar ul li a {
    color:#fff; text-decoration:none; display:flex; align-items:center; padding:10px 15px;
    border-radius:8px; transition:0.3s;
}
.sidebar ul li a i { margin-right:12px; width:20px; text-align:center; }
.sidebar ul li a:hover { background:#ff9800; color:#000; }

/* Logout Button at bottom but slightly above */
.logout-container {
    margin-bottom: 20px; /* gap from bottom */
}
.logout-btn {
    width: 80%;
    padding:10px;
    margin-bottom:50px;
    background:#ff5252;
    border:none;
    border-radius:8px;
    cursor:pointer;
    color:#fff;
    font-weight:bold;
    transition:0.3s;
}
.logout-btn:hover { background:#e04848; }
/* Container */
.container { padding:30px; margin-left:300px; }

/* Header */
.header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
.header h1 { color:#ff9800; }

/* Form */
.add-trainer-form {
    background: rgba(0,0,0,0.6);
    padding: 20px;
    border-radius: 12px;
    margin-bottom:30px;
}
.add-trainer-form h2 { color:#ff9800; margin-bottom:15px; }
.add-trainer-form input,
.add-trainer-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: none;
    background: rgba(255,255,255,0.1);
    color: #fff;
}
.add-trainer-form input:focus,
.add-trainer-form select:focus { background: rgba(255,255,255,0.2); outline: none; }
.add-trainer-form button {
    padding: 12px 20px;
    background:#ff9800;
    border:none;
    border-radius:8px;
    color:#000;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}
.add-trainer-form button:hover { background:#e68900; }
.msg { color:#03e603; margin-bottom:10px; }

/* Trainers Table */
.table-container { background: rgba(0,0,0,0.6); border-radius:12px; overflow:hidden; }
table { width:100%; border-collapse: collapse; color:#fff; }
table thead { background:#ff9800; color:#000; }
table th, table td { padding:12px 15px; text-align:left; }
table tbody tr { border-bottom:1px solid rgba(255,255,255,0.1); }
table tbody tr:hover { background: rgba(255,255,255,0.1); }
a.action-btn {
    padding:6px 12px;
    margin-right:5px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    color:#fff;
}
a.edit-btn { background:#03a9f4; }
a.edit-btn:hover { background:#0288d1; }
a.delete-btn { background:#ff5252; }
a.delete-btn:hover { background:#e04848; }
</style>
</head>
<body>

<div class="sidebar">
    <div>
        <h2>Gym Admin</h2>
        <ul>
            <li><a href="admin_dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="manage_members.php"><i class="fa-solid fa-users"></i> Members</a></li>
            <li><a href="manage_plans.php"><i class="fa-solid fa-clipboard-list"></i> Plans</a></li>
            
            <li><a href="manage_trainers.php" style="background:#ff9800;color:#000;"><i class="fa-solid fa-user-tie"></i> Trainers</a></li>
            <li><a href="manage_gallery.php"><i class="fa-solid fa-image"></i> Gallery</a></li>
            <li><a href="manage_users.php"><i class="fa-solid fa-user"></i> Users</a></li>
            <li><a href="manage_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a></li>
             <li><a href="admin_sold_plans.php"><i class="fa-solid fa-sack-dollar"></i> Sold Plans</a></li>
        </ul>
    </div>
    <div class="logout-container">
        <form method="POST" action="logout.php">
            <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="header">
        <h1>Manage Trainers</h1>
    </div>

    <!-- Add Trainer Form -->
    <div class="add-trainer-form">
        <h2><i class="fa-solid fa-plus"></i> Add New Trainer</h2>
        <?php if($add_msg) echo "<div class='msg'>".htmlspecialchars($add_msg)."</div>"; ?>
        <form method="POST" action="">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="text" name="specialization" placeholder="Specialization">
            <input type="text" name="phone" placeholder="Phone">
            <input type="email" name="email" placeholder="Email" required>
            <select name="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <button type="submit" name="add_trainer"><i class="fa-solid fa-plus"></i> Add Trainer</button>
        </form>
    </div>

    <!-- Trainers Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Full Name</th><th>Specialization</th><th>Phone</th><th>Email</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($trainers && $trainers->num_rows > 0): ?>
                <?php while($row = $trainers->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['trainer_id']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['specialization']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <a href="edit_trainer.php?id=<?= $row['trainer_id'] ?>" class="action-btn edit-btn"><i class="fa-solid fa-pen"></i> Edit</a>
                        <a href="manage_trainers.php?delete_id=<?= $row['trainer_id'] ?>" onclick="return confirm('Are you sure to delete this trainer?')" class="action-btn delete-btn"><i class="fa-solid fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align:center;">No trainers found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
