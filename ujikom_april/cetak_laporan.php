<?php
require_once 'functions/helper.php';
require_once 'functions/barang.php';
require_once 'fpdf/fpdf.php';

check_auth();

$data = get_all_barang();

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 7, 'LAPORAN DATA INVENTARIS BARANG', 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 5, 'Tanggal Cetak: ' . date('d-m-Y H:i'), 0, 1, 'C');
        $this->Ln(6);

        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(10, 7, 'No', 1, 0, 'C', true);
        $this->Cell(30, 7, 'Kode', 1, 0, 'C', true);
        $this->Cell(60, 7, 'Nama Barang', 1, 0, 'C', true);
        $this->Cell(35, 7, 'Kategori', 1, 0, 'C', true);
        $this->Cell(30, 7, 'Harga', 1, 0, 'C', true);
        $this->Cell(25, 7, 'Stok', 1, 1, 'C', true);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

$no = 1;
$total_seluruh = 0;

foreach ($data as $row) {
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(30, 6, $row['kode'], 1, 0, 'L');
    $pdf->Cell(60, 6, $row['nama'], 1, 0, 'L');
    $pdf->Cell(35, 6, $row['kategori'], 1, 0, 'L');
    $pdf->Cell(30, 6, 'Rp ' . number_format($row['harga'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(25, 6, number_format($row['stok'], 0, ',', '.'), 1, 1, 'R');
    
    $total_seluruh += ($row['harga'] * $row['stok']);
}

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(135, 7, 'Total Nilai Inventaris', 1, 0, 'R');
$pdf->Cell(55, 7, 'Rp ' . number_format($total_seluruh, 0, ',', '.'), 1, 1, 'R');

$pdf->Output('I', 'laporan_barang.pdf');
?>
