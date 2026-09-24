<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["reset_email"]) || !isset($_SESSION["otp_verified"])) {
    header("Location: forgot_password.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = md5($_POST["password"]); // use password_hash() in production
    $email = $_SESSION["reset_email"];

    $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);
    if ($stmt->execute()) {
        unset($_SESSION["reset_email"], $_SESSION["otp_verified"]);
        $success = "Password updated successfully. <a href='admin_login.php'>Login</a>";
    } else {
        $error = "Error updating password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Reset Password</title></head>
<body>
    <h2>Reset Password</h2>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>New Password:</label><br>
        <input type="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
