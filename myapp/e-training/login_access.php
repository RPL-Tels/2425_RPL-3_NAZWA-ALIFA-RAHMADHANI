<?php
session_start(); // Mulai sesi

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-training";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil nilai yang dikirimkan dari formulir
$enteredNickname = $_POST['username'];
$enteredPassword = $_POST['pass'];

// Periksa kecocokan username dan password di database
$sql = "SELECT * FROM login WHERE username = '$enteredNickname' AND pass = '$enteredPassword'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data user dari hasil query
    $user = $result->fetch_assoc();

    // Jika login berhasil, set session dan tentukan halaman berdasarkan divisi
    $_SESSION['id_user'] = $user['id_user'];  // Simpan id_user dalam session
    $_SESSION['divisi'] = $user['divisi']; // Simpan divisi dalam session (opsional)

    // Redirect ke dashboard sesuai divisi
    switch ($user['divisi']) {
        case 'FAD':
        case 'IT':
            header('Location: training/karyawan_form.php');
            break;
        case 'HRD':
            header('Location: training/dashboard.php');
            break;
        default:
            // Jika divisi tidak dikenali, arahkan ke halaman error
            header('Location: error.php');
            break;
    }
} else {
    // Login gagal, arahkan kembali ke login dengan pesan error
    header('Location: login.php?status=gagal');
}

$conn->close();
?>
