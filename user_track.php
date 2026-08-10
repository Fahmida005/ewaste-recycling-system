<?php
// user_track.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT r.*, rc.center_name FROM requests r LEFT JOIN recycling_centers rc ON r.center_id = rc.center_id WHERE r.user_id = ? ORDER BY r.request_date DESC");
$stmt->execute([$userId]);
$requests = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Track Requests</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Your Pickup Requests</h2>
    <table class="table table-bordered table-striped">
        <thead><tr><th>ID</th><th>Waste Type</th><th>Quantity</th><th>Address</th><th>Status</th><th>Assigned Center</th><th>Date</th></tr></thead>
        <tbody>
            <?php foreach ($requests as $req): ?>
            <tr>
                <td><?= $req['request_id'] ?></td>
                <td><?= htmlspecialchars($req['waste_type']) ?></td>
                <td><?= $req['quantity'] ?></td>
                <td><?= htmlspecialchars($req['address']) ?></td>
                <td><span class="badge bg-<?= $req['status']=='Pending'?'warning':($req['status']=='Approved'?'info':'success') ?>"><?= $req['status'] ?></span></td>
                <td><?= htmlspecialchars($req['center_name'] ?? 'Not assigned') ?></td>
                <td><?= $req['request_date'] ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($requests)): ?><tr><td colspan="7" class="text-center">No requests found.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>