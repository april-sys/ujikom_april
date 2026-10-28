<?php
require_once 'functions/helper.php';
require_once 'functions/auth.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Token keamanan tidak valid.';
    } else {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $res = login_user($username, $password);
        if ($res['status']) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = $res['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventaris Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f4f6; }
        .card-auth { max-width: 400px; margin: 80px auto; border-radius: 8px; border: 1px solid #e5e7eb; }
        .btn-primary-custom { background-color: #2563eb; border-color: #2563eb; color: #fff; }
        .btn-primary-custom:hover { background-color: #1d4ed8; border-color: #1d4ed8; }
    </style>
</head>
<body>

<div class="container">
    <div class="card card-auth shadow-sm">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-4 fw-bold">Login System</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger py-2 small"><?= escape($error); ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= generate_csrf_token(); ?>">
                <div class="mb-3">
                    <label for="username" class="form-label small fw-semibold">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label small fw-semibold">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary-custom w-100 mt-2">Login</button>
            </form>
            <div class="text-center mt-3">
                <small class="text-muted">Belum punya akun? <a href="register.php" class="text-primary fw-semibold">Daftar sekarang</a></small>
            </div>
        </div>
    </div>
</div>

</body>
</html>
