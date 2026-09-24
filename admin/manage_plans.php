<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle Add Plan
$add_msg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_plan'])) {
    $plan_name = $conn->real_escape_string(trim($_POST['plan_name']));
    $duration = (int)$_POST['duration_months'];
    $price = (float)$_POST['price'];
    $description = $conn->real_escape_string(trim($_POST['description']));

    // Check if plan already exists
    $check = $conn->query("SELECT plan_id FROM plans WHERE plan_name='$plan_name'");
    if ($check->num_rows > 0) {
        $add_msg = "Plan already exists.";
    } else {
        $conn->query("INSERT INTO plans (plan_name, duration_months, price, description) 
                      VALUES ('$plan_name','$duration','$price','$description')");
        $add_msg = "Plan added successfully!";
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM plans WHERE plan_id=$delete_id");
    header("Location: manage_plans.php");
    exit;
}

// Fetch all plans
$plans = $conn->query("SELECT * FROM plans ORDER BY plan_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Plans - Gym Admin</title>
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
.add-plan-form {
    background: rgba(0,0,0,0.6);
    padding: 20px;
    border-radius: 12px;
    margin-bottom:30px;
}
.add-plan-form h2 { color:#ff9800; margin-bottom:15px; }
.add-plan-form input,
.add-plan-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: none;
    background: rgba(255,255,255,0.1);
    color: #fff;
}
.add-plan-form textarea { resize: vertical; height: 80px; }
.add-plan-form input:focus,
.add-plan-form textarea:focus { background: rgba(255,255,255,0.2); outline: none; }
.add-plan-form button {
    padding: 12px 20px;
    background:#ff9800;
    border:none;
    border-radius:8px;
    color:#000;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}
.add-plan-form button:hover { background:#e68900; }
.msg { color:#03e603; margin-bottom:10px; }

/* Plans Table */
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
            <li><a href="manage_plans.php" style="background:#ff9800;color:#000;"><i class="fa-solid fa-clipboard-list"></i> Plans</a></li>
           
            <li><a href="manage_trainers.php"><i class="fa-solid fa-user-tie"></i> Trainers</a></li>
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
        <h1>Manage Plans</h1>
    </div>

    <!-- Add Plan Form -->
    <div class="add-plan-form">
        <h2><i class="fa-solid fa-plus"></i> Add New Plan</h2>
        <?php if($add_msg) echo "<div class='msg'>".htmlspecialchars($add_msg)."</div>"; ?>
        <form method="POST" action="">
            <input type="text" name="plan_name" placeholder="Plan Name" required>
            <input type="number" name="duration_months" placeholder="Duration (Months)" min="1" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <textarea name="description" placeholder="Description"></textarea>
            <button type="submit" name="add_plan"><i class="fa-solid fa-plus"></i> Add Plan</button>
        </form>
    </div>

    <!-- Plans Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Plan Name</th><th>Duration (Months)</th><th>Price</th><th>Description</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($plans && $plans->num_rows > 0): ?>
                <?php while($row = $plans->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['plan_id']) ?></td>
                    <td><?= htmlspecialchars($row['plan_name']) ?></td>
                    <td><?= htmlspecialchars($row['duration_months']) ?></td>
                    <td><?= number_format($row['price'],2) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td>
                        
                        <a href="manage_plans.php?delete_id=<?= $row['plan_id'] ?>" onclick="return confirm('Are you sure to delete this plan?')" class="action-btn delete-btn"><i class="fa-solid fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No plans found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
