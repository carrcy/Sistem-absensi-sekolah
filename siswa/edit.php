<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$nis = $_GET['nis'];
$query = mysqli_query($connection, "SELECT * FROM siswa WHERE nis='$nis'");
$queryKelas = "SELECT id_kelas, nama_kelas FROM kelas";
$resultKelas = mysqli_query($connection, $queryKelas);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <a href="./index.php" class="btn btn-light text-center"><i class="fas fa-angle-double-left m-1 " style='font-size:14px'></i>Kembali</a>
    <h1>Ubah Data User</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="./update.php" method="post" id="updateForm">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="nis" value="<?= $row['nis'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>NIS</td>
                  <td><input class="form-control" type="text" name="nis" size="20" required value="<?= $row['nis'] ?>" readonly></td>
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
                      while ($rowKelas = mysqli_fetch_assoc($resultKelas)) {
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
                    <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Ubah</button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">

<script>
  function confirmUpdate() {
    const form = document.getElementById('updateForm');
    if (form.checkValidity()) {
      Swal.fire({
        title: 'Yakin ingin mengubah data?',
        text: "Data akan diperbarui dengan informasi yang telah dimasukkan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    } else {
      form.reportValidity();
    }
  }
</script>
