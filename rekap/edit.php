<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id_laporan = $_GET['id_laporan'];
$query = mysqli_query($connection, "SELECT * FROM laporan_absensi WHERE id_laporan='$id_laporan'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Matakuliah</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
            <?php
            while ($row = mysqli_fetch_array($query)) {
              ?>
              <input type="hidden" name="id_laporan" value="<?= $row['id_laporan'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>id_laporan</td>
                  <td><input class="form-control" type="text" name="id_laporan" size="20" required value="<?= $row['id_laporan'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Absensi</td>
                  <td><input class="form-control" type="text" name="Absensi" size="20" required value="<?= $row['absensi_id'] ?>"></td>
                </tr>

                <tr>
                  <td>Total Hadir</td>
                  <td><input class="form-control" type="text" name="total_hadir" size="20" required value="<?= $row['total_hadir'] ?>"></td>
                </tr>
                <tr>
                  <td>Total Tidak Hadir</td>
                  <td><input class="form-control" type="text" name="total_tidak_hadir" size="20" required value="<?= $row['total_tidak_hadir'] ?>"></td>
                </tr>
                <tr>
                  <td>Total_izin</td>
                  <td><input class="form-control" type="text" name="total_izin" size="20" required value="<?= $row['total_izin'] ?>"></td>
                </tr>
                <tr>
                <tr>
                  <td>Total_sakit</td>
                  <td><input class="form-control" type="text" name="total_sakit" size="20" required value="<?= $row['total_sakit'] ?>"></td>
                </tr>
                <tr>
                <tr>
                  <td>Guru</td>
                  <td><input class="form-control" type="text" name="prodi" size="20" required value="<?= $row['guru_id'] ?>"></td>
                </tr>
                <td>
                  <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                  <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                <td>
                  </tr>
              </table>

            <?php } ?>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>