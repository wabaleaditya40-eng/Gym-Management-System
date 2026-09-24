<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - FitLife Gym</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {margin:0;font-family:Arial,sans-serif;background:#111;color:white;overflow-x:hidden;}
a{text-decoration:none;transition:.3s;} a:hover{color:yellow;}

/* ===== NAVBAR ===== */
    nav{background:#1a1a1a;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;}
    nav .logo{font-size:24px;font-weight:bold;color:#ffeb3b;}
    nav ul{list-style:none;display:flex;gap:25px;margin:0;padding:0;}
    nav ul li a{text-decoration:none;color:#fff;font-weight:500;transition:.3s;position:relative;}
    nav ul li a::after{content:"";position:absolute;width:0;height:2px;background:#ffeb3b;left:0;bottom:-4px;transition:width .3s;}
    nav ul li a:hover, nav ul li a.active{color:#ffeb3b;}
    nav ul li a:hover::after, nav ul li a.active::after{width:100%;}
    .menu-toggle{display:none;font-size:26px;cursor:pointer;color:#ffeb3b;}
    @media(max-width:768px){
      nav ul{position:absolute;top:65px;left:-100%;flex-direction:column;background:#1a1a1a;width:100%;padding:20px;transition:.3s;}
      nav ul.active{left:0;}
      nav ul li{margin:15px 0;}
      .menu-toggle{display:block;}
    }

/* Dashboard Content */
.container{display:flex;flex-direction:column;justify-content:center;align-items:center;min-height:100vh;padding-top:80px;text-align:center;animation:fadeIn 1s ease;}
.container h1{color:yellow;}
.container p{max-width:500px;margin-top:20px;line-height:1.6;}
.container .btns{margin-top:30px;display:flex;gap:20px;}
.btns a{padding:15px 25px;border-radius:8px;font-weight:bold;text-decoration:none;transition:.3s;}
.btn-yellow{background:yellow;color:black;}
.btn-grey{background:#444;color:white;}
.btns a:hover{transform:scale(1.05);}

/* Animations */
@keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>

<!-- Navbar -->
<nav>
  <div class="logo">🏋️ FitLife Gym</div>
  <span class="menu-toggle" onclick="toggleMenu()">☰</span>
  <ul id="navLinks">
    <li><a href="index.php">Dashboard</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="plans.php">Plans</a></li>
      <li> <a href="trainers.php">Trainers</a></li>
      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="contact.php">Contact</a></li>
    <li><a href="logout.php" class="logout">Logout</a></li>
  </ul>
</nav>

<!-- Dashboard Content -->
<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h1>
    <p>
        This is your <b>Dashboard</b>. From here you can check your membership plan, 
        explore workout schedules, and access gym updates.
    </p>
    <div class="btns">
        <a href="plans.php" class="btn-yellow">View Plans</a>
        <a href="about.php" class="btn-grey">About Us</a>
    </div>
</div>

<script>
function toggleMenu(){
    document.getElementById("navLinks").classList.toggle("show");
}
</script>

</body>
</html>
