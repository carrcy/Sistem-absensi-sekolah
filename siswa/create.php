<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Periksa apakah koneksi berhasil
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data kelas dari database
$query = "SELECT id_kelas, nama_kelas FROM kelas";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($connection));
}
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Siswa</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form Tambah Siswa -->
          <form action="./store.php" method="POST">
            <table cellpadding="8" class="w-100">
              <tr>
                <td>NIS</td>
                <td><input class="form-control" type="text" name="nis" size="40" required></td>
              </tr>

              <tr>
                <td>NAMA</td>
                <td><input class="form-control" type="text" name="nama" size="20" required></td>
              </tr>

              <tr>
                <td>KELAS</td>
                <td>
                  <select class="form-control" name="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                      <option value="<?= $row['id_kelas'] ?>"><?= $row['nama_kelas'] ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td>ALAMAT</td>
                <td><textarea class="form-control" name="alamat" required></textarea></td>
              </tr>

              <tr>
                <td>TTL</td>
                <td><input class="form-control" type="date" name="tanggal_lahir" required></td>
              </tr>

              <tr>
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
