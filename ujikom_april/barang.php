<?php
require_once 'functions/helper.php';
require_once 'functions/barang.php';
check_auth();

$search = $_GET['search'] ?? '';
$data_barang = get_all_barang($search);

include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Barang</h4>
        <p class="text-muted small mb-0">Kelola master data barang inventaris.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="barang_tambah.php" class="btn btn-primary btn-sm px-3">+ Tambah Barang</a>
        <a href="cetak_laporan.php" target="_blank" class="btn btn-outline-secondary btn-sm px-3"><i class="bi bi-printer me-1"></i> Cetak PDF</a>
    </div>
</div>

<?php if (isset($_SESSION['flash_msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show py-2 small mb-3" role="alert">
        <?= escape($_SESSION['flash_msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['flash_msg']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show py-2 small mb-3" role="alert">
        <?= escape($_SESSION['flash_error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<div class="table-custom-card p-3">
    <form action="barang.php" method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kode, nama, atau kategori..." value="<?= escape($search); ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
        </div>
        <?php if (!empty($search)): ?>
            <div class="col-auto">
                <a href="barang.php" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle small mb-0">
            <thead class="table-light">
                <tr>
                    <th width="40" class="text-center">No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Stok</th>
                    <th width="140" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data_barang) > 0): ?>
                    <?php $no = 1; foreach ($data_barang as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-primary fw-semibold"><?= escape($row['kode']); ?></td>
                            <td><?= escape($row['nama']); ?></td>
                            <td><?= escape($row['kategori']); ?></td>
                            <td class="text-end">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="text-end"><?= number_format($row['stok'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <a href="barang_edit.php?id=<?= $row['id']; ?>" class="btn btn-outline-primary btn-sm py-0 px-2">Edit</a>
                                <form action="barang_hapus.php" method="POST" class="d-inline" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">Data barang tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
