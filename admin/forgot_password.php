<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    $stmt = $conn->prepare("SELECT admin_id FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);

        // Save OTP in DB
        $stmt = $conn->prepare("UPDATE admins SET otp = ? WHERE email = ?");
        $stmt->bind_param("ss", $otp, $email);
        $stmt->execute();

        // Store email in session
        $_SESSION["reset_email"] = $email;

        // Send OTP via email (use PHPMailer in real project)
        mail($email, "Your OTP Code", "Your password reset OTP is: $otp");

        header("Location: verify_otp.php");
        exit;
    } else {
        $error = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Forgot Password</title></head>
<body>
    <h2>Forgot Password</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Enter your email:</label><br>
        <input type="email" name="email" required>
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
