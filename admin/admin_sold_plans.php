<?php
session_start();
require_once "config.php";

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch sold plans
$query = "
    SELECT p.purchase_id, u.full_name, u.email, pl.plan_name, pl.price, pl.duration_months, 
           p.purchase_date, p.status
    FROM purchases p
    JOIN users u ON p.user_id = u.user_id
    JOIN plans pl ON p.plan_id = pl.plan_id
    ORDER BY p.purchase_date DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sold Plans - Gym Admin</title>
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
.sidebar ul li a.active { background:#ff9800; color:#000; }

/* Logout Button */
.logout-container { margin-bottom: 20px; }
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

/* Table */
.table-container { background: rgba(0,0,0,0.6); border-radius:12px; overflow:hidden; }
table { width:100%; border-collapse: collapse; color:#fff; }
table thead { background:#ff9800; color:#000; }
table th, table td { padding:12px 15px; text-align:center; }
table tbody tr { border-bottom:1px solid rgba(255,255,255,0.1); }
table tbody tr:nth-child(even) { background: rgba(255,255,255,0.05); }
table tbody tr:hover { background: rgba(255,255,255,0.1); }

/* Status colors */
.status-paid { color:lime; font-weight:bold; }
.status-pending { color:orange; font-weight:bold; }
.status-cancelled { color:red; font-weight:bold; }
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
            <li><a href="manage_trainers.php"><i class="fa-solid fa-user-tie"></i> Trainers</a></li>
            <li><a href="manage_gallery.php"><i class="fa-solid fa-image"></i> Gallery</a></li>
            <li><a href="manage_users.php"><i class="fa-solid fa-user"></i> Users</a></li>
            <li><a href="manage_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a></li>
            <li><a href="admin_sold_plans.php" class="active"><i class="fa-solid fa-sack-dollar"></i> Sold Plans</a></li>
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
        <h1>Sold Membership Plans</h1>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Plan</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['purchase_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['plan_name']); ?></td>
                        <td>₹<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['duration_months']; ?> Month(s)</td>
                        <td><?php echo date("d M Y, h:i A", strtotime($row['purchase_date'])); ?></td>
                        <td class="status-<?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" style="text-align:center;">No plans sold yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
