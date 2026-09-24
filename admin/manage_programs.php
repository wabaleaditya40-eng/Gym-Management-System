<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle Add Program
$add_msg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_program'])) {
    $program_name   = trim($_POST['program_name']);
    $description    = trim($_POST['description']);
    $duration_weeks = (int)$_POST['duration_weeks'];
    $trainer_id     = !empty($_POST['trainer_id']) ? (int)$_POST['trainer_id'] : NULL;

    // Check if program exists
    $check = $conn->prepare("SELECT program_id FROM programs WHERE program_name = ?");
    $check->bind_param("s", $program_name);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $add_msg = "❌ Program already exists.";
    } else {
        // If trainer_id is given, make sure trainer exists
        if ($trainer_id !== NULL) {
            $tcheck = $conn->prepare("SELECT trainer_id FROM trainers WHERE trainer_id = ?");
            $tcheck->bind_param("i", $trainer_id);
            $tcheck->execute();
            $tresult = $tcheck->get_result();
            if ($tresult->num_rows === 0) {
                $add_msg = "⚠️ Invalid trainer selected!";
                $trainer_id = NULL;
            }
        }

        // Insert program safely
        if ($trainer_id === NULL) {
            $stmt = $conn->prepare("INSERT INTO programs (program_name, description, duration_weeks, trainer_id) VALUES (?, ?, ?, NULL)");
            $stmt->bind_param("ssi", $program_name, $description, $duration_weeks);
        } else {
            $stmt = $conn->prepare("INSERT INTO programs (program_name, description, duration_weeks, trainer_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $program_name, $description, $duration_weeks, $trainer_id);
        }

        if ($stmt->execute()) {
            $add_msg = "✅ Program added successfully!";
        } else {
            $add_msg = "❌ Error adding program: " . $conn->error;
        }
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM programs WHERE program_id=$delete_id");
    header("Location: manage_programs.php");
    exit;
}

// Fetch programs
$programs = $conn->query("SELECT p.*, t.full_name AS trainer_name 
                          FROM programs p 
                          LEFT JOIN trainers t ON p.trainer_id = t.trainer_id 
                          ORDER BY p.program_id DESC");

// Fetch trainers for Add Program form
$trainers = $conn->query("SELECT * FROM trainers WHERE status='Active' ORDER BY full_name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Programs - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #121212;
            color: #fff;
        }
        header {
            background: #1f1f1f;
            padding: 15px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #00ffcc;
            box-shadow: 0 2px 8px rgba(0,0,0,0.7);
        }
        .container {
            width: 85%;
            margin: 30px auto;
            background: #1c1c1c;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.6);
            animation: fadeIn 0.8s ease-in-out;
        }
        h2 {
            color: #00ffcc;
            margin-bottom: 15px;
        }
        form {
            margin-bottom: 25px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: none;
            border-radius: 10px;
            background: #2a2a2a;
            color: #fff;
        }
        button {
            background: #00ffcc;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s;
        }
        button:hover {
            transform: scale(1.05);
            background: #00e6b8;
        }
        .msg {
            margin: 10px 0;
            padding: 10px;
            border-radius: 10px;
            background: #2a2a2a;
            color: #ffcc00;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #222;
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #333;
        }
        th {
            background: #00ffcc;
            color: #000;
        }
        tr:hover {
            background: #2a2a2a;
        }
        a {
            color: #ff4444;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
<header>
    Manage Programs
</header>

<div class="container">
    <h2>Add New Program</h2>
    <?php if($add_msg): ?>
        <div class="msg"><?= $add_msg; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="program_name" placeholder="Program Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="duration_weeks" placeholder="Duration (weeks)" required>
        <select name="trainer_id">
            <option value="">-- Select Trainer (optional) --</option>
            <?php while($t = $trainers->fetch_assoc()): ?>
                <option value="<?= $t['trainer_id']; ?>"><?= $t['full_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="add_program"><i class="fa fa-plus"></i> Add Program</button>
    </form>

    <h2>Programs List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Program Name</th>
            <th>Description</th>
            <th>Duration (Weeks)</th>
            <th>Trainer</th>
            <th>Action</th>
        </tr>
        <?php while($p = $programs->fetch_assoc()): ?>
        <tr>
            <td><?= $p['program_id']; ?></td>
            <td><?= htmlspecialchars($p['program_name']); ?></td>
            <td><?= htmlspecialchars($p['description']); ?></td>
            <td><?= $p['duration_weeks']; ?></td>
            <td><?= $p['trainer_name'] ? $p['trainer_name'] : 'Unassigned'; ?></td>
            <td>
                <a href="manage_programs.php?delete_id=<?= $p['program_id']; ?>" onclick="return confirm('Delete this program?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
