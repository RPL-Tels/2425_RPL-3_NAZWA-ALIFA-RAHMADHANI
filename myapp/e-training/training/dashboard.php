<?php
include('database/config.php');
include('includes/header.php');
include('includes/navbar.php');

$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$filter_query = '';

if ($filter_bulan && $filter_tahun) {
    $filter_query = " AND MONTH(tgl_mulai) = $filter_bulan AND YEAR(tgl_mulai) = $filter_tahun";
} elseif ($filter_bulan) {
    $filter_query = " AND MONTH(tgl_mulai) = $filter_bulan";
} elseif ($filter_tahun) {
    $filter_query = " AND YEAR(tgl_mulai) = $filter_tahun";
}


// Query untuk menghitung jumlah form berdasarkan divisi
$fad_total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM form_data WHERE divisi = 'FAD' $filter_query");
$it_total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM form_data WHERE divisi = 'IT' $filter_query");
$fad_total = mysqli_fetch_assoc($fad_total_query)['total'];
$it_total = mysqli_fetch_assoc($it_total_query)['total'];

// Query untuk jumlah pengajuan yang disetujui
$fad_approved_query = mysqli_query($conn, "SELECT COUNT(*) as approved FROM form_data WHERE divisi = 'FAD' AND approval_status = 'Approved' $filter_query");
$it_approved_query = mysqli_query($conn, "SELECT COUNT(*) as approved FROM form_data WHERE divisi = 'IT' AND approval_status = 'Approved' $filter_query");
$fad_approved = mysqli_fetch_assoc($fad_approved_query)['approved'];
$it_approved = mysqli_fetch_assoc($it_approved_query)['approved'];

// Query untuk jumlah pengajuan yang ditolak
$fad_rejected_query = mysqli_query($conn, "SELECT COUNT(*) as rejected FROM form_data WHERE divisi = 'FAD' AND approval_status = 'Rejected' $filter_query");
$it_rejected_query = mysqli_query($conn, "SELECT COUNT(*) as rejected FROM form_data WHERE divisi = 'IT' AND approval_status = 'Rejected'$filter_query");
$fad_rejected = mysqli_fetch_assoc($fad_rejected_query)['rejected'];
$it_rejected = mysqli_fetch_assoc($it_rejected_query)['rejected'];
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <span class="navbar-text" style="font-size: 20px; font-weight: bold; color: #00008B; text-align: left;">
                PT INTIKOM BERLIAN MUSTIKA
            </span>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../login.php">
                        <i class="fas fa-sign-out-alt fa-fw" style="color: black;" ></i> 
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800" style="text-align: center;">Rekapitulasi Data Training per Divisi</h1>

<!-- Filter Bulan dan Tahun -->
<form method="GET" class="mb-4" style="text-align: center;">
    <label for="bulan">Bulan:</label>
    <select name="bulan" id="bulan">
        <option value="">Semua</option>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            $selected = (isset($_GET['bulan']) && $_GET['bulan'] == $i) ? 'selected' : '';
            echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
        }
        ?>
    </select>

    <label for="tahun">Tahun:</label>
    <select name="tahun" id="tahun">
        <option value="">Semua</option>
        <?php
        $currentYear = date("Y");
        for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
            $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $y) ? 'selected' : '';
            echo "<option value='$y' $selected>$y</option>";
        }
        ?>
    </select>

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
</form>
          
            
            <!-- Chart Container -->
            <div class="chart-container" style="width: 80%; margin: auto;">
                <canvas id="trainingChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Ambil konteks canvas
    const ctx = document.getElementById('trainingChart').getContext('2d');

    // Buat diagram batang
    const trainingChart = new Chart(ctx, {
        type: 'bar', // Jenis chart
        data: {
            labels: ['FAD', 'IT'], // Nama divisi
            datasets: [
                {
                    label: 'Total Pengajuan Training',
                    data: [<?= $fad_total; ?>, <?= $it_total; ?>], // Data PHP untuk total pengajuan
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pengajuan Training yang Disetujui',
                    data: [<?= $fad_approved; ?>, <?= $it_approved; ?>], // Data PHP untuk pengajuan yang disetujui
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pengajuan Training yang Ditolak',
                    data: [<?= $fad_rejected; ?>, <?= $it_rejected; ?>], // Data PHP untuk pengajuan yang ditolak
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top' // Posisi legenda
                }
            },
            scales: {
                y: {
                    beginAtZero: true // Sumbu Y mulai dari 0
                }
            }
        }
    });
</script>

<?php
include('includes/script.php');
include('includes/footer.php');
?>
