<?php $activePage = basename($_SERVER['PHP_SELF']); ?>


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../training/dashboard.php">
        <div class="sidebar-brand-icon">
            <img src="uploads/tes.png" style="width: 50px; height: 50px; margin-right: 8px;">
        </div>
        <div class="sidebar-brand-text" style="font-size: 12px; font-weight: bold;">
        Human Resource<br>Development
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Sidebar - Management Item -->
    <li class="nav-item">
    <a class="nav-link collapsed <?php if($activePage == 'user_acc.php' || $activePage == 'form_data.php') echo 'active'; ?>" 
       href="#" 
       data-bs-toggle="collapse" 
       data-bs-target="#collapsePages" 
       aria-expanded="<?php echo ($activePage == 'user_acc.php' || $activePage == 'form_data.php') ? 'true' : 'false'; ?>" 
       aria-controls="collapsePages">
        <i class="fas fa-cogs"></i>
        <span>Manajemen</span>
        <i class="fas fa-angle-right ms-2 dropdown-arrow"></i>
    </a>
    <div id="collapsePages" class="collapse <?php echo ($activePage == 'user_acc.php' || $activePage == 'form_data.php') ? 'show' : ''; ?>">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Mengelola:</h6>
            <a class="collapse-item <?php if($activePage == 'user_acc.php') echo 'active'; ?>" href="user_acc.php">Akun pengguna</a>
            <a class="collapse-item <?php if($activePage == 'form_data.php') echo 'active'; ?>" href="form_data.php">Form Data E-training</a>
        </div>
    </div>
</li>


    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="datatables.php">
            <i class="fas fa-table"></i>
            <span>Tabel data</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

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

    <!-- Sidebar and other content -->

<!-- Sidebar content -->

<!-- Add CSS at the bottom before closing body tag -->
<style>
    /* Style for the dropdown arrow */
    .dropdown-arrow {
        transition: transform 0.3s ease; /* Smooth rotation for the arrow */
        margin-left: 60px; /* Add some space to the left of the arrow */
    }

    /* Default arrow direction */
    .dropdown-arrow {
        transform: rotate(0deg); /* Arrow points to the right */
    }

    /* Arrow direction when collapse is expanded */
    .nav-item .collapse.show + .nav-link .dropdown-arrow {
        transform: rotate(90deg); /* Arrow points downward */
    }


    .collapse-item.active {
        background-color:#eef2f6 ; /* abu tipis */
        font-weight: normal;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }


</style>


<!-- Add jQuery script at the bottom before closing body tag -->
<script>
    // jQuery to toggle the arrow on collapse open/close
    $(document).ready(function() {
        // On collapse show
        $('#accordionSidebar').on('shown.bs.collapse', '.collapse', function () {
            $(this).prev().find('.dropdown-arrow').css('transform', 'rotate(90deg)');
        });

        // On collapse hide
        $('#accordionSidebar').on('hidden.bs.collapse', '.collapse', function () {
            $(this).prev().find('.dropdown-arrow').css('transform', 'rotate(0deg)');
        });
    });
</script>

