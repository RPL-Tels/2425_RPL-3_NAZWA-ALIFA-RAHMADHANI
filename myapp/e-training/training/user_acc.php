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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle (sudah termasuk Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


<div id="wrapper" class="d-flex">
    <!-- Sidebar -->
    <?php include('includes/navbar.php'); ?>
    
    <!-- Topbar -->
    <?php include('includes/topbar.php'); ?>

    <div class="container-fluid">
        <!-- Add Admin Profile Modal -->
        <div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Akun Pengguna Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="code.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                            </div>
                            <div class="form-group">
                                <label>ID Pegawai</label>
                                <input type="text" name="id_pegawai" class="form-control" placeholder="Enter ID Pegawai" required>
                            </div>
                            <div class="form-group">
                                <label for="editTypeUser">Divisi</label>
                                <select class="form-control" name="divisi" id="editTypeUser" required>
                                    <option value="" disabled selected>Pilih Divisi</option>
                                    <option value="IT">IT</option>
                                    <option value="HRD">HRD</option>
                                    <option value="FAD">FAD</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="pass" class="form-control" placeholder="Enter Password" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="registerbtn" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Admin Profile -->
        <div class="modal fade" id="editadminprofile" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Akun Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="code.php" method="POST">
                        <div class="modal-body">
                            <!-- Hidden Input for ID -->
                            <!-- Hidden Input for ID -->
                            <input type="hidden" name="id_user" id="editIdUser">

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" id="editUsername" required>
                            </div>
                            <div class="form-group">
                                <label>ID Pegawai</label>
                                <input type="text" class="form-control" name="id_pegawai" id="editId" required>
                            </div>
                            <div class="form-group">
                                <label>Divisi</label>
                                <input type="text" class="form-control" name="divisi" id="editDivisi" required>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="text" class="form-control" name="pass" id="editPassword" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="updatebtn" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Database Section -->
        <div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Akun Pengguna</h5>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                Tambah akun baru
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php
            $connection = mysqli_connect("localhost", "root", "", "e-training");
            $query = "SELECT * FROM login";
            $query_run = mysqli_query($connection, $query);
            ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>ID Pegawai</th>
                        <th>Password</th>
                        <th>Divisi</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                    ?>
                        <tr>
                            <td><?php echo $row['id_user']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['id_pegawai']; ?></td>
                            <td><?php echo $row['pass']; ?></td>
                            <td><?php echo $row['divisi']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editadminprofile" 
                                    onclick="editData('<?php echo $row['id_user']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['id_pegawai']; ?>', '<?php echo $row['divisi']; ?>', '<?php echo $row['pass']; ?>')">Edit</button>
                            </td>
                            <td>
                                <a href="user_hapus.php?id=<?php echo $row['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No Record Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <script>
    function editData(id_user, username, id_pegawai, divisi, password) {
    console.log('Debug Data:', id_user, username, id_pegawai, divisi, password);

    document.getElementById('editIdUser').value = id_user;
    document.getElementById('editUsername').value = username;
    document.getElementById('editId').value = id_pegawai; // ✅ sekarang benar!
    document.getElementById('editDivisi').value = divisi;
    document.getElementById('editPassword').value = password;
}


    </script>

    <?php
    include('includes/script.php');
    include('includes/footer.php');
    ?>
</div>
</body>
</html>
