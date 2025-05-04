<?php
include("database/config.php");

// Cek apakah tombol 'Simpan' ditekan
if (isset($_POST['Simpan'])) {
    // Cek apakah id_form ada
    if (!isset($_POST['id_form']) || empty($_POST['id_form'])) {
        die("ID Form tidak ditemukan.");
    }

    // Ambil data dari formulir
    $id_form = $_POST['id_form'];
    $username = $_POST['username'];
    $divisi = $_POST['divisi'];
    $judul = $_POST['judul_training'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $fungsi = $_POST['fungsi_training'];
    $nm_lembaga = $_POST['nm_lembaga'];
    $lokasi = $_POST['lokasi_lembaga'];
    $pic = $_POST['pic_lembaga'];
    $telp = $_POST['telp_lembaga'];
    $biaya = $_POST['biaya'];

    // Validasi data jika perlu (misalnya tidak boleh kosong, atau formatnya benar)
    if (empty($judul) || empty($tgl_mulai) || empty($tgl_selesai)) {
        die("Judul, Tanggal Mulai, dan Tanggal Selesai tidak boleh kosong.");
    }

    $biaya = str_replace(['Rp', '.', ' '], '', $biaya); // Hapus Rp, titik, dan spasi
    $biaya = trim($biaya); // Pastikan gak ada spasi sisa


    // Query update
    $sql = "UPDATE form_data SET 
            username='$username',
            judul_training='$judul',    
            tgl_mulai='$tgl_mulai',
            tgl_selesai='$tgl_selesai', 
            fungsi_training='$fungsi', 
            nm_lembaga='$nm_lembaga', 
            lokasi_lembaga='$lokasi', 
            pic_lembaga='$pic', 
            telp_lembaga='$telp',
            biaya='$biaya' 
            WHERE id_form=$id_form";

    // Eksekusi query
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Gagal menyimpan perubahan: " . mysqli_error($conn));
    } else {
        header('Location: form_data.php?status=success');
        exit();
    }
} else {
    die("Akses dilarang...");
}
