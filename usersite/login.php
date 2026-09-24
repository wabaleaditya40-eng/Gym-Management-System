<?php 
include 'config.php';
session_start();

$msg = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = md5($_POST['password']); // ⚠️ For production, use password_verify() with password_hash()

    $query = "SELECT * FROM users WHERE email=? AND password=? AND status='Active'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['full_name'];
        header("Location: dashboard.php"); 
        exit;
    } else {
        $msg = "❌ Invalid login details!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - FitLife Gym</title>
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
form{background:#222;padding:40px;border-radius:15px;width:100%;max-width:350px;text-align:center;animation:zoomIn 0.8s ease;}
form h2{margin-bottom:20px;}
input, button{width:100%;padding:12px;margin:10px 0;border:none;border-radius:5px;font-size:15px;outline:none;}
button{background:yellow;color:black;font-weight:bold;cursor:pointer;transition:.3s;}
button:hover{background:orange;transform:scale(1.05);}
p.msg{color:red; margin-top:10px;}
p.register-link a{color:yellow;font-weight:bold;}
p.register-link a:hover{color:orange;}

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
    <li><a href="login.php" class="active">Login</a></li>
    <li><a href="register.php">Register</a></li>
  </ul>
</nav>

<!-- Login Form -->
<div class="container">
  <form method="POST" autocomplete="off">
    <h2>User Login</h2>

    <input type="email" name="email" placeholder="Enter Email" required autocomplete="new-email">
    <input type="password" name="password" placeholder="Enter Password" required autocomplete="new-password">
    
    <button type="submit" name="login">Login</button>
    <p class="msg"><?php echo $msg; ?></p>
    <p class="register-link">Not registered yet? <a href="register.php">Register Here</a></p>
  </form>
</div>

<script>
function toggleMenu(){
  document.getElementById("navLinks").classList.toggle("show");
}
</script>

</body>
</html>
