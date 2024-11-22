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
    <a href="./index.php" class="btn btn-light text-center"><i class="fas fa-angle-double-left m-1 " style='font-size:14px'></i>Kembali</a>
    <h1>Tambah Jadwal</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form id="formTambahJadwal" action="./store.php" method="POST">
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
  const form = document.getElementById("formTambahJadwal");

  // Periksa validitas form sebelum memproses
  if (!form.checkValidity()) {
    form.reportValidity(); // Memunculkan pesan validasi HTML bawaan
    return;
  }

  Swal.fire({
    title: "Apakah Anda yakin?",
    text: "Data Jadwal baru akan ditambahkan.",
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
        text: "Data Jadwal berhasil ditambahkan.",
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