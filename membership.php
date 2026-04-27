<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

$plansStmt = $pdo->query("SELECT membership_id, plan_name, monthly_fee, sessions_per_week FROM memberships ORDER BY membership_id");
$plans = $plansStmt->fetchAll();

$currentStmt = $pdo->prepare("
    SELECT u.full_name, u.membership_id, m.plan_name
    FROM users u
    JOIN memberships m ON u.membership_id = m.membership_id
    WHERE u.user_id = ?
");
$currentStmt->execute([$_SESSION['user_id']]);
$currentUser = $currentStmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPlan = (int)($_POST['membership_id'] ?? 0);

    $checkPlan = $pdo->prepare("SELECT membership_id FROM memberships WHERE membership_id = ?");
    $checkPlan->execute([$newPlan]);

    if (!$checkPlan->fetch()) {
        $error = 'Choose a valid membership plan.';
    } else {
        $update = $pdo->prepare("UPDATE users SET membership_id = ? WHERE user_id = ?");
        $update->execute([$newPlan, $_SESSION['user_id']]);

        header('Location: membership.php?success=' . urlencode('Membership updated successfully.'));
        exit;
    }
}

if (isset($_GET['success'])) {
    $success = $_GET['success'];
}

$currentStmt->execute([$_SESSION['user_id']]);
$currentUser = $currentStmt->fetch();

include 'header.php';
?>

<main>

<h2>Membership Dashboard</h2>

<p>Hello, <strong><?= htmlspecialchars($currentUser['full_name']) ?></strong>.</p>
<p>Your current plan is <strong><?= htmlspecialchars($currentUser['plan_name']) ?></strong>.</p>

<?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" action="membership.php">
    <label for="membership_id">Change membership</label>
    <select id="membership_id" name="membership_id" required>
        <option value="">Choose a plan</option>
        <?php foreach ($plans as $plan): ?>
            <option value="<?= $plan['membership_id'] ?>"
                <?= ($currentUser['membership_id'] == $plan['membership_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($plan['plan_name']) ?> -
                £<?= htmlspecialchars($plan['monthly_fee']) ?>/month -
                <?= htmlspecialchars($plan['sessions_per_week']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="btn1">Update membership</button>
</form>

</main>

<?php include 'footer.php'; ?>