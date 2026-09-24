<?php
session_start();
require_once "config.php";

// Ensure it's coming from POST (form submission)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

if(!isset($_POST['plan_id']) || !is_numeric($_POST['plan_id'])){
    die("Invalid Plan ID.");
}

$plan_id = intval($_POST['plan_id']);
$transaction_id = trim($_POST['transaction_id']);

// Validate transaction ID
if(empty($transaction_id)){
    die("Transaction ID is required.");
}

// Fetch plan details
$plan = $conn->query("SELECT * FROM plans WHERE plan_id=$plan_id")->fetch_assoc();
if(!$plan) die("Plan not found.");

// Save purchase record in DB
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO purchases(user_id, plan_id, transaction_id, purchase_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $user_id, $plan_id, $transaction_id);
    $stmt->execute();
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Receipt - <?php echo htmlspecialchars($plan['plan_name']); ?></title>
  <style>
    body{background:#111;color:white;font-family:Arial;}
    .receipt{max-width:600px;margin:50px auto;padding:20px;background:#222;border-radius:12px;}
    h1{color:yellow;text-align:center;}
    .details{margin:20px 0;line-height:1.8;}
    .btn{display:block;margin:20px auto;padding:10px 20px;background:yellow;color:black;font-weight:bold;border-radius:6px;text-decoration:none;text-align:center;width:120px;}
    .btn:hover{background:orange;}
  </style>
</head>
<body>
  <div class="receipt">
    <h1>Payment Receipt</h1>
    <div class="details">
      <p><strong>Plan:</strong> <?php echo htmlspecialchars($plan['plan_name']); ?></p>
      <p><strong>Price:</strong> ₹<?php echo number_format($plan['price'],2); ?></p>
      <p><strong>Duration:</strong> <?php echo $plan['duration_months']; ?> Months</p>
      <p><strong>Date:</strong> <?php echo date("d M Y, h:i A"); ?></p>
      <p><strong>Customer:</strong> <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : "Guest"; ?></p>
      <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_id); ?></p>
    </div>
    <button onclick="window.print()" class="btn">Print</button>
  </div>
</body>
</html>
