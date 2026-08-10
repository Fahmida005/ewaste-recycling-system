<?php
// admin_reports.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$wasteByType = $pdo->query("SELECT waste_type, SUM(quantity) AS total_qty FROM requests WHERE status = 'Completed' GROUP BY waste_type")->fetchAll();
$wasteByCenter = $pdo->query("SELECT c.center_name, COUNT(r.request_id) AS total_requests, SUM(r.quantity) AS total_items FROM requests r JOIN recycling_centers c ON r.center_id = c.center_id WHERE r.status = 'Completed' GROUP BY c.center_id")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Reports</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Recycling Reports</h2>
    <div class="row">
        <div class="col-md-6">
            <h5>Waste Collected by Type</h5>
            <table class="table table-sm">
                <thead><tr><th>Type</th><th>Total Quantity</th></tr></thead>
                <tbody>
                    <?php foreach ($wasteByType as $row): ?>
                    <tr><td><?= htmlspecialchars($row['waste_type']) ?></td><td><?= $row['total_qty'] ?></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h5>Performance by Center</h5>
            <table class="table table-sm">
                <thead><tr><th>Center</th><th>Requests</th><th>Total Items</th></tr></thead>
                <tbody>
                    <?php foreach ($wasteByCenter as $row): ?>
                    <tr><td><?= htmlspecialchars($row['center_name']) ?></td><td><?= $row['total_requests'] ?></td><td><?= $row['total_items'] ?></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>