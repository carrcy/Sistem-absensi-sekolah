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
    <a href="./index.php" class="btn btn-light text-center"><i class="fas fa-angle-double-left m-1 " style='font-size:14px'></i>Kembali</a>
    <h1>Tambah Kelas</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form -->
          <form id="formTambahKelas" action="./store.php" method="POST">
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
                  <button type="button" class="btn btn-primary" onclick="confirmSubmit()">Simpan</button>
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
</section>


<!-- Tambahkan library SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function confirmSubmit() {
  const form = document.getElementById("formTambahKelas");

  // Periksa validitas form sebelum memproses
  if (!form.checkValidity()) {
    form.reportValidity(); 
    return;
  }

  Swal.fire({
    title: "Apakah Anda yakin?",
    text: "Data Kelas baru akan ditambahkan.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "<i class='fa fa-check'></i> Ya, tambahkan!",
    cancelButtonText: "<i class='fa fa-times'></i> Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Ditambahkan!",
        text: "Data Kelas berhasil ditambahkan.",
        icon: "success",
        timer: 1500,
        showConfirmButton: false,
      }).then(() => {
        form.submit(); 
      });
    }
  });
}

</script>

<style>
  /* Tambahkan gaya khusus untuk SweetAlert */
  .swal2-title-custom {
    font-size: 1.6rem;
    font-weight: bold;
    color: #333;
  }
  .swal2-popup-custom {
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
  }
</style>


<?php
require_once '../layout/_bottom.php';
?>
