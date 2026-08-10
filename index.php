<?php
// index.php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Waste Recycling Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; }
        .hero { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); padding: 80px 0; border-radius: 0 0 60px 60px; }
        .btn-primary-custom { background: #2e7d32; color: #fff; border: none; padding: 12px 32px; border-radius: 30px; font-weight: 600; }
        .btn-primary-custom:hover { background: #1b5e20; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-recycle"></i> E-Waste Manager</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-light text-dark px-4 py-2 rounded-pill fw-bold ms-2" href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero text-center">
        <div class="container">
            <h1 class="display-3 fw-bold text-success-dark">Recycle E‑Waste, Earn Rewards</h1>
            <p class="lead">Submit your electronic waste pickup request and track its journey to recycling.</p>
            <a href="register.php" class="btn btn-primary-custom mt-3"><i class="fas fa-recycle me-2"></i>Get Started</a>
        </div>
    </div>

    <div class="container my-5">
        <div class="row text-center">
            <div class="col-md-4"><i class="fas fa-box fa-3x text-success"></i><h5>Submit Request</h5><p>Add waste details and pickup address.</p></div>
            <div class="col-md-4"><i class="fas fa-truck fa-3x text-success"></i><h5>Track Status</h5><p>Know if it's pending, approved, picked, or recycled.</p></div>
            <div class="col-md-4"><i class="fas fa-star fa-3x text-warning"></i><h5>Earn Rewards</h5><p>Get points for every successful recycling.</p></div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>