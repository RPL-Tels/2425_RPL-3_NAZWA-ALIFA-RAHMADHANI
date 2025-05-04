<?php
// Konfigurasi database
$servername = "localhost";
$username   = "root"; 
$password   = "";    
$dbname     = "e-training";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
