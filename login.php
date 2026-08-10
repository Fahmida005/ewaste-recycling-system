<?php
// login.php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: user_dashboard.php');
            }
            exit;
        } else {
            // Check admin table (plaintext for demo)
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();
            if ($admin && $password === $admin['password']) {
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['name'] = $admin['username'];
                $_SESSION['role'] = 'admin';
                header('Location: admin_dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
<div class="container mt-5" style="max-width: 400px;">
    <h2 class="text-center"><i class="fas fa-sign-in-alt text-success"></i> Login</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3"><label>Email or Username</label><input type="text" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
        <button type="submit" class="btn btn-success w-100">Login</button>
    </form>
    <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
</div>
</body>
</html>