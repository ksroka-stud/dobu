<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoBu Martial Arts - Membership</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; line-height: 1.5; }
        nav a{color: rgb(255, 255, 255);margin: 0 10px;text-decoration: none;font-weight: bold;}
        form { margin: 20px 0; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select, button { margin-top: 6px; padding: 10px; width: 100%; max-width: 420px; }
        .message { padding: 10px 14px; border-radius: 6px; margin: 12px 0; }
        .error { background: #ffe3e3; color: #8a1f1f; }
        .success { background: #e5f7e8; color: #1d6b2a; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        header{background-color: #000000;color: rgb(255, 255, 255);padding: 15px;display: flex;justify-content: space-between;align-items: center;}
    </style>
</head>
<body>
    <header>
        <h1>DoBu Martial Arts</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="membership.php">Membership</a>
                <a href="logout.php">Logout</a>
        <?php endif; ?>
        </nav>
    </header>
<hr>