<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["reset_email"])) {
    header("Location: forgot_password.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST["otp"];
    $email = $_SESSION["reset_email"];

    $stmt = $conn->prepare("SELECT otp FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_otp);
    $stmt->fetch();

    if ($entered_otp === $db_otp) {
        // Clear OTP
        $stmt = $conn->prepare("UPDATE admins SET otp = NULL WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $_SESSION["otp_verified"] = true;
        header("Location: reset_password.php");
        exit;
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Verify OTP</title></head>
<body>
    <h2>Verify OTP</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Enter OTP:</label><br>
        <input type="text" name="otp" maxlength="6" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
