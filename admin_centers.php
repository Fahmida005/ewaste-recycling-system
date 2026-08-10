<?php
// admin_centers.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_center'])) {
    $name = trim($_POST['center_name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    if (!empty($name) && !empty($address)) {
        $pdo->prepare("INSERT INTO recycling_centers (center_name, address, phone) VALUES (?, ?, ?)")->execute([$name, $address, $phone]);
    }
    header('Location: admin_centers.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM recycling_centers WHERE center_id = ?")->execute([$id]);
    header('Location: admin_centers.php');
    exit;
}

$centers = $pdo->query("SELECT * FROM recycling_centers")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Manage Centers</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Recycling Centers</h2>
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-3"><input type="text" name="center_name" class="form-control" placeholder="Center Name" required></div>
        <div class="col-md-4"><input type="text" name="address" class="form-control" placeholder="Address" required></div>
        <div class="col-md-3"><input type="text" name="phone" class="form-control" placeholder="Phone"></div>
        <div class="col-md-2"><button type="submit" name="add_center" class="btn btn-success w-100">Add Center</button></div>
    </form>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Name</th><th>Address</th><th>Phone</th><th>Action</th></tr></thead>
        <tbody>
            <?php foreach ($centers as $c): ?>
            <tr>
                <td><?= $c['center_id'] ?></td>
                <td><?= htmlspecialchars($c['center_name']) ?></td>
                <td><?= htmlspecialchars($c['address']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><a href="?delete=<?= $c['center_id'] ?>" onclick="return confirm('Delete this center?')" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>