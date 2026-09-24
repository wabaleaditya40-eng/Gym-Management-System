<?php 
session_start();
require_once "config.php"; // optional if contact_submit.php uses DB
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us - FitLife Gym</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {margin:0;font-family:Arial,sans-serif;background:#111;color:white;overflow-x:hidden;}
a{text-decoration:none;transition:.3s;}
a:hover{color:yellow;}

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
.content h1{color:yellow; padding:0px 0px 50px;}
.contact-form{max-width:500px;margin:auto;background:#222;padding:20px;border-radius:10px;box-shadow:0 0 10px black;animation:slideUp 1s;}
.contact-form input, .contact-form textarea{width:100%;padding:10px;margin:10px 0;border:none;border-radius:5px;}
.contact-form textarea{height:120px;}
.contact-form button{background:yellow;color:black;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;font-weight:bold;transition:0.3s;}
.contact-form button:hover{background:orange;transform:scale(1.05);}

/* ===== MESSAGES ===== */
.message{padding:10px;border-radius:5px;margin:15px auto;max-width:500px;}
.message.success{background:green;color:white;}
.message.error{background:red;color:white;}

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

/* ===== ANIMATIONS ===== */
@keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
@keyframes slideUp{from{transform:translateY(50px);opacity:0;}to{transform:translateY(0);opacity:1;}}
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
      <li><a href="contact.php" class="active">Contact</a></li>
      <li style="color:#ffeb3b;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</li>
      <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="index.php" class="<?php echo ($current_page=='index.php')?'active':''; ?>">Home</a></li>
      <li><a href="about.php" class="<?php echo ($current_page=='about.php')?'active':''; ?>">About</a></li>
      <li><a href="services.php" class="<?php echo ($current_page=='services.php')?'active':''; ?>">Services</a></li>
      <li><a href="plans.php" class="<?php echo ($current_page=='plans.php')?'active':''; ?>">Plans</a></li>
      <li><a href="trainers.php" class="<?php echo ($current_page=='trainers.php')?'active':''; ?>">Trainers</a></li>
      <li><a href="gallery.php" class="<?php echo ($current_page=='gallery.php')?'active':''; ?>">Gallery</a></li>
      <li><a href="contact.php" class="active">Contact</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>

<!-- Content -->
<div class="content">
  <h1>Contact Us</h1>

  <!-- Success / Error Messages -->
  <?php if(isset($_SESSION['success'])): ?>
    <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php elseif(isset($_SESSION['error'])): ?>
    <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- Contact Form + Map -->
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:30px;max-width:1100px;margin:auto;align-items:start;">
    
    <!-- Contact Form -->
    <form method="post" action="contact_submit.php" class="contact-form">
      <h2 style="color:yellow;margin-bottom:15px;">Send Us a Message</h2>
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>

    <!-- Map -->
    <div style="width:500px;max-width:500px;margin:auto;background:#222;padding:20px;border-radius:10px;box-shadow:0 0 10px black;animation:slideUp 1s;">
      <h2 style="color:yellow;margin-bottom:15px;">Find Us</h2>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.6151913808662!2d74.73629517497749!3d19.080649282124863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bdcb05a2826b933%3A0x58984fdfc6b9c330!2sGovernment%20Polytechnic%20Ahilyanagar!5e0!3m2!1sen!2sin!4v1755925714421!5m2!1sen!2sin" width="100%" height="310" style="border:0;border-radius:10px;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</div>

<!-- FAQ Section -->
<div style="background:#000;padding:60px 20px;text-align:center;">
  <h1 style="color:yellow;margin-bottom:30px;">Frequently Asked Questions</h1>
  <div style="max-width:900px;margin:auto;text-align:left;">
    
    <div style="background:#222;padding:20px;margin:15px 0;border-radius:10px;box-shadow:0 0 8px rgba(0,0,0,0.6);">
      <h3 style="color:yellow;margin:0 0 10px;">💰 What are your membership charges?</h3>
      <p>Our plans start from just ₹999/month. Check the <a href="plans.php" style="color:yellow;">Plans</a> page for details.</p>
    </div>

    <div style="background:#222;padding:20px;margin:15px 0;border-radius:10px;box-shadow:0 0 8px rgba(0,0,0,0.6);">
      <h3 style="color:yellow;margin:0 0 10px;">🏋️ Do you provide personal trainers?</h3>
      <p>Yes, certified personal trainers are available. Charges depend on the package.</p>
    </div>

    <div style="background:#222;padding:20px;margin:15px 0;border-radius:10px;box-shadow:0 0 8px rgba(0,0,0,0.6);">
      <h3 style="color:yellow;margin:0 0 10px;">👩‍🦰 Do you have ladies-only batches?</h3>
      <p>Yes, we run special batches for ladies in the morning and evening slots.</p>
    </div>

    <div style="background:#222;padding:20px;margin:15px 0;border-radius:10px;box-shadow:0 0 8px rgba(0,0,0,0.6);">
      <h3 style="color:yellow;margin:0 0 10px;">🎁 Can I get a free trial?</h3>
      <p>Absolutely! Contact us via this form or call our support team to book your free trial.</p>
    </div>

  </div>
</div>



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
