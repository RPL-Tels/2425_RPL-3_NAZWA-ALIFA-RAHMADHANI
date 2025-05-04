<?php
session_start(); // Start the session
include('database/config.php'); // Pastikan koneksi ke database sudah benar

if (isset($_POST['id_form']) && isset($_FILES['sertif'])) {
    $id_form = $_POST['id_form'];
    $target_dir = "uploads/"; // Direktori untuk menyimpan file
    $target_file = $target_dir . basename($_FILES["sertif"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar
    if (getimagesize($_FILES["sertif"]["tmp_name"]) === false) {
        $_SESSION['status'] = "File is not an image.";
        $_SESSION['status_code'] = "danger";
        $uploadOk = 0;
    }

    // Cek ukuran file (maksimal 5MB)
    if ($_FILES["sertif"]["size"] > 5000000) {
        $_SESSION['status'] = "Sorry, your file is too large.";
        $_SESSION['status_code'] = "danger";
        $uploadOk = 0;
    }

    // Hanya izinkan file gambar dengan ekstensi tertentu
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $_SESSION['status'] = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $_SESSION['status_code'] = "danger";
        $uploadOk = 0;
    }

    // Jika semua pengecekan lolos, upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["sertif"]["tmp_name"], $target_file)) {
            // Simpan nama file ke dalam database
            $sertif = basename($_FILES["sertif"]["name"]);
            $query = "UPDATE form_data SET sertif='$sertif' WHERE id_form='$id_form'";
            if (mysqli_query($conn, $query)) {
                // Setelah berhasil, redirect ke karyawan_form.php
                header("Location: history-pelaksanaan.php");
                exit(); 
            } else {
                $_SESSION['status'] = "Error updating database.";
                $_SESSION['status_code'] = "danger";
            }
        } else {
            $_SESSION['status'] = "Sorry, there was an error uploading your file.";
            $_SESSION['status_code'] = "danger";
        }
    }

    header("Location: history_pelaksanaan.php");
    exit();
}
?>
