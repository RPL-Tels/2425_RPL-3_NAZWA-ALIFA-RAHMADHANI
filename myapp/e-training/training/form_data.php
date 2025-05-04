<?php
session_start();

// Koneksi ke database
$connection = mysqli_connect("localhost", "root", "", "e-training");

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_form']) && isset($_POST['approval_status'])) {
    $id_form = $_POST['id_form'];
    $approval_status = $_POST['approval_status'];

    // Validasi nilai approval_status
    if (in_array($approval_status, ['Approved', 'Rejected'])) {
        $query = "UPDATE form_data SET approval_status = '$approval_status' WHERE id_form = '$id_form'";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            echo json_encode(['success' => true, 'status' => $approval_status]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data di database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
    }
    exit;
}

// Query untuk mendapatkan data dari tabel form_data
$limit = 4; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil total data buat hitung jumlah halaman
$total_query = "SELECT COUNT(*) as total FROM form_data";
$total_result = mysqli_query($connection, $total_query);
$total_data = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_data / $limit);

// Query data sesuai halaman
$query = "SELECT * FROM form_data LIMIT $start, $limit";
$query_run = mysqli_query($connection, $query);

$query_run = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Training</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div id="wrapper" class="d-flex">
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/topbar.php'); ?>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success" id="success-alert" style="margin: 10px 0;">
            Data berhasil diperbaharui!
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="position: relative;">
                <h5 class="m-0 font-weight-bold text-primary">Data Training</h5>
                <div class="row justify-content-end">
                    <div class="col-4">
                        <a href="generate_report.php" class="btn btn-primary btn-sm" style="position: absolute; top:-20px; right: -290px;">
                            <i class="fas fa-file-pdf"></i> Report PDF
                        </a>
                    </div>
                    <div class="col-4">
                        <a type="button" class="btn btn-success btn-sm" style="position: absolute; top: -20px; right: 20px;" data-toggle="modal" data-target="#excelModal">
                            <i class="fas fa-file-excel"></i> Report Excel
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Training</th>
                                <th>Tanggal Mulai Training</th>
                                <th>Tanggal Selesai Training</th>
                                <th>Fungsi Training</th>
                                <th>Nama</th>
                                <th>Divisi</th>        
                                <th>Nama Lembaga</th>
                                <th>Biaya</th>
                                <th>Bukti Informasi</th>
                                <th>Approval</th>
                                <th>Aksi yang dapat dilakukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query_run) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($query_run)): ?>
                                    <tr>
                                        <td><?php echo $row['id_form']; ?></td>
                                        <td><?php echo $row['judul_training']; ?></td>
                                        <td><?php echo $row['tgl_mulai']; ?></td>
                                        <td><?php echo $row['tgl_selesai']; ?></td>
                                        <td><?php echo $row['fungsi_training']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['divisi']; ?></td>                                       
                                        <td><?php echo $row['nm_lembaga']; ?></td>
                                        <td><?php echo 'Rp' . number_format($row['biaya'],0, ',', '.'); ?></td>
                                        <td>
                                            <?php if (!empty($row['request'])): ?>
                                                <img src="<?php echo $row['request']; ?>" width="35" height="40">
                                            <?php else: ?>
                                                File tidak ditemukan
                                            <?php endif; ?>
                                        </td>
                                        <td id="status-action-<?php echo $row['id_form']; ?>">
                                            <?php if ($row['approval_status'] == 'Pending'): ?>
                                                <button class="btn btn-success btn-sm" onclick="updateStatus(<?php echo $row['id_form']; ?>, 'Approved')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="updateStatus(<?php echo $row['id_form']; ?>, 'Rejected')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php else: ?>
                                                <span><?php echo $row['approval_status']; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#editModal<?php echo $row['id_form']; ?>">
                                                <i class="fas fa-edit" style="margin-right: 10px;"></i>
                                            </a>
                                            <a href="form_hapus.php?id_form=<?php echo $row['id_form']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash" style="margin-right: 10px;"></i>
                                            </a>
                                        </td>
                                    </tr>


<!-- Modal Edit Data Training -->
<form method="POST" action="form_e-proses.php" enctype="multipart/form-data">
<div class="modal fade" id="editModal<?php echo $row['id_form']; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Training</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
    <input type="hidden" name="id_form" value="<?php echo $row['id_form']; ?>">

    <div class="row">
        <!-- Foto di kiri -->
        <div class="col-md-4 text-center mb-3">
            <?php
            $filePath = "" . $row['request'];
            if (!empty($row['request']) && file_exists($filePath)) {
                echo '<img src="' . $filePath . '" alt="Foto Request" class="img-fluid rounded shadow-sm" style="height: 230px; object-fit: cover;">';
            } else {
                echo "<small>File tidak ditemukan di: " . $filePath . "</small>";
            }
            ?>
        </div>

        <!-- Nama, Divisi, Judul di kanan -->
        <div class="col-md-8">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Divisi:</label>
                <input type="text" class="form-control" name="divisi" value="<?php echo $row['divisi']; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Judul Training:</label>
                <input type="text" class="form-control" name="judul_training" value="<?php echo $row['judul_training']; ?>" required>
            </div>
        </div>
    </div>

    <hr>

    <!-- Data lainnya di bawah -->
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
        <input type="text" class="form-control" name="biaya" value="Rp<?php echo number_format($row['biaya'], 0, ',', '.'); ?>,00" required>
    </div>         
        </div>
        <div class="modal-footer">
          <button type="submit" name="Simpan" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Status -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content text-center">
      <div class="modal-body">
        <div id="statusIcon" style="font-size: 3rem;"></div>
        <h5 id="statusText" class="mt-3"></h5>
      </div>
    </div>
  </div>
</div>

                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="12">No Record Found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="pagination justify-content-center mt-3">
    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>


                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal untuk export Excel -->
<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="export_excel.php" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excelModalLabel">Masukkan Nama File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="filename">Nama File:</label>
                <input type="text" id="filename" name="filename" class="form-control" required placeholder="contoh: data_training_april">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Download</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>

<div class="position-fixed top-50 start-50 translate-middle z-3" style="z-index: 1055;">
    <div id="status-toast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toast-message">
                Status diperbarui.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
function updateStatus(id, status) {
    $.ajax({
        url: '', // file ini sendiri
        method: 'POST',
        data: {
            id_form: id,
            approval_status: status
        },
        success: function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                const icon = status === 'Approved'
                    ? '<i class="fas fa-check-circle text-success"></i>'
                    : '<i class="fas fa-times-circle text-danger"></i>';

                $('#statusIcon').html(icon);
                $('#statusText').text('Data telah ' + (status === 'Approved' ? 'disetujui' : 'ditolak'));

                $('#statusModal').modal('show');

                // Perbarui kolom status tanpa reload
                setTimeout(() => {
                    $('#status-action-' + id).html(`<span>${status}</span>`);
                    $('#statusModal').modal('hide');
                }, 2000);
            } else {
                alert('Terjadi kesalahan: ' + result.message);
            }
        }
    });
}
</script>


<!-- Tambahan script untuk reset input modal Excel -->
<script>
$(document).ready(function () {
    $('#excelModal').on('shown.bs.modal', function () {
        $('#filename').val('');
    });

    $('#excelModal form').on('submit', function () {
        $('#excelModal').modal('hide');
    });
});
</script>

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>
</body>
</html>
