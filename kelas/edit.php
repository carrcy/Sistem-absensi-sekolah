<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Mengambil ID kelas dari query string
$id_kelas = $_GET['id_kelas'];

// Mengambil data kelas berdasarkan ID kelas
$query = mysqli_query($connection, "SELECT * FROM kelas WHERE id_kelas='$id_kelas'");

// Mengambil data guru untuk dropdown
$queryGuru = "SELECT id_guru, nama FROM guru";
$resultGuru = mysqli_query($connection, $queryGuru);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <a href="./index.php" class="btn btn-light text-center"><i class="fas fa-angle-double-left m-1 " style='font-size:14px'></i>Kembali</a>
    <h1>Ubah Data Kelas</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form untuk mengubah data kelas -->
          <form action="./update.php" method="post" id="updateForm">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="id_kelas" value="<?= $row['id_kelas'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>Kode Kelas</td>
                  <td><input class="form-control" type="number" name="id_kelas" size="20" required value="<?= $row['id_kelas'] ?>" readonly></td>
                </tr>
                <tr>
                  <td>Kelas</td>
                  <td><input class="form-control" type="text" name="nama_kelas" size="20" required value="<?= $row['nama_kelas'] ?>"></td>
                </tr>
                <tr>
                  <td>Wali Kelas</td>
                  <td>
                    <select class="form-control" name="guru_id" required>
                      <option value="">Pilih Wali Kelas</option>
                      <?php
                      // Mengisi dropdown guru dengan data dari database
                      while ($rowGuru = mysqli_fetch_assoc($resultGuru)) {
                        // Memilih guru yang sesuai dengan wali kelas saat ini
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
