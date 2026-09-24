<?php
session_start();
include 'config.php'; // Database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FitLife Gym Dashboard</title>
  <link rel="icon" type="image/jpg" href="gym_favicon.jpg"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}
    body{background:#0d0d0d;color:#eaeaea;scroll-behavior:smooth;overflow-x:hidden;}


    /* ===== NAVBAR ===== */
    nav{background:#1a1a1a;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;}
    nav .logo{font-size:24px;font-weight:bold;color:#ffeb3b;}
    nav ul{list-style:none;display:flex;gap:25px;}
    nav ul li a{text-decoration:none;color:#fff;font-weight:500;transition:.3s;position:relative;}
    nav ul li a::after{content:"";position:absolute;width:0;height:2px;background:#ffeb3b;left:0;bottom:-4px;transition:width .3s;}
    nav ul li a:hover{color:#ffeb3b;}nav ul li a:hover::after{width:100%;}
    .menu-toggle{display:none;font-size:26px;cursor:pointer;color:#ffeb3b;}
    @media(max-width:768px){
      nav ul{position:absolute;top:65px;left:-100%;flex-direction:column;background:#1a1a1a;width:100%;padding:20px;transition:.3s;}
      nav ul.active{left:0;}
      nav ul li{margin:15px 0;}
      .menu-toggle{display:block;}
    }

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

    /* ===== HERO ===== */
    .hero{height:75vh;background:url('main2.jpg') no-repeat center center/cover;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;color:#ffeb3b;position:relative;}
    .overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.7);}
    .hero-content{position:relative;z-index:2;width:80%;}
    .hero h1{font-size:48px;margin-bottom:15px;color:#ffeb3b;text-shadow:2px 2px 8px rgba(0,0,0,.8);}
    .hero p{font-size:20px;margin-bottom:25px;color:#f5f5f5;}
    .hero button{padding:12px 20px;font-size:16px;border:none;border-radius:5px;background:#ffeb3b;color:#000;font-weight:bold;cursor:pointer;transition:.3s;}
    .hero button:hover{background:#fdd835;transform:scale(1.05);}

    /* ===== SECTIONS ===== */
    section{padding:40px 20px;text-align:center;}
    section h2{margin-bottom:20px;color:#ffeb3b;font-size:32px;}

    /* ===== FEATURES ===== */
    .features{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-top:20px;}
    .card{background:#1c1c1c;padding:20px;border-radius:10px;box-shadow:0 2px 5px rgba(0,0,0,.5);transition:.3s ease;}
    .card:hover{transform:translateY(-5px) scale(1.02);box-shadow:0 6px 15px rgba(255,235,59,.3);}
    .card h3{margin-bottom:10px;color:#ffeb3b;}
    .card p{color:#ddd;}

    /* ===== TESTIMONIALS ===== */
    .testimonials{background:#0d0d0d;padding:60px 20px;text-align:center;}
    .testimonials .section-title{font-size:32px;margin-bottom:10px;color:#ffeb3b;}
    .testimonials .section-subtitle{color:#bbb;margin-bottom:40px;}
    .testimonial-container{position:relative;max-width:900px;margin:auto;overflow:hidden;}
    .testimonial-slide{display:flex;transition:transform 0.6s ease;}
    .testimonial-card{min-width:100%;background:#1c1c1c;border-radius:12px;padding:25px;margin:0 10px;box-shadow:0 4px 12px rgba(0,0,0,0.5);}
    .testimonial-text{font-style:italic;color:#eee;margin-bottom:20px;}
    .testimonial-author{display:flex;align-items:center;gap:15px;justify-content:center;}
    .testimonial-author img{border-radius:50%;width:60px;height:60px;object-fit:cover;border:2px solid #ffeb3b;}
    .testimonial-author h4{margin:0;color:#ffeb3b;}
    .testimonial-author span{font-size:14px;color:#bbb;}
    .testimonial-btn{position:absolute;top:50%;transform:translateY(-50%);background:#ffeb3b;border:none;color:#000;font-size:18px;padding:10px 14px;cursor:pointer;border-radius:50%;transition:0.3s;}
    .testimonial-btn:hover{background:#fdd835;}
    .prev{left:-10px;}
    .next{right:-10px;}

    /* ===== FOOTER ===== */
    footer{background:#000;color:#bbb;padding:40px 20px;margin-top:40px;}
    .footer-container{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:30px;max-width:1200px;margin:auto;}
    .term{text-align:center;margin-top:20px;font-size:13px;color:#888;padding-top:15px;}
    .footer h3{margin-bottom:15px;color:#ffeb3b;}
    .footer p,.footer a{color:#bbb;font-size:14px;line-height:1.6;text-decoration:none;}
    .footer a:hover{color:#ffeb3b;}
    .socials a{margin-right:15px;font-size:18px;color:#bbb;transition:.3s;}
    .socials a:hover{color:#ffeb3b;}
    .footer-bottom{text-align:center;margin-top:20px;font-size:13px;color:#777;border-top:1px solid #222;padding-top:15px;}
    @media(max-width:600px){.footer-container{text-align:center;}.socials a{display:inline-block;margin:8px;}}
  </style>
</head>
<body>


<!-- NAVBAR -->
<nav>
  <div class="logo">🏋️ FitLife Gym</div>
  <span class="menu-toggle" onclick="toggleMenu()">☰</span>
  <ul id="nav-links">
    <?php if(isset($_SESSION['user_id'])): ?>
      <li ><a href="#">Dashboard</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="plans.php">Plans</a></li>
      <li> <a href="trainers.php">Trainers</a></li>
      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li style="color:#ffeb3b;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</li>
      <li><a href="logout.php">Logout</a></li>
     <?php else: ?>
      <li><a href="index.php">Home</a></li>
      <li><a href="#programs">Programs</a></li>
      <li><a href="login.php">Log In</a></li>
      <li><a href="register.php">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>


<!-- HERO -->
<section class="hero">
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>Transform Your Body & Mind</h1>
    <p>Join FitLife Gym today and start your fitness journey with the best trainers and modern equipment.</p>
    <?php if(!isset($_SESSION['user_id'])): ?>
      <button onclick="window.location.href='login.php'">Join Now</button>
    <?php else: ?>
      <button onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
    <?php endif; ?>
  </div>
</section>

<!-- PROGRAMS -->
<section id="programs">
  <h2>Our Programs</h2>
  <div class="features">
    <div class="card"><h3>Strength Training</h3><p>Build muscle with modern gym equipment and expert guidance.</p></div>
    <div class="card"><h3>Yoga & Flexibility</h3><p>Improve posture, flexibility, and mindfulness with yoga classes.</p></div>
    <div class="card"><h3>Cardio Workouts</h3><p>Burn calories and boost stamina with advanced cardio machines.</p></div>
    <div class="card"><h3>Personal Training</h3><p>Get personalized fitness plans from certified trainers.</p></div>
  </div>
</section>


<!-- TESTIMONIALS -->
<section class="testimonials" id="testimonials">
  <h2 class="section-title">What Our Members Say</h2>
  <p class="section-subtitle">Real stories from real transformations 💪</p>
  <div class="testimonial-container">
    <div class="testimonial-slide" id="testimonial-slide">
      <div class="testimonial-card">
        <p class="testimonial-text">"FitLife Gym changed my life! The trainers are supportive and the environment motivates me every day."</p>
        <div class="testimonial-author">
          <img src="https://i.pravatar.cc/80?img=12" alt="Member">
          <div><h4>Rohan Sharma</h4><span>Lost 12kg in 6 months</span></div>
        </div>
      </div>
      <div class="testimonial-card">
        <p class="testimonial-text">"The classes are amazing! I love Zumba and Yoga sessions. I feel healthier and stronger than ever."</p>
        <div class="testimonial-author">
          <img src="https://i.pravatar.cc/80?img=32" alt="Member">
          <div><h4>Priya Desai</h4><span>Member since 2023</span></div>
        </div>
      </div>
      <div class="testimonial-card">
        <p class="testimonial-text">"Affordable plans, great equipment, and friendly trainers. Highly recommend FitLife to everyone!"</p>
        <div class="testimonial-author">
          <img src="https://i.pravatar.cc/80?img=47" alt="Member">
          <div><h4>Amit Verma</h4><span>Strength Training Enthusiast</span></div>
        </div>
      </div>
    </div>
    <button class="testimonial-btn prev" onclick="moveSlide(-1)">❮</button>
    <button class="testimonial-btn next" onclick="moveSlide(1)">❯</button>
  </div>
</section>

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

  // ===== Testimonials Slider =====
  let currentIndex = 0;
  const slide = document.getElementById("testimonial-slide");
  const total = slide.children.length;

  function moveSlide(direction){
    currentIndex = (currentIndex + direction + total) % total;
    slide.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  // Auto play every 5s
  setInterval(()=> moveSlide(1), 5000);
</script>

</body>
</html>
