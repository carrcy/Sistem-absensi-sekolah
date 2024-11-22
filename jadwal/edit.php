<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id_jadwal = $_GET['id_jadwal'];

$query = mysqli_query($connection, "SELECT * FROM jadwal WHERE id_jadwal='$id_jadwal'");

$queryKelas = "SELECT id_kelas, nama_kelas FROM kelas";
$resultKelas = mysqli_query($connection, $queryKelas);

$queryGuru = "SELECT id_guru, nama FROM guru";
$resultGuru = mysqli_query($connection, $queryGuru);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <a href="./index.php" class="btn btn-light text-center"><i class="fas fa-angle-double-left m-1 " style='font-size:14px'></i>Kembali</a>
    <h1>Ubah Data Jadwal</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form untuk mengubah data jadwal -->
          <form action="./update.php" method="post" id="updateForm">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="id_jadwal" value="<?= $row['id_jadwal'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>Kode Jadwal</td>
                  <td><input class="form-control" type="number" name="id_jadwal" size="20" required value="<?= $row['id_jadwal'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Hari</td>
                  <td><input class="form-control" type="text" name="hari" size="20" required value="<?= $row['hari'] ?>"></td>
                </tr>
                <tr>
                  <td>Jam</td>
                  <td><input class="form-control" type="text" name="jam" size="20" required value="<?= $row['jam'] ?>"></td>
                </tr>
                <tr>
                  <td>Pelajaran</td>
                  <td><input class="form-control" type="text" name="mata_pelajaran" size="20" required value="<?= $row['mata_pelajaran'] ?>"></td>
                </tr>
                <tr>
                  <td>Kelas</td>
                  <td>
                    <select class="form-control" name="kelas_id" required>
                      <option value="">Pilih Kelas</option>
                      <?php
                      // Mengisi dropdown kelas dengan data dari database
                      while ($rowKelas = mysqli_fetch_assoc($resultKelas)) {
                        // Memilih kelas yang sesuai dengan kelas saat ini
                        $selected = ($row['kelas_id'] == $rowKelas['id_kelas']) ? 'selected' : '';
                        echo "<option value=\"{$rowKelas['id_kelas']}\" $selected>{$rowKelas['nama_kelas']}</option>";
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Guru</td>
                  <td>
                    <select class="form-control" name="guru_id" required>
                      <option value="">Pilih Guru</option>
                      <?php
                      // Mengisi dropdown guru dengan data dari database
                      while ($rowGuru = mysqli_fetch_assoc($resultGuru)) {
                        // Memilih guru yang sesuai dengan guru saat ini
                        $selected = ($row['guru_id'] == $rowGuru['id_guru']) ? 'selected' : '';
                        echo "<option value=\"{$rowGuru['id_guru']}\" $selected>{$rowGuru['nama']}</option>";
                      }
                      ?>
                    </select>
                  </td>
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


<!-- SweetAlert dan iziToast -->
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
