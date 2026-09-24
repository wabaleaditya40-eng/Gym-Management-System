<?php
include 'config.php';
session_start();

$msg = "";

if (isset($_POST['register'])) {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $password  = md5($_POST['password']); // ⚠️ For production, use password_hash()
    $phone     = trim($_POST['phone']);
    $gender    = $_POST['gender'];
    $dob       = $_POST['dob'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows > 0) {
        $msg = "⚠️ Email already registered!";
    } else {
        $sql = "INSERT INTO users (full_name, email, password, phone, gender, dob, status) 
                VALUES (?, ?, ?, ?, ?, ?, 'Active')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $full_name, $email, $password, $phone, $gender, $dob);

        if ($stmt->execute()) {
            $msg = "✅ Registration successful! <a href='login.php' style='color:yellow;'>Login Here</a>";
        } else {
            $msg = "❌ Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - FitLife Gym</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {margin:0;font-family:Arial,sans-serif;background:#111;color:white;overflow-x:hidden;}
a{text-decoration:none;transition:.3s;} a:hover{color:yellow;}

/* Navbar */
nav{background:#222;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;}
nav .logo{font-size:24px;font-weight:bold;color:#ffeb3b;}
nav ul{list-style:none;display:flex;gap:25px;margin:0;padding:0;}
nav ul li a{color:#fff;font-weight:500;position:relative;}
nav ul li a.active{color:#ffeb3b;}
nav ul li a:hover{color:#ffeb3b;}
.menu-toggle{display:none;font-size:26px;cursor:pointer;color:#ffeb3b;}
@media(max-width:768px){
  nav ul{position:absolute;top:60px;right:-100%;flex-direction:column;background:#222;width:200px;padding:15px;transition:.3s;}
  nav ul.show{right:0;}
  .menu-toggle{display:block;}
}

/* Container / Form */
.container{display:flex;justify-content:center;align-items:center;min-height:100vh;padding-top:80px;}
form{background:#222;padding:30px;border-radius:15px;width:100%;max-width:400px;text-align:center;animation:zoomIn 0.8s ease;}
form h2{margin-bottom:20px;}
input, select, button{width:100%;padding:12px;margin:8px 0;border:none;border-radius:5px;font-size:15px;}
button{background:yellow;color:black;font-weight:bold;cursor:pointer;transition:.3s;}
button:hover{background:orange;transform:scale(1.05);}
p.msg{color:lightgreen;}

/* Animations */
@keyframes zoomIn{from{transform:scale(0.7);opacity:0;}to{transform:scale(1);opacity:1;}}
</style>
</head>
<body>

<!-- Navbar -->
<nav>
  <div class="logo">🏋️ FitLife Gym</div>
  <span class="menu-toggle" onclick="toggleMenu()">☰</span>
  <ul id="navLinks">
    <li><a href="index.php">Home</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="register.php" class="active">Register</a></li>
  </ul>
</nav>

<!-- Registration Form -->
<div class="container">
  <form method="POST" autocomplete="off">
    <h2>User Registration</h2>
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="phone" placeholder="Phone Number" required>
    <select name="gender" required>
      <option value="">-- Select Gender --</option>
      <option>Male</option>
      <option>Female</option>
      <option>Other</option>
    </select>
    <input type="date" name="dob" required>
    <button type="submit" name="register">Register</button>
    <p class="msg"><?php echo $msg; ?></p>
  </form>
</div>

<script>
function toggleMenu(){
  document.getElementById("navLinks").classList.toggle("show");
}
</script>

</body>
</html>
