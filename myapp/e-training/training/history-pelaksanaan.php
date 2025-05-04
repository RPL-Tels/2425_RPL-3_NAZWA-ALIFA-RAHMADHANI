<!-- CSS Links -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php
session_start();

// Display alert message if session status exists
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
    <?php include('includes/navbar_karyawan.php'); ?>

    <!-- Topbar -->
    <?php include('includes/topbar_karyawan.php'); ?>

    <div class="container-fluid">
        <!-- History Section -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">History</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    // Connect to the database
                    $connection = mysqli_connect("localhost", "root", "", "e-training");

                    // Get user ID from session
                    $id_user = $_SESSION['id_user'];

                    // Fetch only the user's own training records with approved status
                    $query = "SELECT * FROM form_data WHERE id_user = '$id_user' AND approval_status = 'Approved'";
                    $query_run = mysqli_query($connection, $query);
                    ?>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul Training</th>
                                <th>Mulai Training</th>
                                <th>Selesai Training</th>
                                <th>Fungsi Training</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>Nama Lembaga</th>
                                <th>Biaya</th>
                                <th>Bukti Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr>
                                        <td><?= $row['judul_training']; ?></td>
                                        <td><?= $row['tgl_mulai']; ?></td>
                                        <td><?= $row['tgl_selesai']; ?></td>
                                        <td><?= $row['fungsi_training']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['divisi']; ?></td>
                                        <td><?= $row['nm_lembaga']; ?></td>
                                        <td>Rp<?= number_format($row['biaya'], 0, ',', '.') . ',00'; ?></td>
                                        <td>
                                            <?php if (empty($row['sertif'])): ?>
                                                <form action="upload_sertif.php" method="post" enctype="multipart/form-data" style="display: inline-block;">
                                                    <input type="hidden" name="id_form" value="<?= $row['id_form']; ?>">
                                                    <input type="file" name="sertif" id="fileInput<?= $row['id_form']; ?>" style="display: none;" onchange="this.form.submit()">
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('fileInput<?= $row['id_form']; ?>').click();">
                                                        <i class="fas fa-upload"></i> Upload
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <img src="uploads/<?= $row['sertif']; ?>" alt="Sertifikat" style="width: 100px; height: auto;">
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='9'>No Record Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/script.php');
    include('includes/footer.php');
    ?>
</div>
