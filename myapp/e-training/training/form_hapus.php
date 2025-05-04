<?php
include("database/config.php");
if( isset($_GET['id_form']) ){
    // ambil id dari query string
    $id_form = $_GET['id_form'];
    // buat query hapus
    $query = "DELETE FROM form_data WHERE id_form=$id_form";
    // apakah query hapus berhasil?
    if(mysqli_query($conn, $query)){
    header('Location: form_data.php');
    } else {
    die("gagal menghapus...");
    }
    } else {
    die("akses dilarang...");
    }
    ?>