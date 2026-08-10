<?php
// user_submit.php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waste_type = trim($_POST['waste_type']);
    $quantity = (int)$_POST['quantity'];
    $address = trim($_POST['address']);
    $request_date = date('Y-m-d');

    if (empty($waste_type) || $quantity <= 0 || empty($address)) {
        $message = 'Please fill all fields correctly.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO requests (user_id, waste_type, quantity, address, request_date, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
        if ($stmt->execute([$userId, $waste_type, $quantity, $address, $request_date])) {
            $message = 'Request submitted successfully!';
        } else {
            $message = 'Failed to submit. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Submit Request</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4" style="max-width: 600px;">
    <h2><i class="fas fa-plus-circle text-success"></i> Submit E-Waste Request</h2>
    <?php if ($message): ?><div class="alert alert-info"><?= $message ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3"><label>Waste Type</label><input type="text" name="waste_type" class="form-control" placeholder="e.g., Laptop, Mobile, Battery" required></div>
        <div class="mb-3"><label>Quantity</label><input type="number" name="quantity" class="form-control" min="1" required></div>
        <div class="mb-3"><label>Pickup Address</label><textarea name="address" class="form-control" rows="3" required></textarea></div>
        <button type="submit" class="btn btn-success">Submit Request</button>
        <a href="user_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>