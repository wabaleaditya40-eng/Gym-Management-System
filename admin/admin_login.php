<?php
session_start();
require_once "config.php";

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $username = $conn->real_escape_string($username);
        $password = md5($password);

        $sql = "SELECT admin_id, full_name, role FROM admins WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_role'] = $admin['role'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $message = "Invalid username or password.";
        }
    } else {
        $message = "Please enter both username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - Gym Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
/* Reset */
* { margin: 0; padding: 0; box-sizing: border-box; }

body, html {
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(120deg, #0f0c29, #302b63, #24243e);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

/* Animated Background Circles */
body::before {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.05), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05), transparent 40%);
    animation: rotate 30s linear infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Login Box */
.login-container {
    position: relative;
    z-index: 1;
    background: rgba(0, 0, 0, 0.85);
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 0 30px rgba(0,0,0,0.7);
    width: 360px;
    color: #fff;
    backdrop-filter: blur(10px);
}

.login-container h2 {
    text-align: center;
    margin-bottom: 30px;
    font-weight: 600;
    color: #ff9800;
}

.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 14px;
    margin-bottom: 20px;
    border: none;
    border-radius: 8px;
    background: rgba(255,255,255,0.1);
    color: #fff;
    font-size: 16px;
    transition: background 0.3s;
}

.login-container input[type="text"]:focus,
.login-container input[type="password"]:focus {
    background: rgba(255,255,255,0.2);
    outline: none;
}

.login-container button {
    width: 100%;
    padding: 14px;
    background: #ff9800;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.login-container button:hover {
    background: #e68900;
}

.error-msg {
    color: #ff5252;
    text-align: center;
    margin-bottom: 20px;
    font-weight: 500;
}
</style>
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <?php if ($message): ?>
        <div class="error-msg"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>

        <div style="text-align: center; margin-top: 15px;">
    <a href="forgot_password.php" style="color: #ff9800; text-decoration: none; font-size: 14px;">
        <!--Forgot Password? -->
    </a>
</div>

    </form>
</div>
</body>
</html>
