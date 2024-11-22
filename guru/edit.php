<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$nip = $_GET['nip'];
$query = mysqli_query($connection, "SELECT * FROM guru WHERE nip='$nip'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <a href="./index.php" class="btn btn-light align-item-center"><i class="fas fa-angle-double-left m-1 " style='font-size:14px'></i>Kembali</a>
    <h1>Ubah Data Guru</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form action="./update.php" method="post" id="updateForm">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="nip" value="<?= $row['nip'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>NIP</td>
                  <td><input class="form-control" type="number" name="nip" size="20" required value="<?= $row['nip'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama Guru</td>
                  <td><input class="form-control" type="text" name="nama" size="20" required value="<?= $row['nama'] ?>"></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td colspan="3"><textarea class="form-control" name="alamat" id="alamat" required><?= $row['alamat'] ?></textarea></td>
                </tr>
                <tr>
                  <td>Username</td>
                  <td><input class="form-control" type="text" name="username_guru" size="20" required value="<?= $row['username_guru'] ?>"></td>
                </tr>
                <tr>
                  <td>Password</td>
                  <td><input class="form-control" type="text" name="password_guru" size="20" required value="<?= $row['password_guru'] ?>"></td>
                </tr>
                
                <tr>
                  <td>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Ubah</button>
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

