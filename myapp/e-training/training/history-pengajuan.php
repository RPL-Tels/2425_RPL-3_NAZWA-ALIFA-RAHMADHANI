<?php
session_start(); // Start the session

// Menampilkan notifikasi jika ada
if (isset($_SESSION['status'])) {
    echo "<div id='notif' class='alert alert-{$_SESSION['status_code']}'>";
    echo $_SESSION['status'];
    echo "</div>";
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>


<div id="wrapper" class="d-flex">
    <!-- Sidebar -->
    <?php include('includes/navbar_karyawan.php'); ?>
    
    <!-- Topbar -->
    <?php include('includes/topbar_karyawan.php'); ?>

    <script>
        // Menyembunyikan notifikasi setelah 3 detik
        setTimeout(function() {
            var notif = document.getElementById('notif');
            if (notif) {
                notif.style.display = 'none';
            }
        }, 3000); // 3000ms = 3 detik
    </script>


    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Training</title>
    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JS DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
  <div class="container-fluid">
    <table id="example" class="display">
        <thead>
            <tr>
                <th>Judul Training</th>
                <th>Mulai Training</th>
                <th>Selesai Training</th>
                <th>Fungsi Training</th>
                <th>Divisi</th>
                <th>Nama Lembaga Training</th>
                <th>Biaya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'database/config.php';
            // Ambil id user dari session
            $user_id = $_SESSION['id_user'];
            // Ambil hanya data training dari user yang sedang login
            $request_training = mysqli_query($conn, "SELECT * FROM form_data WHERE id_user = '$user_id'");
            while ($row = mysqli_fetch_array($request_training)) {
                echo "<tr>
                    <td>{$row['judul_training']}</td>
                    <td>{$row['tgl_mulai']}</td>
                    <td>{$row['tgl_selesai']}</td>
                    <td>{$row['fungsi_training']}</td>
                    <td>{$row['divisi']}</td>
                    <td>{$row['nm_lembaga']}</td>
                    <td>Rp" . number_format($row['biaya'], 0, ',', '.') . ",00</td>
                    <td>{$row['approval_status']}</td>

                </tr>";
            }
            ?>
        </tbody>
    </table>
  </div>
</div>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    

</body>
</html>
