<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$admin_name = $_SESSION['admin_name'];
$admin_role = $_SESSION['admin_role'];

// Handle Image Upload
$msg = '';
if (isset($_POST['upload_image'])) {
    $target_dir = "uploads/gallery/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        $msg = "File is not an image.";
    } elseif ($_FILES["image"]["size"] > 5*1024*1024) {
        $msg = "File is too large (max 5MB).";
    } elseif (!in_array($imageFileType, ['jpg','jpeg','png','gif'])) {
        $msg = "Only JPG, JPEG, PNG & GIF files are allowed.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $conn->query("INSERT INTO gallery (image_name) VALUES ('".$conn->real_escape_string($target_file)."')");
            $msg = "Image uploaded successfully!";
        } else {
            $msg = "Error uploading the file.";
        }
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $img_res = $conn->query("SELECT image_name FROM gallery WHERE gallery_id=$delete_id")->fetch_assoc();
    if ($img_res) {
        if(file_exists($img_res['image_name'])) unlink($img_res['image_name']);
        $conn->query("DELETE FROM gallery WHERE gallery_id=$delete_id");
        header("Location: manage_gallery.php");
        exit;
    }
}

// Fetch all images
$images = $conn->query("SELECT * FROM gallery ORDER BY gallery_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Gallery - Gym Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body { margin:0; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(120deg,#0f0c29,#302b63,#24243e); color:#fff; }

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

/* Container */
.container { padding:30px; margin-left:300px; }

/* Header */
.header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
.header h1 { color:#ff9800; }

/* Upload Form */
.upload-form { background: rgba(0,0,0,0.6); padding:20px; border-radius:12px; margin-bottom:30px; }
.upload-form h2 { color:#ff9800; margin-bottom:15px; }
.upload-form input[type=file] { display:block; margin-bottom:12px; padding:10px; border-radius:8px; border:none; background:rgba(255,255,255,0.1); color:#fff; }
.upload-form input[type=file]:focus { background: rgba(255,255,255,0.2); outline:none; }
.upload-form button { padding:12px 20px; background:#ff9800; border:none; border-radius:8px; color:#000; font-weight:bold; cursor:pointer; transition:0.3s; }
.upload-form button:hover { background:#e68900; }
.msg { color:#03e603; margin-bottom:10px; }

/* Gallery Grid */
.gallery { display:grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap:20px; }
.gallery-item { background: rgba(0,0,0,0.6); border-radius:12px; overflow:hidden; position:relative; transition:transform 0.3s; }
.gallery-item:hover { transform:scale(1.05); }
.gallery-item img { width:100%; display:block; }
.delete-btn { position:absolute; top:8px; right:8px; background:#ff5252; padding:6px 10px; border-radius:6px; color:#fff; text-decoration:none; font-size:14px; }
.delete-btn:hover { background:#e04848; }

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
            <li><a href="manage_gallery.php" style="background:#ff9800;color:#000;"><i class="fa-solid fa-image"></i> Gallery</a></li>
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
        <h1>Manage Gallery</h1>
    </div>

    <div class="upload-form">
        <h2><i class="fa-solid fa-upload"></i> Upload New Image</h2>
        <?php if($msg) echo "<div class='msg'>".htmlspecialchars($msg)."</div>"; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="file" name="image" required>
            <button type="submit" name="upload_image"><i class="fa-solid fa-upload"></i> Upload</button>
        </form>
    </div>

    <div class="gallery">
        <?php if($images && $images->num_rows > 0): ?>
            <?php while($row = $images->fetch_assoc()): ?>
                <div class="gallery-item">
                    <img src="<?= htmlspecialchars($row['image_name']) ?>" alt="Gallery Image">
                    <a href="manage_gallery.php?delete_id=<?= $row['gallery_id'] ?>" class="delete-btn" onclick="return confirm('Are you sure to delete this image?')"><i class="fa-solid fa-trash"></i></a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No images uploaded yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
