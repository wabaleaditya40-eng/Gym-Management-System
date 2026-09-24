<?php
session_start();
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Our Trainers - FitLife Gym</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {margin:0;font-family:Arial,Helvetica,sans-serif;background:#111;color:white;overflow-x:hidden;}
a{text-decoration:none;transition:.3s;}
a:hover{color:yellow;transform:scale(1.05);}

/* ===== NAVBAR ===== */
nav{background:#1a1a1a;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;}
nav .logo{font-size:24px;font-weight:bold;color:#ffeb3b;}
nav ul{list-style:none;display:flex;gap:25px;margin:0;padding:0;}
nav ul li a{color:#fff;font-weight:500;position:relative;}
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

/* ===== CONTENT ===== */
.content{padding:100px 40px 40px;text-align:center;animation:fadeIn 1.5s;}
.content h1{color:yellow;}
.trainers-container{display:flex;justify-content:center;flex-wrap:wrap;margin-top:40px;gap:20px;}
.trainer-card{background:#222;padding:20px;width:250px;border-radius:10px;box-shadow:0 0 10px black;transition:.3s;}
.trainer-card:hover{transform:scale(1.05);}
.trainer-card img{width:100%;border-radius:10px;}
.trainer-card h3{color:yellow;}

/* ===== FOOTER ===== */
footer{background:#000;color:#fff;padding:40px 20px;margin-top:40px;}
.footer-container{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:30px;max-width:1200px;margin:auto;}
.term{text-align:center;margin-top:20px;font-size:13px;color:#888;padding-top:15px;}
.footer h3{margin-bottom:15px;color:yellow;}
.footer p,.footer a{color:#ccc;font-size:14px;line-height:1.6;text-decoration:none;}
.footer a:hover{color:yellow;}
.socials a{margin-right:15px;font-size:18px;color:#ccc;transition:.3s;}
.socials a:hover{color:yellow;}
.footer-bottom{text-align:center;margin-top:20px;font-size:13px;color:#888;border-top:1px solid #333;padding-top:15px;}
@media(max-width:600px){.footer-container{text-align:center;}.socials a{display:inline-block;margin:8px;}}
@keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
</style>
</head>
<body>

<!-- Navbar -->
<nav>
  <div class="logo">🏋️ FitLife Gym</div>
  <span class="menu-toggle" onclick="toggleMenu()">☰</span>
  <ul id="nav-links">
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    if(isset($_SESSION['user_id'])):
    ?>
      <li><a href="index.php" class="<?php echo ($current_page=='user_dashboard.php')?'active':''; ?>">Dashboard</a></li>
      <li><a href="about.php" class="<?php echo ($current_page=='about.php')?'active':''; ?>">About</a></li>
      <li><a href="services.php" class="<?php echo ($current_page=='services.php')?'active':''; ?>">Services</a></li>
      <li><a href="plans.php" class="<?php echo ($current_page=='plans.php')?'active':''; ?>">Plans</a></li>
      <li><a href="trainers.php" class="<?php echo ($current_page=='trainers.php')?'active':''; ?>">Trainers</a></li>
      <li><a href="gallery.php" class="<?php echo ($current_page=='gallery.php')?'active':''; ?>">Gallery</a></li>
      <li><a href="contact.php" class="<?php echo ($current_page=='contact.php')?'active':''; ?>">Contact</a></li>
      <li style="color:#ffeb3b;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</li>
      <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="index.php" class="<?php echo ($current_page=='index.php')?'active':''; ?>">Home</a></li>
      <li><a href="about.php" class="<?php echo ($current_page=='about.php')?'active':''; ?>">About</a></li>
      <li><a href="services.php" class="<?php echo ($current_page=='services.php')?'active':''; ?>">Services</a></li>
      <li><a href="plans.php" class="<?php echo ($current_page=='plans.php')?'active':''; ?>">Plans</a></li>
      <li><a href="trainers.php" class="<?php echo ($current_page=='trainers.php')?'active':''; ?>">Trainers</a></li>
      <li><a href="gallery.php" class="<?php echo ($current_page=='gallery.php')?'active':''; ?>">Gallery</a></li>
      <li><a href="contact.php" class="<?php echo ($current_page=='contact.php')?'active':''; ?>">Contact</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>

<!-- Content -->
<div class="content">
  <h1>Meet Our Trainers</h1>
  <div class="trainers-container">
    <?php
    $trainers_query = $conn->query("SELECT * FROM trainers WHERE status='Active' ORDER BY trainer_id ASC");
    if($trainers_query && $trainers_query->num_rows > 0){
        while($trainer = $trainers_query->fetch_assoc()){
            echo '<div class="trainer-card">
                    <h3>'.htmlspecialchars($trainer['full_name']).'</h3>
                    <p>'.htmlspecialchars($trainer['specialization']).'</p>
                  </div>';
        }
    } else { 
        echo '<p>No trainers available at the moment.</p>'; 
    }
    ?>
  </div>
</div>


<!-- Footer -->
<footer>
  <div class="footer-container">
    <div class="footer">
      <h3>Quick Links</h3>
      <a href="index.php">Home</a><br>
      <a href="plans.php">Plans</a><br>
      <a href="services.php">Services</a><br>
      <a href="gallery.php">Gallery</a><br>
      <a href="login.php">Login</a>
    </div>
    <div class="footer">
      <h3>Opening Hours</h3>
      <p>Mon - Fri: 6:00 AM - 10:00 PM</p>
      <p>Saturday: 7:00 AM - 8:00 PM</p>
      <p>Sunday: Closed</p>
    </div>
    <div class="footer">
      <h3>Contact Info</h3>
      <p>📍 123 Fitness Street, Mumbai, India</p>
      <p>📞 +91 9876543210</p>
      <p>📧 info@fitlifegym.com</p>
    </div>
    <div class="footer">
      <h3>Follow Us</h3>
      <div class="socials">

        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
    
    </div>
  </div>
      <div class="term">
        <a href="privacy.php"><p>Privacy & Policy</a>
        <a href="terms.php">|  Terms & Conditions</p></a>
        
      </div>
  <div class="footer-bottom">
    <p> FitLife Gym | Designed with ❤️  by Aviraj ,Kunal & Aditya</p>
  </div>
</footer>


<script>
function toggleMenu(){
  document.getElementById("nav-links").classList.toggle("active");
}
</script>

</body>
</html>
