<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Privacy Policy - FitLife Gym</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background: #111;
      color: #eee;
      line-height: 1.6;
    }
    h1, h2 { color: #ffeb3b; }
    a { color: #ffeb3b; text-decoration: none; }
    a:hover { text-decoration: underline; }

  
   nav {
  background: #1a1a1a;
  color: #fff;
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 1000;
}

nav .logo {
  font-size: 24px;
  font-weight: bold;
  color: #ffeb3b;
}

nav ul {
  list-style: none;
  display: flex;
  gap: 25px;
  margin: 0;
  padding: 0;
}

nav ul li a {
  text-decoration: none;
  color: #fff;
  font-weight: 500;
  transition: .3s;
  position: relative;
}

nav ul li a::after {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  background: #ffeb3b;
  left: 0;
  bottom: -4px;
  transition: width .3s;
}

nav ul li a:hover,
nav ul li a.active {
  color: #ffeb3b;
}

nav ul li a:hover::after,
nav ul li a.active::after {
  width: 100%;
}

.menu-toggle {
  display: none;
  font-size: 26px;
  cursor: pointer;
  color: #ffeb3b;
}

@media (max-width: 768px) {
  nav ul {
    position: absolute;
    top: 65px;
    left: -100%;
    flex-direction: column;
    background: #1a1a1a;
    width: 100%;
    padding: 20px;
    transition: .3s;
  }

  nav ul.active {
    left: 0;
  }

  nav ul li {
    margin: 15px 0;
  }

  .menu-toggle {
    display: block;
  }
}


  
    .content {
      padding: 100px 40px 60px 40px;
      max-width: 900px;
      margin: auto;
      animation: fadeIn 1.2s;
    }

   
    .terms-section { margin-bottom: 40px; }

    
 

footer {
  background: #000;
  color: #fff;
  padding: 40px 20px;
  margin-top: 40px;
}

.footer-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: auto;
}

.footer h3 {
  margin-bottom: 15px;
  color: yellow;
}

.footer p,
.footer a {
  color: #ccc;
  font-size: 14px;
  line-height: 1.6;
  text-decoration: none;
}

.footer a:hover {
  color: yellow;
}

.socials a {
  margin-right: 15px;
  font-size: 18px;
  color: #ccc;
  transition: .3s;
}

.socials a:hover {
  color: yellow;
}

.term {
  text-align: center;
  margin-top: 20px;
  font-size: 13px;
  color: #888;
  padding-top: 15px;
}

.footer-bottom {
  text-align: center;
  margin-top: 20px;
  font-size: 13px;
  color: #888;
  border-top: 1px solid #333;
  padding-top: 15px;
}


@media (max-width: 600px) {
  .footer-container {
    text-align: center;
  }

  .socials a {
    display: inline-block;
    margin: 8px;
  }
}


    @keyframes fadeIn{from{opacity:0;}to{opacity:1;}}

  </style>
</head>
<body>


<nav>
  <div class="logo">🏋️ FitLife Gym</div>
  <span class="menu-toggle" onclick="toggleMenu()">☰</span>
  <ul id="nav-links">
    <?php if(isset($_SESSION['user_id'])): ?>
      <li><a href="index.php">Dashboard</a></li>
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



  <div class="content">
    <h1>Privacy Policy</h1>
    <p>Your privacy is important to us. This Privacy Policy explains how FitLife Gym collects, uses, and safeguards your personal information.</p>

    <div class="policy-section">
      <h2>1. Information We Collect</h2>
      <p>We may collect your name, email address, phone number, and payment details when you register, book classes, or make purchases.</p>
    </div>

    <div class="policy-section">
      <h2>2. How We Use Your Information</h2>
      <ul>
        <li>To manage your membership and provide services</li>
        <li>To send updates, offers, and important notices</li>
        <li>To improve our website and customer experience</li>
      </ul>
    </div>

    <div class="policy-section">
      <h2>3. Data Protection</h2>
      <p>We implement strong security measures to keep your personal data safe. However, no method of online transmission is 100% secure.</p>
    </div>

    <div class="policy-section">
      <h2>4. Sharing of Information</h2>
      <p>We do not sell or rent your personal information. We may share limited data with trusted partners who help us operate our services.</p>
    </div>

    <div class="policy-section">
      <h2>5. Your Rights</h2>
      <p>You may request access, update, or deletion of your personal information by contacting us directly.</p>
    </div>

    <div class="policy-section">
      <h2>6. Contact Us</h2>
      <p>If you have questions regarding this Privacy Policy, please contact us at <a href="mailto:support@fitlifegym.com">support@fitlifegym.com</a>.</p>
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

  
</body>
</html>
