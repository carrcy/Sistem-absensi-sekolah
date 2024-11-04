<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Query untuk mengambil data kelas
$queryKelas = "SELECT id_kelas, nama_kelas FROM kelas";
$resultKelas = mysqli_query($connection, $queryKelas);
if (!$resultKelas) {
    die("Query gagal: " . mysqli_error($connection));
}

// Query untuk mengambil data guru
$queryGuru = "SELECT id_guru, nama FROM guru";
$resultGuru = mysqli_query($connection, $queryGuru);
if (!$resultGuru) {
    die("Query gagal: " . mysqli_error($connection));
}
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Jadwal</h1>
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
                <td>Hari</td>
                <td><input class="form-control" type="text" name="hari" size="20" required></td>
              </tr>

              <tr>
                <td>Jam Ke</td>
                <td><input class="form-control" type="text" name="jam" size="20" required></td>
              </tr>
              <tr>
                <td>Pelajaran</td>
                <td><input class="form-control" type="text" name="mata_pelajaran" size="20" required></td>
              </tr>
              <tr>
                <td>Wali Kelas</td>
                <td>
                  <select class="form-control" name="guru_id" required>
                    <option value="">Guru Pengampu</option>
                    <?php while ($rowGuru = mysqli_fetch_assoc($resultGuru)) { ?>
                      <option value="<?= $rowGuru['id_guru'] ?>"><?= $rowGuru['nama'] ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Kelas</td>
                <td>
                  <select class="form-control" name="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    <?php while ($rowKelas = mysqli_fetch_assoc($resultKelas)) { ?>
                      <option value="<?= $rowKelas['id_kelas'] ?>"><?= $rowKelas['nama_kelas'] ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan"></td>
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
