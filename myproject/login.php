<?php
session_start();
require 'db.php';

$error = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Tài khoản admin mặc định
    if ($username === 'admin' && $password === '123456') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'admin';
        header("Location: index.php");
        exit;
    } else {
        $error = "Tài khoản hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0d6efd, #6610f2); }
        .login-card { max-width: 420px; margin: 100px auto; }
    </style>
</head>
<body>
<div class="container">
    <div class="login-card card shadow">
        <div class="card-header bg-primary text-white text-center py-4">
            <h3><i class="fas fa-shield-alt"></i> ADMIN LOGIN</h3>
            <p class="mb-0">Tra cứu phương tiện vi phạm giao thông</p>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Tài khoản</label>
                    <input type="text" name="username" class="form-control" value="admin" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" value="123456" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>
        </div>
        <div class="card-footer text-center text-muted py-3">
            Tài khoản demo: <strong>admin</strong> / <strong>123456</strong>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>