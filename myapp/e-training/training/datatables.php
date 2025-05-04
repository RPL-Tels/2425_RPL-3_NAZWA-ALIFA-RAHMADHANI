<?php
        session_start(); // Start the session
        
        if (isset($_SESSION['status'])) {
            echo "<div class='alert alert-{$_SESSION['status_code']}'>";
            echo $_SESSION['status'];
            echo "</div>";
            unset($_SESSION['status']);
            unset($_SESSION['status_code']);
        }
        ?>
<div id="wrapper" class="d-flex">
    <!-- Sidebar -->
    <?php include('includes/navbar.php'); ?>
    
    <!-- Topbar -->
    <?php include('includes/topbar.php'); ?>
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Training</title>
    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                <th>Nama</th>
                <th>ID Pegawai</th>
                <th>Divisi</th>
                <th>Status</th>
                <th>PIC Training</th>
                <th>No Telp PIC</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'database/config.php';
            $request_training = mysqli_query($conn, "SELECT * FROM form_data");
            while ($row = mysqli_fetch_array($request_training)) {
                echo "<tr>
                    <td>{$row['judul_training']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['id_pegawai']}</td>
                    <td>{$row['divisi']}</td>
                    <td>{$row['approval_status']}</td>
                    <td>{$row['pic_lembaga']}</td>
                    <td>{$row['telp_lembaga']}</td>
                    <td>{$row['biaya']}</td>
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
    <?php include('includes/script.php'); ?>
</body>
</html>
