<?php $activePage = basename($_SERVER['PHP_SELF']); ?>

<!-- jQuery dan Bootstrap Bundle (termasuk Popper.js) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../training/karyawan_form.php">
            <div class="sidebar-brand-icon">
                <img src="uploads/karyawan.png" style="width: 50px; height: 50px; margin-right: 5px; ">
            </div>
            <div class="sidebar-brand-text" style="font-size: 20px; font-weight: bold;">
            Karyawan
            </div>
        </a>
            <!-- Nav Item - form -->
            <li class="nav-item">
                <a class="nav-link" href="karyawan_form.php">
                    <i class="fas fa-edit"></i>
                    <span>Formulir</span></a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
    <a class="nav-link collapsed <?php if($activePage == 'history-pengajuan.php' || $activePage == 'history-pelaksanaan.php') echo 'active'; ?>" 
       href="#" 
       data-toggle="collapse" 
       data-target="#collapseHistory" 
       aria-expanded="<?php echo ($activePage == 'history-pengajuan.php' || $activePage == 'history-pelaksanaan.php') ? 'true' : 'false'; ?>" 
       aria-controls="collapseHistory">
        <i class="fas fa-history"></i>
        <span>Riwayat</span>
    </a>
    <div id="collapseHistory" class="collapse <?php echo ($activePage == 'history-pengajuan.php' || $activePage == 'history-pelaksanaan.php') ? 'show' : ''; ?>">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Riwayat:</h6>
            <a class="collapse-item <?php if($activePage == 'history-pengajuan.php') echo 'active'; ?>" href="history-pengajuan.php" 
                style="color: #6c757d;">Pengajuan Training</a>
            <a class="collapse-item <?php if($activePage == 'history-pelaksanaan.php') echo 'active'; ?>" href="history-pelaksanaan.php" 
                style="color: #6c757d;">Training Terealisasi</a>
            <div class="collapse-divider"></div>
        </div>
    </div>
</li>
        </ul>
        <!-- End of Sidebar -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>     
   
    <style>
    .collapse-item.active {
        background-color:#eef2f6 ; /* abu tipis */
        font-weight: normal;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }


</style>
