<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Query untuk mengambil data siswa beserta nama kelas
$result = mysqli_query($connection, "
    SELECT siswa.nis, siswa.nama, siswa.alamat, siswa.tanggal_lahir, kelas.nama_kelas 
    FROM siswa 
    INNER JOIN kelas ON siswa.kelas_id = kelas.id_kelas
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Daftar Siswa</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Data</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>No</th> <!-- Menambahkan kolom untuk No -->
                  <th>No NIS</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Alamat</th>
                  <th>Tanggal Lahir</th>
                  <th style="width: 200">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1; // Inisialisasi nomor urut
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr>
                    <td><?= $no++ ?></td> <!-- Menampilkan nomor urut -->
                    <td><?= $data['nis'] ?></td>
                    <td><i class="fas fa-users m-1" style='font-size:14px'></i><?= $data['nama'] ?></td>
                    <td><?= $data['nama_kelas'] ?></td> 
                    <td><?= $data['alamat'] ?></td>
                    <td><?= $data['tanggal_lahir'] ?></td>
                    <!-- <td>
                      <button class="btn btn-sm btn-danger mb-md-0 mb-1" onclick="confirmDelete('<?= $data['nis'] ?>')">
                        <i class="fas fa-trash fa-fw"></i>
                      </button>
                      <a class="btn btn-sm btn-info" href="edit.php?nis=<?= $data['nis'] ?>">
                        <i class="fas fa-edit fa-fw"></i>
                      </a>
                    </td> -->
                    <td>
                      <button class="btn btn-sm btn-danger mb-md-0 mb-1" onclick="confirmDelete('<?= $data['nis'] ?>')">
                        <i class="fas fa-trash fa-fw"></i>
                      </button>
                      <a class="btn btn-sm btn-info" href="edit.php?nis=<?= $data['nis'] ?>">
                        <i class="fas fa-edit fa-fw"></i>
                      </a>
                    </td>
                  </tr>

                <?php
                endwhile;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
<!-- Page Specific JS File -->
<?php
if (isset($_SESSION['info'])) :
  if ($_SESSION['info']['status'] == 'success') {
?>
    <script>
      iziToast.success({
        title: 'Sukses',
        message: `<?= $_SESSION['info']['message'] ?>`,
        position: 'topCenter',
        timeout: 5000
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      iziToast.error({
        title: 'Gagal',
        message: `<?= $_SESSION['info']['message'] ?>`,
        timeout: 5000,
        position: 'topCenter'
      });
    </script>
<?php
  }

  unset($_SESSION['info']);
  $_SESSION['info'] = null;
endif;
?>


<!-- Tambahkan library SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/page/modules-datatables.js"></script>

<script>
  function confirmDelete(nis) {
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Data ini akan dihapus secara permanen.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `delete.php?nis=${nis}`;
      }
    });
  }
</script>
