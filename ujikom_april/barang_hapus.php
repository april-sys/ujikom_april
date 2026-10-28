<?php
require_once 'functions/helper.php';
require_once 'functions/barang.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    $id    = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!verify_csrf_token($token)) {
        $_SESSION['flash_error'] = 'Token tidak valid.';
    } elseif ($id) {
        if (delete_barang($id)) {
            $_SESSION['flash_msg'] = 'Data barang berhasil dihapus.';
        } else {
            $_SESSION['flash_error'] = 'Gagal menghapus data barang.';
        }
    }
}

header("Location: barang.php");
exit;
?>
