<?php
require 'db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Enter your email address and password.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } else {
        $stmt = $pdo->prepare("
            SELECT user_id, full_name, password_hash
            FROM users
            WHERE email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];

            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Email or password not recognised.';
        }
    }
}

include 'header.php';
?>

<main>
<h1>Login</h1>

<?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="login.php">
    <label for="email">Email address</label>
    <input id="email" name="email" type="email"
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <button type="submit">Sign in</button>
</form>

</main>

<?php include 'footer.php'; ?>