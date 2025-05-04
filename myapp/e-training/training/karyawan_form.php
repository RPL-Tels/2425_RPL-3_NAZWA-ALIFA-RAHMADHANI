<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Request Training</title>
    <link rel="stylesheet" type="text/css" href="css/form.css">

    <style>
        /* Grid layout for left and right sections */
        .form-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }   

        /* Form group styling */
        .form-group {
            margin-bottom: 15px;
        }

        /* Table styling */
        .table-form {
            width: 100%;
            border-collapse: collapse;
        }

        .table-form td {
            padding: 10px;
            vertical-align: top;
        }

        .input-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        .btn-send {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-send:hover {   
            background-color: #0056b3;
        }

    h2 {
        font-family: 'Poppins', Arial, sans-serif;
        font-weight: bold;
    }

    </style>
</head>
<body>
    <div id="wrapper" class="d-flex">
        <!-- Sidebar -->
        <?php include('includes/navbar_karyawan.php'); ?>

        <!-- Topbar -->
        <?php include('includes/topbar_karyawan.php'); ?>

        <div class="container-fluid">
            <!-- Menampilkan notifikasi jika ada -->
            <?php
if (isset($_SESSION['status'])) {
    echo "<div id='status-alert' class='alert alert-{$_SESSION['status_code']} fade show' role='alert'>"
       . htmlspecialchars($_SESSION['status']) . "</div>";
    unset($_SESSION['status'], $_SESSION['status_code']);
}
?>

<div style="text-align: center;">
    <span class="navbar-text" style="font-size: 28px; font-weight: bold; color: black;">
        Form Request Training
    </span>
</div>
            <form action="k-request.php" method="post" enctype="multipart/form-data">
                <div class="form-container">
                    <!-- Kolom Kiri -->
                    <div class="form-left">
                        <table class="table-form"><br>
                            <tr>
                                <td>Judul Training</td>
                                <td><input type="text" name="judul_training" required class="input-control"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Mulai Training</td>
                                <td><input type="date" required name="tgl_mulai" class="input-control"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai Training</td>
                                <td><input type="date" required name="tgl_selesai" class="input-control"></td>
                            </tr>
                            <tr>
                                <td>Fungsi Training</td>
                                <td><input type="text" name="fungsi_training" required class="input-control"></td>
                            </tr>
                            <tr>
                                <td>Narasumber</td>
                                <td><input type="text" name="narsum" required class="input-control"></td>
                            </tr>
                            <tr>
                                <td>Nama Lembaga Training</td>
                                <td><input type="text" name="nm_lembaga" class="input-control"></td>
                            </tr>
                            
                        </table>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="form-right">
                        <table class="table-form"><br>
                            <tr>
                                <td>Lokasi Training </td>
                                <td><input type="text" name="lokasi_lembaga" class="input-control">
                                <br> 
                                <span style="color: red; font-size:15px;">*Apabila Online, dapat ditulis "Online" saja dengan via yang digunakan.</span>
                            </td>
                            </tr>
                            <tr>
                                <td>PIC Training</td>
                                <td><input type="text" name="pic_lembaga" class="input-control"></td>
                            </tr>
                            <tr>
                                <td>No Telepon PIC</td>
                                <td><input type="text" name="telp_lembaga" class="input-control"></td>
                            </tr>
                            <tr>
                                <td>Biaya</td>
                                <td><input type="text" name="biaya" class="input-control"></td>
                            </tr>
                            <tr>
                                <td>Bukti Informasi Training</td>
                                <td><input type="file" name="request">
                                <br> 
                                <span style="color: red; font-size:15px;">Ekstensi yang diberbolehkan hanya .png , .jpg & .jpeg</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="margin-right: 15px;"></td>
                                <td colspan="2"><button type="submit" name="send" class="btn-send">Send</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>

        <?php
        include('includes/script.php');
        include('includes/footer.php');
        ?>
    </div>
</body>
</html>
