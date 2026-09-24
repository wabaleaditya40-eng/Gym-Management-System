<?php
session_start();
require_once "config.php";

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid Plan ID.");
}

$plan_id = intval($_GET['id']);
$plan = $conn->query("SELECT * FROM plans WHERE plan_id=$plan_id")->fetch_assoc();
if(!$plan) die("Plan not found.");
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $plan['plan_name']; ?> - Plan Details</title>
  <style>
    body{background:#111;color:white;font-family:Arial;}
    .container{max-width:700px;margin:60px auto;padding:20px;background:#222;border-radius:12px;text-align:center;}
    h1{color:yellow;}
    .btn{padding:12px 25px;background:yellow;color:black;font-weight:bold;border-radius:6px;text-decoration:none;display:inline-block;margin-top:20px;border:none;cursor:pointer;}
    .btn:hover{background:orange;}
    .scanner{margin:20px 0;}
    .scanner img{width:200px;border:2px solid yellow;border-radius:8px;}
    input[type="text"]{padding:10px;width:80%;border-radius:6px;border:1px solid #555;margin-top:15px;text-align:center;}
  </style>
</head>
<body>
  <div class="container">
    <h1><?php echo htmlspecialchars($plan['plan_name']); ?></h1>
    <p><strong>Price:</strong> ₹<?php echo number_format($plan['price'],2); ?></p>
    <p><strong>Duration:</strong> <?php echo $plan['duration_months']; ?> Months</p>
    <p><?php echo htmlspecialchars($plan['description']); ?></p>
    
    <div class="scanner">
      <h3>Scan & Pay</h3>
      
    </div>

    <!-- 🔹 Form for Transaction ID -->
    <form action="receipt.php" method="POST">
      <input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">
      <input type="text" name="transaction_id" placeholder="Enter Transaction ID" required>
      <br>
      <button type="submit" class="btn">Confirm Purchase</button>
    </form>
  </div>
</body>
</html>
