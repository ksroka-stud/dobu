<?php
require 'db.php';
session_start();

$error = '';
$success = '';

$stmt = $pdo->query("SELECT membership_id, plan_name, monthly_fee FROM memberships ORDER BY membership_id");
$plans = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $planId = (int)($_POST['plan_id'] ?? 0);

    if ($fullName === '' || $email === '' || $password === '' || $planId < 1) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } else {
        $checkPlan = $pdo->prepare("SELECT membership_id FROM memberships WHERE membership_id = ?");
        $checkPlan->execute([$planId]);

        if (!$checkPlan->fetch()) {
            $error = 'Choose a valid membership plan.';
        } else {
            $checkUser = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $checkUser->execute([$email]);

            if ($checkUser->fetch()) {
                $error = 'That email address is already registered.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $insert = $pdo->prepare("
                    INSERT INTO users (full_name, email, password_hash, membership_id)
                    VALUES (?, ?, ?, ?)
                ");
                $insert->execute([$fullName, $email, $hash, $planId]);

                $success = 'Account created successfully. You can now log in.';
            }
        }
    }
}

include 'header.php';
?>

<h1>Create Account</h1>

<?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" action="register.php">
    <label for="full_name">Full name</label>
    <input id="full_name" name="full_name" type="text"
           value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>

    <label for="email">Email address</label>
    <input id="email" name="email" type="email"
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <label for="plan_id">Membership</label>
    <select id="plan_id" name="plan_id" required>
        <option value="">Choose a plan</option>
        <?php foreach ($plans as $plan): ?>
            <option value="<?= $plan['membership_id'] ?>"
                <?= (($_POST['plan_id'] ?? '') == $plan['membership_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($plan['plan_name']) ?> - £<?= htmlspecialchars($plan['monthly_fee']) ?>/month
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Create account</button>
</form>

<?php include 'footer.php'; ?>