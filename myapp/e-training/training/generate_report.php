<?php
require('tcpdf/tcpdf.php');
include("database/config.php");

// Mengatur zona waktu Indonesia (WIB)
date_default_timezone_set('Asia/Jakarta');
session_start();
ob_start(); // Mulai output buffer

// Ambil data dari database yang status-nya bukan Pending
$sql = "SELECT * FROM form_data WHERE approval_status != 'Pending'";
$result = $conn->query($sql);

// Cek apakah data ditemukan
if ($result->num_rows <= 0) { // Periksa apakah tidak ada data
    ob_end_clean(); // Bersihkan buffer jika ada
    exit("Data tidak ditemukan.");
}

// Inisialisasi PDF
$pdf = new TCPDF('L', 'mm', 'A3');
$pdf->setPrintHeader(false); // Menonaktifkan header bawaan
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

// Header
$pdf->SetFont('helvetica', 'B', 20);

$logoX = 15; // Posisi X untuk logo
$logoY = 10; // Posisi Y untuk logo
$logoWidth = 35; // Lebar logo (sesuaikan dengan ukuran logo kamu)
$logoHeight = 35; // Tinggi logo (sesuaikan dengan ukuran logo kamu)

// Menambahkan logo
$pdf->Image('logo intikom.jpg', $logoX, $logoY, $logoWidth, $logoHeight);

// Pindahkan posisi ke kanan setelah logo

$pdf->Ln(5);
$pdf->Cell(0, 10, 'PT INTIKOM BERLIAN MUSTIKA', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 13);
$pdf->Cell(0, 10, 'Graha Intikom, Jl. Kuningan Barat II No.11, RT.3/RW.2, West Kuningan, Mampang Prapatan, South Jakarta City, Jakarta 12710', 0, 1,'C');
$pdf->SetY(32);
$pdf->Cell(0, 10, 'Telp. (021) 52971700', 0, 1,'C');

// Menambahkan garis bawah header
$pdf->Ln(5);
$pdf->Cell(0, 1, '', 'B', 1, 'C');

// Judul laporan
$pdf->SetFont('helvetica', 'B', 17);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'LAPORAN REKAPITULASI PENDAFTARAN TRAINING', 0, 1, 'C');

// Tambahkan jarak vertikal
$pdf->Ln(10);

// Header tabel
$pdf->SetFillColor(200, 200, 200); // Warna latar belakang header tabel
$pdf->SetFont('helvetica', '', 12); // Ubah angka kedua (misalnya 10) untuk mengatur ukuran font
$pdf->Cell(0, 10, 'Print Date: ' . date('d-m-Y'), 0, 1, 'L');
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(18, 10, 'No', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Judul Training', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Mulai Training', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Selesai Training', 1, 0, 'C', 1);
$pdf->Cell(60, 10, 'Nama Pengaju Training', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Divisi', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Lembaga Training', 1, 0, 'C', 1);
$pdf->Cell(80, 10, 'Lokasi Training', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Biaya Training', 1, 1, 'C', 1);

// Fungsi untuk menghitung jumlah baris yang dibutuhkan untuk teks dalam MultiCell
// Fungsi untuk menghitung jumlah baris yang dibutuhkan untuk teks dalam MultiCell
function getNumLines($pdf, $text, $width)
{
    $nb = 0;
    $maxWidth = $width - $pdf->getStringWidth(' '); // Mengurangi margin kiri dan kanan
    $words = explode(' ', $text);
    $line = '';
    foreach ($words as $word) {
        $testLine = $line . ' ' . $word;
        $lineWidth = $pdf->GetStringWidth($testLine);
        if ($lineWidth > $maxWidth) {
            $nb++;
            $line = $word;
        } else {
            $line = $testLine;
        }
    }
    if (strlen($line) > 0) {
        $nb++;
    }
    return $nb;
}

// Isi tabel
$pdf->SetFont('helvetica', '', 12);
$no = 1;
while ($row = $result->fetch_assoc()) {
    // Tentukan tinggi maksimum untuk semua sel dalam satu baris
    $cellHeight = 6; // Tinggi minimum tiap baris
    $lineCount = max(
        getNumLines($pdf, $row['judul_training'], 40),
        getNumLines($pdf, $row['tgl_mulai'], 40),
        getNumLines($pdf, $row['tgl_selesai'], 40),
        getNumLines($pdf, $row['username'], 60),
        getNumLines($pdf, $row['divisi'], 30),
        getNumLines($pdf, $row['nm_lembaga'], 50),
        getNumLines($pdf, $row['lokasi_lembaga'], 80),
        $pdf->getNumLines('Rp ' . number_format($row['biaya'], 0, ',', '.'), 40)

    );

    $rowHeight = $lineCount * $cellHeight; // Hitung tinggi row berdasarkan konten

    // Mulai cetak isi tabel dengan tinggi yang disesuaikan
    $pdf->Cell(18, $rowHeight, $no++, 1, 0, 'C');
    $pdf->MultiCell(40, $rowHeight, $row['judul_training'], 1, 'C', 0, 0);
    $pdf->MultiCell(40, $rowHeight, $row['tgl_mulai'], 1, 'C', 0, 0);
    $pdf->MultiCell(40, $rowHeight, $row['tgl_selesai'], 1, 'C', 0, 0);
    $pdf->MultiCell(60, $rowHeight, $row['username'], 1, 'C', 0, 0);
    $pdf->MultiCell(30, $rowHeight, $row['divisi'], 1, 'C', 0, 0);
    $pdf->MultiCell(50, $rowHeight, $row['nm_lembaga'], 1, 'C', 0, 0);
    $pdf->MultiCell(80, $rowHeight, $row['lokasi_lembaga'], 1, 'C', 0, 0);
    $pdf->Cell(40, $rowHeight, 'Rp ' . number_format($row['biaya'], 0, ',', '.'), 1, 1, 'C');
}

// Menambahkan teks "Mengetahui" dan "Human Resource Development"
$pdf->Ln(10); // Menambahkan jarak sebelum teks
$pdf->SetFont('helvetica', '', 12); // Atur font untuk teks ini
$pdf->Cell(364, 10, 'Mengetahui,', 0, 1, 'R'); // Menambahkan "Mengetahui"
$pdf->Cell(0, 10, 'Human Resource Development', 0, 1, 'R'); // Menambahkan "Mengetahui"
$pdf->Ln(20); // Tambahkan jarak untuk tanda tangan
$pdf->Cell(368, 10, 'Emilia Korwel', 0, 1, 'R'); // Nama penandatangan

// Footer
$pdf->SetY(-20);
$pdf->SetFont('helvetica', 'I', 8);

$divisi_footer = 'HRD'; // Tetapkan teks "HRD" secara langsung
$pdf->Cell(0, 10, 'Divisi: ' . $divisi_footer, 0, 0, 'L');
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'R');

// Tutup dan output PDF 
$pdf->Output('Data.pdf', 'I');
?>
