<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Mengambil NIS dari query string
$nis = $_GET['nis'];

// Mengambil data siswa berdasarkan NIS
$query = mysqli_query($connection, "SELECT * FROM siswa WHERE nis='$nis'");

// Mengambil data kelas untuk dropdown
$queryKelas = "SELECT id_kelas, nama_kelas FROM kelas";
$resultKelas = mysqli_query($connection, $queryKelas);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data User</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form untuk mengubah data siswa -->
          <form action="./update.php" method="post">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="nis" value="<?= $row['nis'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>NIS</td>
                  <td><input class="form-control" type="number" name="nis" size="20" required value="<?= $row['nis'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td><input class="form-control" type="text" name="nama" size="20" required value="<?= $row['nama'] ?>"></td>
                </tr>
                <tr>
                  <td>Kelas</td>
                  <td>
                    <select class="form-control" name="kelas_id" required>
                      <option value="">Pilih Kelas</option>
                      <?php
                      // Mengisi dropdown kelas dengan data dari database
                      while ($rowKelas = mysqli_fetch_assoc($resultKelas)) {
                        // Memilih kelas yang sesuai dengan kelas siswa saat ini
                        $selected = ($row['kelas_id'] == $rowKelas['id_kelas']) ? 'selected' : '';
                        echo "<option value=\"{$rowKelas['id_kelas']}\" $selected>{$rowKelas['nama_kelas']}</option>";
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td><textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $row['alamat'] ?></textarea></td>
                </tr>
                <tr>
                  <td>Tanggal Lahir</td>
                  <td><input class="form-control" type="date" name="tanggal_lahir" required value="<?= $row['tanggal_lahir'] ?>"></td>
                </tr>
                <tr>
                  <td>
                    <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                    <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                  </td>
                </tr>
              </table>
            <?php } ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
