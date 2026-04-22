<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="css/style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoBu Martial Arts - Account</title>
</head>
<body>
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
<hr>