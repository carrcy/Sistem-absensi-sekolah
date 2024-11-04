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
                  <th style="width: 150">Aksi</th>
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
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['nama_kelas'] ?></td> <!-- Tampilkan Nama Kelas -->
                    <td><?= $data['alamat'] ?></td>
                    <td><?= $data['tanggal_lahir'] ?></td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?nis=<?= $data['nis'] ?>">
                        <i class="fas fa-trash fa-fw"></i>
                      </a>
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
<script src="../assets/js/page/modules-datatables.js"></script>
