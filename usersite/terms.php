<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Terms & Conditions - FitLife Gym</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background: #111;
      color: #eee;
      line-height: 1.6;
    }
    h1, h2 { color: #ffeb3b; 
    }
    a { color: #ffeb3b;
         text-decoration: none;
      }
    a:hover { text-decoration: underline;
         }

    
  
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

    @keyframes fadeIn {
      from {opacity:0; transform:translateY(20px);}
      to {opacity:1; transform:translateY(0);}
    }
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
    <h1>Terms & Conditions</h1>
    <p>By accessing and using the FitLife Gym website and services, you agree to the following terms and conditions.</p>

    <div class="terms-section">
      <h2>1. Membership</h2>
      <p>All memberships are non-transferable and valid only for the registered member. Cancellation policies may apply as outlined during sign-up.</p>
    </div>

    <div class="terms-section">
      <h2>2. Payment</h2>
      <p>Membership fees, class bookings, and other purchases must be paid in full at the time of registration or as per your chosen plan.</p>
    </div>

    <div class="terms-section">
      <h2>3. Conduct</h2>
      <p>Members are expected to maintain proper behavior and follow gym rules. The management reserves the right to revoke access for misconduct.</p>
    </div>

    <div class="terms-section">
      <h2>4. Health & Safety</h2>
      <p>Members are responsible for ensuring they are fit to participate in physical activities. FitLife Gym is not liable for injuries unless caused by negligence.</p>
    </div>

    <div class="terms-section">
      <h2>5. Website Use</h2>
      <p>All content, images, and materials on this website are property of FitLife Gym and cannot be copied or reproduced without permission.</p>
    </div>

    <div class="terms-section">
      <h2>6. Changes to Terms</h2>
      <p>We may update these terms from time to time. Continued use of our services after changes implies acceptance of the updated terms.</p>
    </div>

    <div class="terms-section">
      <h2>7. Contact Us</h2>
      <p>If you have any questions about these Terms & Conditions, please contact us at <a href="mailto:support@fitlifegym.com">support@fitlifegym.com</a>.</p>
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
    <p>&copy; <?php echo date("Y"); ?> FitLife Gym | Designed with ❤️  by Aviraj ,Kunal & Aditya</p>
  </div>
</footer>
</body>
</html>
