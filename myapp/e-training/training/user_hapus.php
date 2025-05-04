<?php
include("database/config.php");

if( isset($_GET['id']) ){
    // ambil id dari query string
    $id_user = $_GET['id'];
    
    // Hapus data terkait di form_data terlebih dahulu
    $delete_form_data_query = "DELETE FROM form_data WHERE id_user = $id_user";
    mysqli_query($conn, $delete_form_data_query);

    // Sekarang hapus data dari login
    $query = "DELETE FROM login WHERE id_user=$id_user";
    
    // apakah query hapus berhasil?
    if(mysqli_query($conn, $query)){
        // Set status untuk ditampilkan di halaman setelah penghapusan
        $_SESSION['status'] = "Data berhasil dihapus";
        $_SESSION['status_code'] = "success";
        header('Location: user_acc.php');
        exit();
    } else {
        die("Gagal menghapus...");
    }
} else {
    die("Akses dilarang...");
}
?>
