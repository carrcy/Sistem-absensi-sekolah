<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ambil data guru dari database
$query = "SELECT id_guru, nama FROM guru";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($connection));
}
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Kelas</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="./store.php" method="POST">
            <table cellpadding="8" class="w-100">
              <tr>
                <td>Kode Kelas</td>
                <td><input class="form-control" type="text" name="id_kelas" size="20" required></td>
              </tr>

              <tr>
                <td>Nama Kelas</td>
                <td><input class="form-control" type="text" name="nama_kelas" size="20" required></td>
              </tr>

              <tr>
                <td>Wali Kelas</td>
                <td>
                  <select class="form-control" name="guru_id" required>
                    <option value="">Pilih Wali Kelas</option>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                      <option value="<?= $row['id_guru'] ?>"><?= $row['nama'] ?></option>
                    <?php } ?>
                  </select>
                </td>
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
