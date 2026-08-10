<?php
// user_dashboard.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM requests WHERE user_id = ?");
$stmt->execute([$userId]);
$totalRequests = $stmt->fetch()['total'];

$stmt = $pdo->prepare("SELECT COUNT(*) AS pending FROM requests WHERE user_id = ? AND status = 'Pending'");
$stmt->execute([$userId]);
$pendingRequests = $stmt->fetch()['pending'];

// ★ FIX: Calculate points directly from completed requests (5 per item)
$stmt = $pdo->prepare("SELECT SUM(quantity * 5) AS total_points FROM requests WHERE user_id = ? AND status = 'Completed'");
$stmt->execute([$userId]);
$points = $stmt->fetch()['total_points'] ?? 0;

$stmt = $pdo->prepare("SELECT request_id, waste_type, quantity, status, request_date FROM requests WHERE user_id = ? ORDER BY request_date DESC LIMIT 5");
$stmt->execute([$userId]);
$recentRequests = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>User Dashboard</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .stat-card { background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .stat-number { font-size: 2rem; font-weight: 700; color: #2e7d32; }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>
    <div class="row mt-4">
        <div class="col-md-3"><div class="stat-card"><i class="fas fa-box fa-2x text-success"></i><div class="stat-number"><?= $totalRequests ?></div><div>Total Requests</div></div></div>
        <div class="col-md-3"><div class="stat-card"><i class="fas fa-clock fa-2x text-warning"></i><div class="stat-number"><?= $pendingRequests ?></div><div>Pending</div></div></div>
        <div class="col-md-3"><div class="stat-card"><i class="fas fa-star fa-2x text-warning"></i><div class="stat-number"><?= $points ?></div><div>Reward Points</div></div></div>
        <div class="col-md-3"><div class="stat-card"><a href="user_submit.php" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i> New Request</a></div></div>
    </div>

    <h4 class="mt-5">Recent Requests</h4>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Waste Type</th><th>Quantity</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            <?php foreach ($recentRequests as $req): ?>
            <tr>
                <td><?= $req['request_id'] ?></td>
                <td><?= htmlspecialchars($req['waste_type']) ?></td>
                <td><?= $req['quantity'] ?></td>
                <td><span class="badge bg-<?= $req['status']=='Pending'?'warning':($req['status']=='Completed'?'success':'info') ?>"><?= $req['status'] ?></span></td>
                <td><?= $req['request_date'] ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($recentRequests)): ?><tr><td colspan="5" class="text-center">No requests yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
    <a href="user_track.php" class="btn btn-outline-success">View All & Track</a>
</div>
<?php include 'footer.php'; ?>
</body>
</html>