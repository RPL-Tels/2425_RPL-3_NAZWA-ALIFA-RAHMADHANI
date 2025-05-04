<?php
session_start();
include('database/config.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

// Ambil data user dari session
$id_user = $_SESSION['id_user'];
$sql = "SELECT username, divisi, id_pegawai FROM login WHERE id_user = '$id_user'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $divisi = $row['divisi'];
    $id_pegawai = $row['id_pegawai'];
} else {
    echo "Nama pengguna tidak ditemukan.";
    exit;
}

// Jika form dikirim
if (isset($_POST['send'])) {
    // Ambil data dari form
    $judul_training = $_POST['judul_training'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $fungsi_training = $_POST['fungsi_training'];
    $narsum = $_POST['narsum'];
    $nm_lembaga = $_POST['nm_lembaga'];
    $lokasi_lembaga = $_POST['lokasi_lembaga'];
    $pic_lembaga = $_POST['pic_lembaga'];
    $telp_lembaga = $_POST['telp_lembaga'];
    $biaya = $_POST['biaya'];

    // Proses upload file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["request"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file
    $check = getimagesize($_FILES["request"]["tmp_name"]);
    if ($check === false) {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    if ($_FILES["request"]["size"] > 5000000) {
        echo "Ukuran file terlalu besar (maks 5MB).";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Format file tidak didukung (hanya JPG/PNG/GIF).";
        $uploadOk = 0;
    }

    // Jika lolos semua validasi
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["request"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO form_data 
                (id_pegawai, id_user, judul_training, tgl_mulai, tgl_selesai, fungsi_training, narsum, divisi, username, nm_lembaga, lokasi_lembaga, pic_lembaga, telp_lembaga, biaya, request)
                VALUES 
                ('$id_pegawai', '$id_user', '$judul_training', '$tgl_mulai', '$tgl_selesai', '$fungsi_training', '$narsum', '$divisi', '$username', '$nm_lembaga', '$lokasi_lembaga', '$pic_lembaga', '$telp_lembaga', '$biaya', '$target_file')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['status'] = 'Data berhasil dikirim';
                $_SESSION['status_code'] = 'success';
                header("Location: history-pengajuan.php");
                exit();
            } else {
                echo "Gagal menyimpan data: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal upload file.";
        }
    } else {
        echo "File tidak lolos validasi.";
    }
}
?>
