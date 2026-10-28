<?php
require_once __DIR__ . '/../config/database.php';

function register_user($username, $password) {
    global $conn;
    
    $username = trim($username);
    if (empty($username) || empty($password)) {
        return ['status' => false, 'message' => 'Username dan password wajib diisi.'];
    }

    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return ['status' => false, 'message' => 'Username sudah terdaftar.'];
    }
    mysqli_stmt_close($stmt);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return ['status' => true, 'message' => 'Registrasi berhasil, silakan login.'];
    }

    mysqli_stmt_close($stmt);
    return ['status' => false, 'message' => 'Gagal mendaftar, coba lagi.'];
}

function login_user($username, $password) {
    global $conn;

    $username = trim($username);
    if (empty($username) || empty($password)) {
        return ['status' => false, 'message' => 'Username dan password tidak boleh kosong.'];
    }

    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['login_success'] = true;
            mysqli_stmt_close($stmt);
            return ['status' => true];
        }
    }

    mysqli_stmt_close($stmt);
    return ['status' => false, 'message' => 'Username atau password salah.'];
}
?>
