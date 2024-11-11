<?php
require_once '../helper/auth.php';
isLogin('guru');
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id_guru = $_SESSION['login']['id_guru'];

$guru = mysqli_query($connection, "SELECT COUNT(*) FROM guru");
$siswa = mysqli_query($connection, "SELECT COUNT(*) FROM siswa");
$kelas = mysqli_query($connection, "SELECT COUNT(*) FROM kelas");
// $nilai = mysqli_query($connection, "SELECT COUNT(*) FROM nilai");
// $pengajuan_skripsi = mysqli_query($connection, "SELECT COUNT(*) FROM pengajuan_skripsi");

$total_guru = mysqli_fetch_array($guru)[0];
$total_siswa = mysqli_fetch_array($siswa)[0];
$total_kelas = mysqli_fetch_array($kelas)[0];
// $total_nilai = mysqli_fetch_array($nilai)[0];
// $total_pengajuan_skripsi = mysqli_fetch_array($pengajuan_skripsi)[0];
?>

<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}


.card-icon {
    border-radius: 50%;
    padding: 10px;
    font-size: 24px;
    color: #fff;
}

.bg-primary {
    background-color: #007bff !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

.card-header h4 {
    font-size: 1.25rem;
    margin: 0;
    color: #333;
}

.card-body {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}
</style>

<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <div class="column">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class='far fa-user' style="font-size: 40px; color: hitam;"></i>
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Guru</h4>
                        </div>
                        <div class="card-body">
                            <?= $total_guru ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class='far fa-user' style="font-size: 40px; color: hitam;"></i>
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Siswa</h4>
                        </div>
                        <div class="card-body">
                            <?= $total_siswa ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class='far fa-user' style="font-size: 40px; color: hitam;"></i>
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kelas</h4>
                        </div>
                        <div class="card-body">
                            <?= $total_kelas ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
