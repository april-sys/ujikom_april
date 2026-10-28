<?php
require_once 'functions/helper.php';
require_once 'functions/barang.php';
check_auth();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: barang.php");
    exit;
}

$barang = get_barang_by_id($id);
if (!$barang) {
    $_SESSION['flash_error'] = 'Data barang tidak ditemukan.';
    header("Location: barang.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Token keamanan tidak valid.';
    } else {
        $kode     = $_POST['kode'] ?? '';
        $nama     = $_POST['nama'] ?? '';
        $kategori = $_POST['kategori'] ?? '';
        $harga    = (int)($_POST['harga'] ?? 0);
        $stok     = (int)($_POST['stok'] ?? 0);

        $res = update_barang($id, $kode, $nama, $kategori, $harga, $stok);
        if ($res['status']) {
            $_SESSION['flash_msg'] = $res['message'];
            header("Location: barang.php");
            exit;
        } else {
            $error = $res['message'];
            $barang['kode'] = $kode;
            $barang['nama'] = $nama;
            $barang['kategori'] = $kategori;
            $barang['harga'] = $harga;
            $barang['stok'] = $stok;
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="table-custom-card p-4">
            <h5 class="mb-3 fw-bold border-bottom pb-2">Edit Data Barang</h5>
            <?php if ($error): ?>
                <div class="alert alert-danger py-2 small mb-3"><?= escape($error); ?></div>
            <?php endif; ?>

            <form action="barang_edit.php?id=<?= $id; ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= generate_csrf_token(); ?>">

                <div class="mb-3">
                    <label for="kode" class="form-label small fw-semibold">Kode Barang</label>
                    <input type="text" name="kode" id="kode" class="form-control" value="<?= escape($barang['kode']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label small fw-semibold">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= escape($barang['nama']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label small fw-semibold">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?= escape($barang['kategori']); ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="harga" class="form-label small fw-semibold">Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" class="form-control" min="0" value="<?= escape($barang['harga']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stok" class="form-label small fw-semibold">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" min="0" value="<?= escape($barang['stok']); ?>" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="barang.php" class="btn btn-outline-secondary btn-sm">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
