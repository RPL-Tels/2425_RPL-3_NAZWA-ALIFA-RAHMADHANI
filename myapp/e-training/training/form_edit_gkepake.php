<?php include 'database/config.php'; ?>


<!DOCTYPE html>
<html>

<head>
    <title>Edit Data Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/tes.css">
</head>

<body>
<div id="wrapper" class="d-flex">
    <!-- Sidebar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Topbar -->
    <?php include('includes/topbar.php'); ?>

    <div class="container-fluid">
        <div class="form-request">
            <h2>FORM EDIT REQUEST TRAINING</h2>
        </div>

        <?php
        // Validasi parameter
        if (isset($_GET['id_form'])) {
            $id = mysqli_real_escape_string($conn, $_GET['id_form']);

            // Query data berdasarkan kd_training
            $query = "SELECT * FROM form_data WHERE id_form = '$id'";
            $data = mysqli_query($conn, $query);

            // Cek apakah data ditemukan
            if ($data && mysqli_num_rows($data) > 0) {
                $row = mysqli_fetch_assoc($data);
        ?>
        <!-- Form Edit -->
        <form action="form_e-proses.php" method="post">
            <input type="hidden" name="id_form" value="<?php echo $row['id_form']; ?>">

            <br>
            <div class="form-group">
                <label>Judul Training:</label>
                <input type="text" class="form-control" name="judul_training" value="<?php echo $row['judul_training']; ?>" required>
            </div>

            <div class="form-group">
                <label>Tanggal Mulai Training:</label>
                <input type="date" class="form-control" name="tgl_mulai" value="<?php echo $row['tgl_mulai']; ?>" required>
            </div>

            <div class="form-group">
                <label>Tanggal Selesai Training:</label>
                <input type="date" class="form-control" name="tgl_selesai" value="<?php echo $row['tgl_selesai']; ?>" required>
            </div>

            <div class="form-group">
                <label>Fungsi Training:</label>
                <input type="text" class="form-control" name="fungsi_training" value="<?php echo $row['fungsi_training']; ?>" required>
            </div>

            <div class="form-group">
                <label>Nama Lembaga Training:</label>
                <input type="text" class="form-control" name="nm_lembaga" value="<?php echo $row['nm_lembaga']; ?>" required>
            </div>

            <div class="form-group">
                <label>Lokasi Lembaga Training:</label>
                <input type="text" class="form-control" name="lokasi_lembaga" value="<?php echo $row['lokasi_lembaga']; ?>" required>
            </div>

            <div class="form-group">
                <label>PIC Lembaga:</label>
                <input type="text" class="form-control" name="pic_lembaga" value="<?php echo $row['pic_lembaga']; ?>" required>
            </div>

            <div class="form-group">
                <label>No Telp Lembaga:</label>
                <input type="text" class="form-control" name="telp_lembaga" value="<?php echo $row['telp_lembaga']; ?>" required>
            </div>

            <div class="form-group">
                <label>Biaya:</label>
                <input type="text" class="form-control" name="biaya" value="<?php echo $row['biaya']; ?>" required>
            </div>

            <div class="form-group">
                <label>Requested:</label><br>
                <?php
                $filePath = "" . $row['request']; // Navigate to the correct file path
                if (!empty($row['request']) && file_exists($filePath)) {
                    echo '<img src="' . $filePath . '" width="25%" height="25%">';
                } else {
                    echo "File tidak ditemukan di: " . $filePath;
                }
                ?>
            </div>

            <div class="form-group" style="text-align: left;">
                <input type="submit" value="Simpan" name="Simpan" class="btn btn-primary">
            </div>
        </form>
        <?php
            } else {
                echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Parameter tidak valid!</div>";
        }
        ?>
    </div>
</div>
</body>

</html>
