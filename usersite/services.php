<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Services - FitLife Gym</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin:0;
      font-family:Arial,Helvetica,sans-serif;
      background:#111;
      color:white;
      overflow-x:hidden;
    }
    a{text-decoration:none;color:white;transition:.3s;}
    a:hover{color:yellow;transform:scale(1.05);}

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

    /* 🔹 Hero / Background */
    .content {
      position: relative;
      padding:100px 40px 40px 40px;
      text-align:center;
      animation:fadeIn 1.5s;
      background: url("se.jpg") no-repeat center center/cover;
      min-height: 80vh;
    }
    .content::before {
      content:"";
      position:absolute;
      top:0;left:0;right:0;bottom:0;
      background:rgba(0,0,0,0.6);
      z-index:0;
    }
    .content h1, .service-card { position:relative; z-index:1; }

    .service-card{
      background:rgba(34,34,34,0.85);
      padding:20px;
      width:280px;
      border-radius:10px;
      text-align:center;
      box-shadow:0 0 10px black;
      transition:0.3s;
    }
    .service-card:hover{transform:scale(1.05);}

    /* 🔹 Extra Sections */
    .section{padding:60px 20px;text-align:center;}
    .section h2{color:yellow;margin-bottom:25px;}
    .benefits, .testimonials {display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;max-width:1100px;margin:auto;}
    .benefit-card,.testimonial-card{
      background:#222;
      padding:20px;
      border-radius:10px;
      box-shadow:0 0 10px rgba(0,0,0,0.7);
      transition:0.3s;
    }
    .benefit-card:hover,.testimonial-card:hover{transform:translateY(-5px);}
    .testimonial-card p{font-style:italic;color:#ccc;}



    /* 🔹 Footer */
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
      <li><a href="login.php" class="<?php echo ($current_page=='login.php')?'active':''; ?>">Login</a></li>
      <li><a href="register.php" class="<?php echo ($current_page=='register.php')?'active':''; ?>">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>

<!-- Services Content -->
<div class="content">
  <h1 style="color:yellow;">Our Services</h1>
  <div style="display:flex;justify-content:center;flex-wrap:wrap;margin-top:40px;gap:20px;position:relative;z-index:1;">

    <div class="service-card">
      <h3 style="color:yellow;">Personal Training</h3>
      <p>One-on-one coaching sessions designed to maximize results.</p>
    </div>

    <div class="service-card">
      <h3 style="color:yellow;">Group Classes</h3>
      <p>Yoga, Zumba, HIIT & more for a fun group workout experience.</p>
    </div>

    <div class="service-card">
      <h3 style="color:yellow;">Nutrition Plans</h3>
      <p>Customized diet programs to complement your training.</p>
    </div>

    <div class="service-card">
      <h3 style="color:yellow;">Strength Training</h3>
      <p>Build lean muscle with guided weightlifting and resistance programs.</p>
    </div>

    <div class="service-card">
      <h3 style="color:yellow;">Cardio Zone</h3>
      <p>Access modern treadmills, cycles & equipment for heart health.</p>
    </div>

    <div class="service-card">
      <h3 style="color:yellow;">Spa & Recovery</h3>
      <p>Relax with massage, steam, and recovery therapies post workout.</p>
    </div>

  </div>
</div>

<!-- Why Choose Us -->
<div class="section" style="background:#000;">
  <h2>💡 Why Choose FitLife?</h2>
  <p style="max-width:800px;margin:auto;color:#ccc;">
    At FitLife Gym, we combine world-class equipment, certified trainers, and personalized programs
    to help you achieve your fitness goals in a motivating environment.
  </p>
</div>

<!-- Membership Benefits -->
<div class="section">
  <h2>🔥 Membership Benefits</h2>
  <div class="benefits">
    <div class="benefit-card">
      <h3 style="color:yellow;">Unlimited Access</h3>
      <p>Workout anytime with 7-day access to our facilities.</p>
    </div>
    <div class="benefit-card">
      <h3 style="color:yellow;">Expert Trainers</h3>
      <p>Certified professionals to guide your transformation.</p>
    </div>
    <div class="benefit-card">
      <h3 style="color:yellow;">Modern Equipment</h3>
      <p>State-of-the-art machines & tools for every fitness need.</p>
    </div>
    <div class="benefit-card">
      <h3 style="color:yellow;">Nutrition Support</h3>
      <p>Personalized diet advice to match your training goals.</p>
    </div>
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
