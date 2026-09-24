<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE user_id=$delete_id");
    header("Location: manage_users.php");
    exit;
}

// Handle Status Toggle (Active / Inactive)
if (isset($_GET['toggle_id'])) {
    $toggle_id = (int)$_GET['toggle_id'];
    $user = $conn->query("SELECT status FROM users WHERE user_id=$toggle_id")->fetch_assoc();
    if ($user) {
        $new_status = ($user['status'] === 'Active') ? 'Inactive' : 'Active';
        $conn->query("UPDATE users SET status='$new_status' WHERE user_id=$toggle_id");
        header("Location: manage_users.php");
        exit;
    }
}

// Fetch all users
$users = $conn->query("SELECT u.*, p.plan_name 
                       FROM users u 
                       LEFT JOIN plans p ON u.plan_id = p.plan_id 
                       ORDER BY u.user_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users - Gym Admin</title>
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

/* Logout Button */
.logout-container { margin-bottom: 20px; }
.logout-btn {
    width: 80%; padding:10px; margin-bottom:50px;
    background:#ff5252; border:none; border-radius:8px; cursor:pointer;
    color:#fff; font-weight:bold; transition:0.3s;
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
table th, table td { padding:12px 15px; text-align:left; }
table tbody tr { border-bottom:1px solid rgba(255,255,255,0.1); }
table tbody tr:hover { background: rgba(255,255,255,0.1); }

/* Action buttons - ICON ONLY */
.action-btn {
    padding:8px; border-radius:6px; margin-right:5px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:16px; text-decoration:none; color:#fff;
    transition:0.3s; width:32px; height:32px;
}
.edit-btn { background:#03a9f4; }
.edit-btn:hover { background:#0288d1; }
.delete-btn { background:#ff5252; }
.delete-btn:hover { background:#e04848; }
.toggle-btn { background:#ff9800; }
.toggle-btn:hover { background:#e68900; }

.action-btn i { pointer-events:none; }
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
            <li><a href="manage_users.php" style="background:#ff9800;color:#000;"><i class="fa-solid fa-user"></i> Users</a></li>
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
        <h1>Manage Users</h1>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Full Name</th><th>Email</th><th>Phone</th>
                    <th>Gender</th><th>DOB</th><th>Plan</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($users && $users->num_rows > 0): ?>
                <?php while($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['gender']) ?></td>
                    <td><?= htmlspecialchars($row['dob']) ?></td>
                    <td><?= htmlspecialchars($row['plan_name'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['user_id'] ?>" class="action-btn edit-btn" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <a href="manage_users.php?delete_id=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure to delete this user?')" class="action-btn delete-btn" title="Delete"><i class="fa-solid fa-trash"></i></a>
                        <a href="manage_users.php?toggle_id=<?= $row['user_id'] ?>" class="action-btn toggle-btn" title="Toggle Status"><i class="fa-solid fa-toggle-on"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" style="text-align:center;">No users found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
