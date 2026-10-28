<?php
require_once __DIR__ . '/../config/database.php';

function get_all_barang($search = '') {
    global $conn;
    if (!empty($search)) {
        $param = "%" . $search . "%";
        $stmt = mysqli_prepare($conn, "SELECT * FROM barang WHERE kode LIKE ? OR nama LIKE ? OR kategori LIKE ? ORDER BY id DESC");
        mysqli_stmt_bind_param($stmt, "sss", $param, $param, $param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $result = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function get_recent_barang($limit = 5) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM barang ORDER BY id DESC LIMIT ?");
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function get_barang_by_id($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM barang WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function is_kode_exists($kode, $ignore_id = 0) {
    global $conn;
    if ($ignore_id > 0) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM barang WHERE kode = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, "si", $kode, $ignore_id);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM barang WHERE kode = ?");
        mysqli_stmt_bind_param($stmt, "s", $kode);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $count > 0;
}

function insert_barang($kode, $nama, $kategori, $harga, $stok) {
    global $conn;
    $kode = trim($kode);
    $nama = trim($nama);
    $kategori = trim($kategori);

    if (empty($kode) || empty($nama) || empty($kategori) || $harga < 0 || $stok < 0) {
        return ['status' => false, 'message' => 'Semua field wajib diisi dengan benar.'];
    }

    if (is_kode_exists($kode)) {
        return ['status' => false, 'message' => 'Kode barang sudah digunakan.'];
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO barang (kode, nama, kategori, harga, stok) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssii", $kode, $nama, $kategori, $harga, $stok);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return ['status' => true, 'message' => 'Data barang berhasil ditambahkan.'];
    }
    mysqli_stmt_close($stmt);
    return ['status' => false, 'message' => 'Gagal menyimpan data barang.'];
}

function update_barang($id, $kode, $nama, $kategori, $harga, $stok) {
    global $conn;
    $kode = trim($kode);
    $nama = trim($nama);
    $kategori = trim($kategori);

    if (empty($kode) || empty($nama) || empty($kategori) || $harga < 0 || $stok < 0) {
        return ['status' => false, 'message' => 'Semua field wajib diisi dengan benar.'];
    }

    if (is_kode_exists($kode, $id)) {
        return ['status' => false, 'message' => 'Kode barang sudah digunakan oleh data lain.'];
    }

    $stmt = mysqli_prepare($conn, "UPDATE barang SET kode = ?, nama = ?, kategori = ?, harga = ?, stok = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssiii", $kode, $nama, $kategori, $harga, $stok, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return ['status' => true, 'message' => 'Data barang berhasil diperbarui.'];
    }
    mysqli_stmt_close($stmt);
    return ['status' => false, 'message' => 'Gagal memperbarui data barang.'];
}

function delete_barang($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM barang WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $res = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $res;
}

function hitung_ringkasan() {
    global $conn;
    $query = "SELECT COUNT(*) as total_barang, IFNULL(SUM(stok), 0) as total_stok, IFNULL(SUM(harga * stok), 0) as total_nilai FROM barang";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
?>
