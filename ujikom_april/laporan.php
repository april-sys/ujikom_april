<?php
require_once 'functions/helper.php';
require_once 'functions/barang.php';
check_auth();

$data_barang = get_all_barang();
$summary = hitung_ringkasan();

include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Laporan Inventaris</h4>
        <p class="text-muted small mb-0">Pratinjau laporan data barang dan opsi cetak PDF.</p>
    </div>
    <a href="cetak_laporan.php" target="_blank" class="btn btn-primary btn-sm px-3"><i class="bi bi-printer me-1"></i> Cetak PDF</a>
</div>

<div class="table-custom-card p-4 mb-4">
    <div class="row border-bottom pb-3 mb-3">
        <div class="col-md-4">
            <span class="text-muted small">Total Jenis Barang:</span>
            <div class="fw-bold fs-5 text-dark"><?= number_format($summary['total_barang'], 0, ',', '.'); ?></div>
        </div>
        <div class="col-md-4">
            <span class="text-muted small">Total Stok:</span>
            <div class="fw-bold fs-5 text-dark"><?= number_format($summary['total_stok'], 0, ',', '.'); ?></div>
        </div>
        <div class="col-md-4">
            <span class="text-muted small">Total Nilai Barang:</span>
            <div class="fw-bold fs-5 text-dark">Rp <?= number_format($summary['total_nilai'], 0, ',', '.'); ?></div>
        </div>
    </div>

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
                    <th class="text-end">Total Nilai</th>
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
                            <td class="text-end">Rp <?= number_format($row['harga'] * $row['stok'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">Tidak ada data untuk dilaporkan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
