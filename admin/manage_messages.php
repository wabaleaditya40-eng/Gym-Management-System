<?php
session_start();
require_once "config.php"; // DB connection

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM messages WHERE id=$delete_id");
    header("Location: manage_messages.php");
    exit();
}

// Fetch messages
$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Messages - Gym Admin</title>
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

/* Logout Button at bottom but slightly above */
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
table th, table td { padding:12px 15px; text-align:left; }
table tbody tr { border-bottom:1px solid rgba(255,255,255,0.1); }
table tbody tr:nth-child(even) { background: rgba(255,255,255,0.05); }
table tbody tr:hover { background: rgba(255,255,255,0.1); }

/* Action buttons */
.action-btn {
    padding:6px 12px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:14px;
    transition:0.3s;
}
.delete-btn {
    background:#ff5252;
    color:#fff;
}
.delete-btn:hover {
    background:#e04848;
}
</style>
<script>
function confirmDelete(id){
    if(confirm("Are you sure you want to delete this message?")){
        window.location.href = "manage_messages.php?delete_id=" + id;
    }
}
</script>
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
            <li><a href="manage_messages.php" class="active"><i class="fa-solid fa-envelope"></i> Messages</a></li>
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
        <h1>User Messages</h1>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($messages->num_rows > 0){
                    $i = 1;
                    while($row = $messages->fetch_assoc()){
                        echo "<tr>
                                <td>".$i++."</td>
                                <td>".htmlspecialchars($row['name'])."</td>
                                <td>".htmlspecialchars($row['email'])."</td>
                                <td>".htmlspecialchars($row['message'])."</td>
                                <td>".$row['created_at']."</td>
                                <td>
                                    <button class='action-btn delete-btn' onclick='confirmDelete(".$row['id'].")'>
                                        <i class='fa fa-trash'></i> Delete
                                    </button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No messages yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
