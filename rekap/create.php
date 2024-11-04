<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Pengajuan Judul</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./store.php" method="POST">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>ID Absensi</td>
                <td><input class="form-control" type="text" name="absensi_id" size="20" required></td>
              </tr>
              <tr>
                <td>Total Hadir</td>
                <td><input class="form-control" type="text" name="total_hadir" size="20" required></td>
              </tr>

              <tr>
                <td>Total Tidak Hadir</td>
                <td><input class="form-control" type="text" name="total_tidak_hadir" size="20" required></td>
              </tr>
              <tr>
                <td>Total Izin</td>
                <td><input class="form-control" type="text" name="total_izin" size="20" required></td>
              </tr>
              <tr>
                <td>Total Sakit</td>
                <td><input class="form-control" type="text" name="total_sakit" size="20" required></td>
              </tr>
              <tr>
                <td>Guru</td>
                <td><input class="form-control" type="text" name="guru_id" size="20" required></td>
              </tr>
              <td>
                <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
              </td>
              </tr>

            </table>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>