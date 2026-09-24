<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - FitLife Gym</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome for Social Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body{margin:0;font-family:Arial,Helvetica,sans-serif;background:#111;color:white;overflow-x:hidden;}
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
.hero{
  height:550px; /* increase manually */
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  text-align:center;
  padding:0 40px;
  animation:fadeIn 1.5s;
  background:url('abo.jpg') center/cover no-repeat;
  position:relative;
  color:white;
}

    .hero::before{
      content:"";
      position:absolute;
      top:0;left:0;width:100%;height:100%;
      background:rgba(0,0,0,0.6);
      z-index:0;
    }
    .hero h1,.hero p{position:relative;z-index:1;}
    .hero h1{color:yellow;font-size:40px;margin-top:150px;}
    .hero p{max-width:700px;margin:auto;margin-top:15px;line-height:1.6;font-size:18px;}

    /* 🔹 Section Styling */
    .section{padding:100px 40px;}
    .dark-section{background:#181818;}
    .flex-box{display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:20px;}

    .card{background:#222;padding:20px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,0.6);flex:1;min-width:250px;max-width:300px;text-align:center;}
    .card h3{color:yellow;margin-bottom:10px;}
    .card img{width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:15px;border:3px solid yellow;}

    /* Why Choose Us list ticks only */
    .why-choose-us ul{list-style:none;padding:0;max-width:800px;margin:auto;line-height:2;font-size:17px;}
    .why-choose-us ul li::before{content:"✔️ ";}

    /* 🔹 Footer */
    footer {
      background: #000;
      color: #fff;
      padding: 40px 20px;
      margin-top: 40px;
    }
    .footer-container {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
      gap: 30px;
      max-width: 1200px;
      margin: auto;
    }
    .term{text-align:center;margin-top:20px;font-size:13px;color:#888;padding-top:15px;}
    .footer h3 {margin-bottom: 15px;color: yellow;}
    .footer p, .footer a {color: #ccc;font-size: 14px;line-height: 1.6;}
    .footer a:hover {color: yellow;}
    .socials a {margin-right: 15px;font-size: 18px;color: #ccc;transition: .3s;}
    .socials a:hover {color: yellow;}
    .footer-bottom {text-align: center;margin-top: 20px;font-size: 13px;color: #888;border-top: 1px solid #333;padding-top: 15px;}
    @media(max-width:600px){.footer-container{text-align:center;}.socials a{display:inline-block;margin:8px;}}

    /* 🔹 Animation */
    @keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
  </style>
</head>
<body>

<!-- NAVBAR -->
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
      <li><a href="#programs">Programs</a></li>
      <li><a href="login.php" class="<?php echo ($current_page=='login.php')?'active':''; ?>">Log In</a></li>
      <li><a href="register.php" class="<?php echo ($current_page=='register.php')?'active':''; ?>">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>

<!-- 🔹 Hero Section -->
<div class="hero">
 <h1>About Us</h1>
  <p>Our gym is more than just a workout place — it’s a lifestyle.  
     With world-class trainers, personalized fitness plans, and the latest equipment,  
     we help you transform your health and confidence.</p>
</div>

<!-- 🔹 Who We Are -->
<div class="section dark-section flex-box">
  <div style="flex:1;min-width:280px;padding:20px;">
    <img src="who.avif" alt="Gym" style="width:100%;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.6);">
  </div>
  <div style="flex:1;min-width:280px;padding:20px;">
    <h2 style="color:yellow;margin-bottom:15px;">Who We Are</h2>
    <p>We are a fitness community dedicated to empowering individuals on their health and wellness journeys. We provide a supportive and inclusive environment where members can achieve their fitness goals, whether it's losing weight, building strength, improving athletic performance, or simply enhancing overall well-being. Our experienced trainers offer personalized guidance and motivation, while our state-of-the-art facility and diverse range of classes cater to all fitness levels and interests. We believe that fitness is not just about physical strength, but also about building confidence, reducing stress, and fostering a positive mindset.</p>
  </div>
</div>

<!-- 🔹 Mission & Vision -->
<div class="section">
  <h2 style="color:yellow;text-align:center;margin-bottom:30px;">Our Mission & Vision</h2>
  <div class="flex-box">
    <div class="card">
      <h3>🎯 Mission</h3>
      <p>To inspire individuals to lead healthier, stronger, and more confident lives through fitness.</p>
    </div>
    <div class="card">
      <h3>🚀 Vision</h3>
      <p>To be the most trusted fitness destination, known for results and an uplifting environment.</p>
    </div>
  </div>
</div>

<!-- 🔹 Why Choose Us -->
<div class="section dark-section">
  <h2 style="color:yellow;text-align:center;margin-bottom:30px;">Why Choose Us?</h2>
  <div class="why-choose-us">
    <ul>
      <li>Certified & Experienced Trainers</li>
      <li>Modern Equipment & Facilities</li>
      <li>Personalized Training Programs</li>
      <li>Flexible Membership Plans</li>
      <li>Supportive Fitness Community</li>
    </ul>
  </div>
</div>

<!-- 🔹 Testimonials -->
<div class="section">
  <h2 style="color:yellow;margin-bottom:30px;text-align:center;">What Our Members Say</h2>
  <div class="flex-box">
    <div class="card">
      <img src="r2.jpg" alt="Rahul Sharma">
      <p>"This gym completely changed my life. The trainers are super motivating!"</p>
      <strong>- Rahul Sharma</strong>
    </div>
    <div class="card">
      <img src="r1.jpeg" alt="Priya Singh">
      <p>"The environment here is amazing. I actually look forward to workouts now."</p>
      <strong>- Priya Singh</strong>
    </div>
    <div class="card">
      <img src="r3.jpg" alt="Amit Verma">
      <p>"Best gym in the city! Great equipment and helpful staff."</p>
      <strong>- Amit Verma</strong>
    </div>
  </div>
</div>

<!-- 🔹 Footer -->
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
    <p> FitLife Gym | Designed with ❤️ by Aviraj ,Kunal & Aditya</p>
  </div>
</footer>


<script>
  function toggleMenu(){
    document.getElementById("nav-links").classList.toggle("active");
  }
</script>

</body>
</html>
