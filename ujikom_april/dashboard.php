<?php
require_once 'functions/helper.php';
require_once 'functions/barang.php';
check_auth();

$summary = hitung_ringkasan();
$recent_barang = get_recent_barang(5);

include 'includes/header.php';
?>

<?php if (isset($_SESSION['login_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4 py-2" role="alert">
        Login berhasil.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-1">Halo, <?= escape($_SESSION['username']); ?></h3>
        <p class="text-muted small mb-0">Ringkasan inventaris barang saat ini</p>
    </div>
    <div class="d-flex gap-2">
        <a href="barang.php" class="btn btn-outline-primary btn-sm px-3"><i class="bi bi-box me-1"></i> Data Barang</a>
        <a href="laporan.php" class="btn btn-primary btn-sm px-3"><i class="bi bi-file-earmark-text me-1"></i> Lihat Laporan</a>
    </div>
</div>

<!-- 3 Stat Cards replicated from Pict 1 -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-stat-box">
            <span class="icon-badge"><i class="bi bi-tag"></i></span>
            <div class="text-muted small mb-1">Jumlah Jenis Barang</div>
            <div class="h3 fw-bold mb-0 text-dark"><?= number_format($summary['total_barang'], 0, ',', '.'); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat-box">
            <span class="icon-badge"><i class="bi bi-boxes"></i></span>
            <div class="text-muted small mb-1">Total Stok Barang</div>
            <div class="h3 fw-bold mb-0 text-dark"><?= number_format($summary['total_stok'], 0, ',', '.'); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat-box">
            <span class="icon-badge"><i class="bi bi-wallet2"></i></span>
            <div class="text-muted small mb-1">Total Nilai Inventaris</div>
            <div class="h3 fw-bold mb-0 text-dark">Rp <?= number_format($summary['total_nilai'], 0, ',', '.'); ?></div>
        </div>
    </div>
</div>

<!-- Barang Terbaru Table Section replicated from Pict 1 -->
<div class="table-custom-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0">Barang Terbaru</h5>
            <small class="text-muted">Beberapa barang yang terakhir ditambahkan</small>
        </div>
        <a href="barang.php" class="text-primary small text-decoration-none">Lihat Seluruh Data</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle small mb-0">
            <thead class="table-light">
                <tr>
                    <th width="40">#</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Stok</th>
                    <th class="text-end">Nilai Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($recent_barang) > 0): ?>
                    <?php $no = 1; foreach ($recent_barang as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="text-primary fw-semibold"><?= escape($row['kode']); ?></td>
                            <td><?= escape($row['nama']); ?></td>
                            <td><?= escape($row['kategori']); ?></td>
                            <td class="text-end">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="text-end"><?= number_format($row['stok'], 0, ',', '.'); ?></td>
                            <td class="text-end">Rp <?= number_format($row['harga'] * $row['stok'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">Belum ada data barang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
