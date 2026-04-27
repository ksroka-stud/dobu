<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT u.full_name, u.email, m.plan_name, m.monthly_fee, m.sessions_per_week
    FROM users u
    JOIN memberships m ON u.membership_id = m.membership_id
    WHERE u.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

include 'header.php';
?>

<main>

<h2>Dashboard</h2>

<p>Welcome, <strong><?= htmlspecialchars($user['full_name']) ?></strong>.</p>

<table>
    <tr>
        <th>Email</th>
        <td><?= htmlspecialchars($user['email']) ?></td>
    </tr>
    <tr>
        <th>Current plan</th>
        <td><?= htmlspecialchars($user['plan_name']) ?></td>
    </tr>
    <tr>
        <th>Monthly fee</th>
        <td>£<?= htmlspecialchars($user['monthly_fee']) ?></td>
    </tr>
    <tr>
        <th>Sessions per week</th>
        <td><?= htmlspecialchars($user['sessions_per_week']) ?></td>
    </tr>
</table>

<p><a href="membership.php">Change membership</a></p>

</main>

<?php include 'footer.php'; ?>