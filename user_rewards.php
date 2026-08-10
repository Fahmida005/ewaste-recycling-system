<?php
// user_rewards.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Get all completed requests with quantity
$stmt = $pdo->prepare("SELECT request_id, waste_type, quantity, request_date FROM requests WHERE user_id = ? AND status = 'Completed' ORDER BY request_date DESC");
$stmt->execute([$userId]);
$completed = $stmt->fetchAll();

// Calculate total points from all completed requests
$totalPoints = 0;
foreach ($completed as $c) {
    $totalPoints += $c['quantity'] * 5;
}
?>
<!DOCTYPE html>
<html>
<head><title>My Rewards</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <div class="card bg-success text-white p-4 text-center">
        <h3><i class="fas fa-star"></i> Your Reward Points</h3>
        <div class="display-1"><?= $totalPoints ?></div>
        <p>You earn <strong>5 points</strong> for every item recycled.</p>
    </div>
    <h4 class="mt-4">Recycling History</h4>
    <table class="table table-bordered">
        <thead>
            <tr><th>Request #</th><th>Waste Type</th><th>Quantity</th><th>Points Earned</th><th>Date</th></tr>
        </thead>
        <tbody>
            <?php if (empty($completed)): ?>
                <tr><td colspan="5" class="text-center">No completed recyclings yet.</td></tr>
            <?php else: ?>
                <?php foreach ($completed as $c): ?>
                <tr>
                    <td>#<?= $c['request_id'] ?></td>
                    <td><?= htmlspecialchars($c['waste_type']) ?></td>
                    <td><?= $c['quantity'] ?></td>
                    <td><span class="badge bg-warning"><?= $c['quantity'] * 5 ?></span></td>
                    <td><?= $c['request_date'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>