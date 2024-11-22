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
    <a href="./index.php" class="btn btn-light text-center"><i class="fas fa-angle-double-left m-1 " style='font-size:14px'></i>Kembali</a>
    <h1>Tambah Siswa</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Form Tambah Siswa -->
          <form id="formTambahSiswa" action="./store.php" method="POST">
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
  const form = document.getElementById("formTambahSiswa");

  // Periksa validitas form sebelum memproses
  if (!form.checkValidity()) {
    form.reportValidity(); 
    return;
  }

  Swal.fire({
    title: "Apakah Anda yakin?",
    text: "Data Siswa baru akan ditambahkan.",
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
        text: "Data Siswa berhasil ditambahkan.",
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
