<?php
// admin_manage.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];

    if ($action === 'approve') {
        $pdo->prepare("UPDATE requests SET status = 'Approved' WHERE request_id = ?")->execute([$id]);
    } elseif ($action === 'reject') {
        $pdo->prepare("UPDATE requests SET status = 'Rejected' WHERE request_id = ?")->execute([$id]);
    } elseif ($action === 'complete') {
        $pdo->prepare("UPDATE requests SET status = 'Completed' WHERE request_id = ?")->execute([$id]);
        $stmt = $pdo->prepare("SELECT user_id FROM requests WHERE request_id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        if ($user) {
            $pdo->prepare("UPDATE rewards SET points = points + 10 WHERE user_id = ?")->execute([$user['user_id']]);
        }
    } elseif ($action === 'assign' && isset($_POST['center_id'])) {
        $center = (int)$_POST['center_id'];
        $pdo->prepare("UPDATE requests SET center_id = ?, status = 'Approved' WHERE request_id = ?")->execute([$center, $id]);
    }
    header('Location: admin_manage.php');
    exit;
}

$requests = $pdo->query("SELECT r.*, u.name AS user_name, c.center_name FROM requests r JOIN users u ON r.user_id = u.id LEFT JOIN recycling_centers c ON r.center_id = c.center_id ORDER BY r.request_date DESC")->fetchAll();
$centers = $pdo->query("SELECT center_id, center_name FROM recycling_centers")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Manage Requests</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Manage Pickup Requests</h2>
    <table class="table table-bordered table-hover">
        <thead><tr><th>ID</th><th>User</th><th>Waste</th><th>Qty</th><th>Address</th><th>Status</th><th>Center</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($requests as $req): ?>
            <tr>
                <td><?= $req['request_id'] ?></td>
                <td><?= htmlspecialchars($req['user_name']) ?></td>
                <td><?= htmlspecialchars($req['waste_type']) ?></td>
                <td><?= $req['quantity'] ?></td>
                <td><?= htmlspecialchars($req['address']) ?></td>
                <td><span class="badge bg-<?= $req['status']=='Pending'?'warning':($req['status']=='Approved'?'info':'success') ?>"><?= $req['status'] ?></span></td>
                <td><?= htmlspecialchars($req['center_name'] ?? 'Not assigned') ?></td>
                <td><?= $req['request_date'] ?></td>
                <td>
                    <?php if ($req['status'] == 'Pending'): ?>
                        <a href="?action=approve&id=<?= $req['request_id'] ?>" class="btn btn-sm btn-success">Approve</a>
                        <a href="?action=reject&id=<?= $req['request_id'] ?>" class="btn btn-sm btn-danger">Reject</a>
                        <form method="POST" action="?action=assign&id=<?= $req['request_id'] ?>" style="display:inline-block;">
                            <select name="center_id" class="form-select form-select-sm d-inline-block" style="width:auto;">
                                <option value="">Assign Center</option>
                                <?php foreach ($centers as $c): ?>
                                <option value="<?= $c['center_id'] ?>"><?= htmlspecialchars($c['center_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Assign</button>
                        </form>
                    <?php elseif ($req['status'] == 'Approved'): ?>
                        <a href="?action=complete&id=<?= $req['request_id'] ?>" class="btn btn-sm btn-warning">Mark Completed</a>
                    <?php else: ?>
                        <span class="text-muted">No actions</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>