<?php
// admin_dashboard.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$totalRequests = $pdo->query("SELECT COUNT(*) FROM requests")->fetchColumn();
$pendingRequests = $pdo->query("SELECT COUNT(*) FROM requests WHERE status = 'Pending'")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalCenters = $pdo->query("SELECT COUNT(*) FROM recycling_centers")->fetchColumn();

$recent = $pdo->query("SELECT r.*, u.name AS user_name FROM requests r JOIN users u ON r.user_id = u.id ORDER BY r.request_date DESC LIMIT 10")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>.stat-card { background:#fff; border-radius:16px; padding:20px; box-shadow:0 4px 20px rgba(0,0,0,0.08); }</style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Admin Dashboard</h2>
    <div class="row mt-3">
        <div class="col-md-3"><div class="stat-card"><i class="fas fa-box fa-2x text-primary"></i><div class="display-6"><?= $totalRequests ?></div><div>Total Requests</div></div></div>
        <div class="col-md-3"><div class="stat-card"><i class="fas fa-clock fa-2x text-warning"></i><div class="display-6"><?= $pendingRequests ?></div><div>Pending</div></div></div>
        <div class="col-md-3"><div class="stat-card"><i class="fas fa-users fa-2x text-success"></i><div class="display-6"><?= $totalUsers ?></div><div>Users</div></div></div>
        <div class="col-md-3"><div class="stat-card"><i class="fas fa-building fa-2x text-info"></i><div class="display-6"><?= $totalCenters ?></div><div>Centers</div></div></div>
    </div>

    <h4 class="mt-5">Recent Requests</h4>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>User</th><th>Waste</th><th>Qty</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
            <?php foreach ($recent as $r): ?>
            <tr>
                <td><?= $r['request_id'] ?></td>
                <td><?= htmlspecialchars($r['user_name']) ?></td>
                <td><?= htmlspecialchars($r['waste_type']) ?></td>
                <td><?= $r['quantity'] ?></td>
                <td><span class="badge bg-<?= $r['status']=='Pending'?'warning':'success' ?>"><?= $r['status'] ?></span></td>
                <td><?= $r['request_date'] ?></td>
                <td><a href="admin_manage.php?action=view&id=<?= $r['request_id'] ?>" class="btn btn-sm btn-primary">Manage</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="admin_manage.php" class="btn btn-success">Manage All Requests</a>
    <a href="admin_centers.php" class="btn btn-outline-primary">Manage Centers</a>
    <a href="admin_reports.php" class="btn btn-outline-info">Generate Reports</a>
</div>
<?php include 'footer.php'; ?>
</body>
</html>