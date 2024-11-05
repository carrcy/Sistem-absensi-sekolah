<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$siswa = mysqli_query($connection, "SELECT COUNT(*) FROM siswa");
$guru = mysqli_query($connection, "SELECT COUNT(*) FROM guru");
$kelas = mysqli_query($connection, "SELECT COUNT(*) FROM kelas");
$jadwal = mysqli_query($connection, "SELECT COUNT(*) FROM jadwal");

$total_siswa = mysqli_fetch_array($siswa)[0];
$total_guru = mysqli_fetch_array($guru)[0];
$total_kelas = mysqli_fetch_array($kelas)[0];
$total_jadwal = mysqli_fetch_array($jadwal)[0];
?>

<style>
  .card-statistic-1 {
    padding: 20px;
  }
  .card-icon {
    font-size: 2.5rem;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .card-header h4 {
    font-size: 1.5rem;
  }
  .card-body {
    font-size: 2rem;
  }

  .card-statistic-1 {
    padding: 10px;
    border-radius: 15px;
  }

  .card-icon {
    font-size: 3rem;
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 30px; 
  }

</style>

<section class="section">
  <div class="section-header ">
    <h1 class="m-auto">Dashboard</h1>
  </div>
  <div class="row  p-5 pt-3">
    <!-- Baris pertama -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-12 ">
      <div class="card card-statistic-1 ">
        <div class="card-icon bg-primary ">
          <i class='far fa-user' style="font-size: 40px; color: hitam;"></i>
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap ">
          <div class="card-header">
            <h4>Total Siswa</h4> 
          </div>
          <div class="card-body">
            <?= $total_siswa ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <div class="card card-statistic-1 ">
        <div class="card-icon bg-danger ">
          <i class='far fa-user' style="font-size: 40px; color: hitam;"></i>
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap ">
          <div class="card-header">
            <h4>Total Guru</h4>
          </div>
          <div class="card-body">
            <?= $total_guru ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Baris kedua -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <div class="card card-statistic-1 ">
        <div class="card-icon bg-warning ">
          <i class='far fa-user' style="font-size: 40px; color: hitam;"></i>
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap ">
          <div class="card-header">
            <h4>Total Kelas</h4>
          </div>
          <div class="card-body">
            <?= $total_kelas ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <div class="card card-statistic-1 ">
        <div class="card-icon bg-success ">
          <i class='far fa-user' style="font-size: 40px; color: hitam;"></i>
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap ">
          <div class="card-header">
            <h4>Total Jadwal</h4>
          </div>
          <div class="card-body">
            <?= $total_jadwal ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
