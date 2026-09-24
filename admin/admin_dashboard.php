<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$admin_name = $_SESSION['admin_name'];
$admin_role = $_SESSION['admin_role'];

// Fetch sold plans stats
$total_sold = 0;
$total_revenue = 0;
$recent_sales = [];

// Adjust query to use purchases table
$result = $conn->query("SELECT COUNT(*) AS total, COALESCE(SUM(amount),0) AS revenue FROM purchases");
if ($result && $row = $result->fetch_assoc()) {
    $total_sold = $row['total'];
    $total_revenue = $row['revenue'];
}

// Fetch last 5 purchases
$recent_query = $conn->query("
    SELECT pu.purchase_id, u.full_name, p.plan_name, pu.amount, pu.purchase_date 
    FROM purchases pu
    JOIN users u ON pu.user_id = u.user_id
    JOIN plans p ON pu.plan_id = p.plan_id
    ORDER BY pu.purchase_date DESC
    LIMIT 5
");
if ($recent_query && $recent_query->num_rows > 0) {
    while ($row = $recent_query->fetch_assoc()) {
        $recent_sales[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Gym Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
/* Dark UI styles */
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
    overflow-y: auto;
    box-shadow: 2px 0 20px rgba(0,0,0,0.7);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
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
.container {
    margin-left:300px; padding:30px;
}
.header h1 { font-size:28px; color:#ff9800; }

.card-container {
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
    gap:20px; margin-top:30px;
}
.card {
    background:rgba(0,0,0,0.65); padding:20px; border-radius:12px;
    text-decoration:none; color:#fff;
    box-shadow:0 5px 15px rgba(0,0,0,0.5);
    transition:transform 0.3s ease;
}
.card:hover { transform:translateY(-5px); }

.stats-container {
    margin-top:30px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}
.stat-card {
    background: rgba(0,0,0,0.65);
    padding:20px; border-radius:12px;
    text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.5);
}
.stat-card h2 { font-size:28px; margin:10px 0; color:#ff9800; }

.recent-sales {
    margin-top:40px;
    background: rgba(0,0,0,0.65);
    border-radius:12px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.5);
}
.recent-sales h2 { margin-bottom:15px; color:#ff9800; }
.recent-sales table { width:100%; border-collapse:collapse; color:#fff; }
.recent-sales th, .recent-sales td {
    padding:10px; text-align:left; border-bottom:1px solid rgba(255,255,255,0.2);
}
.recent-sales th { color:#ff9800; }
</style>
</head>
<body>

<div class="sidebar">
    <div>
        <h2>Gym Admin</h2>
        <ul>
            <li><a href="#" class="active" style="background:#ff9800;color:#000;"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="manage_members.php"><i class="fa-solid fa-users"></i> Members</a></li>
            <li><a href="manage_plans.php"><i class="fa-solid fa-clipboard-list"></i> Plans</a></li>
           
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
        <h1>Welcome, <?= htmlspecialchars($admin_name) ?></h1>
    </div>

    <div class="card-container">
        <a href="manage_members.php" class="card"><h3>Members</h3><p>Manage all gym members</p></a>
        <a href="manage_plans.php" class="card"><h3>Plans</h3><p>Create and edit subscription plans</p></a>

        <a href="manage_trainers.php" class="card"><h3>Trainers</h3><p>Manage trainers and their schedules</p></a>
        <a href="manage_users.php" class="card"><h3>Users</h3><p>Manage platform users</p></a>
        <a href="manage_gallery.php" class="card"><h3>Gallery</h3><p>Upload images and videos</p></a>
        <a href="manage_messages.php" class="card"><h3>Messages</h3><p>Check and respond to messages</p></a>
        <a href="admin_sold_plans.php" class="card"><h3>Sold Plans</h3><p>View sold plans and revenue</p></a>
    </div>

    <!-- Sold Plans Stats -->
    <div class="stats-container">
        <div class="stat-card">
            <h2><?= $total_sold ?></h2>
            <p>Total Plans Sold</p>
        </div>
        
    </div>

    <!-- Recent Sales -->
    <div class="recent-sales">
        <h2>Recent Purchases</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            <?php if (!empty($recent_sales)): ?>
                <?php foreach ($recent_sales as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['full_name']) ?></td>
                        <td><?= htmlspecialchars($sale['plan_name']) ?></td>
                        <td>₹<?= number_format($sale['amount'],2) ?></td>
                        <td><?= date("d M Y", strtotime($sale['purchase_date'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No sales yet</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>

</body>
</html>
