<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$nip = $_GET['nip'];
$query = mysqli_query($connection, "SELECT * FROM guru WHERE nip='$nip'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Guru</h1>
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
              <input type="hidden" name="nip" value="<?= $row['nip'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>nip</td>
                  <td><input class="form-control" type="number" name="nip" size="20" required value="<?= $row['nip'] ?>"
                      disabled></td>
                </tr>
                <tr>
                  <td>Nama Guru</td>
                  <td><input class="form-control" type="text" name="nama" size="20" required
                      value="<?= $row['nama'] ?>"></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td colspan="3"><textarea class="form-control" name="alamat" id="alamat"
                  required><?= $row['alamat'] ?></textarea></td>
                </tr>
                <tr>
                  <td>Username</td>
                  <td><input class="form-control" type="text" name="username_guru" size="20" required
                      value="<?= $row['username_guru'] ?>"></td>
                </tr>
                <tr>
                  <td>Password</td>
                  <td><input class="form-control" type="text" name="password_guru" size="20" required
                      value="<?= $row['password_guru'] ?>"></td>
                </tr>
                
                <tr>
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