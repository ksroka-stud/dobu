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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <style>
        html, body{height: 100%;margin: 0;}
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; line-height: 1.5; display: flex; flex-direction: column; min-height: 100vh; background-color: #f4f4f4;}
        header{background-color: #000000;color: rgb(255, 255, 255);padding: 15px;display: flex;justify-content: space-between;align-items: center;}
        header h1{margin:0}
        h1{color:rgb(255, 255, 255)}
        nav a{color: rgb(255, 255, 255);margin: 0 10px;text-decoration: none;font-weight: bold;}
        .container{text-align: center; padding: 40px; flex: 1;}
        footer{position: static; bottom: 0; background-color: #111; color: white; text-align: center; padding: 18px; margin-top: 20px;}
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