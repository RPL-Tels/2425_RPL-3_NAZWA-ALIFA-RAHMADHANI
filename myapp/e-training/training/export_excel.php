<?php
require 'vendor/autoload.php';
include("database/config.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Ambil data dari database yang status-nya bukan Pending
$sql = "SELECT * FROM form_data WHERE approval_status != 'Pending'";
$result = $conn->query($sql);

if ($result->num_rows <= 0) {
    exit("Data tidak ditemukan.");
}

// Buat spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul dan tanggal
$sheet->setCellValue('A1', 'LAPORAN REKAPITULASI PENDAFTARAN TRAINING');
$sheet->mergeCells('A1:I1');
$sheet->setCellValue('A2', 'Print Date: ' . date('d-m-Y'));
$sheet->mergeCells('A2:I2');

// Header tabel
$headers = ['No', 'Judul Training', 'Mulai Training', 'Selesai Training', 'Nama Pengaju Training', 'Divisi', 'Lembaga Training', 'Lokasi Training', 'Biaya Training', 'Status'];
$sheet->fromArray($headers, NULL, 'A4');

// Isi data
$row = 5;
$no = 1;
while ($data = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $data['judul_training']);
    $sheet->setCellValue('C' . $row, $data['tgl_mulai']);
    $sheet->setCellValue('D' . $row, $data['tgl_selesai']);
    $sheet->setCellValue('E' . $row, $data['username']);
    $sheet->setCellValue('F' . $row, $data['divisi']);
    $sheet->setCellValue('G' . $row, $data['nm_lembaga']);
    $sheet->setCellValue('H' . $row, $data['lokasi_lembaga']);
    $sheet->setCellValue('I' . $row, $data['biaya']);
    $sheet->setCellValue('J' . $row, $data['approval_status']);
    $row++;
}

// Auto-size
foreach (range('A', 'I') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Output langsung download
$customName = isset($_POST['filename']) ? $_POST['filename'] : 'rekap_training';
$filename = $customName . '.xlsx';
$path = __DIR__ . '/exports/' . $filename;

$writer = new Xlsx($spreadsheet);
$writer->save($path);

// Redirect ke file itu
header("Location: exports/$filename");
exit;
?>
