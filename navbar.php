<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-recycle"></i> E-Waste Manager</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_manage.php">Requests</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_centers.php">Centers</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_reports.php">Reports</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="user_dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="user_submit.php">New Request</a></li>
                        <li class="nav-item"><a class="nav-link" href="user_track.php">Track</a></li>
                        <li class="nav-item"><a class="nav-link" href="user_rewards.php">Rewards</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>