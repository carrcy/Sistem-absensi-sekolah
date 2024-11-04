<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ubah query untuk join dengan tabel kelas dan guru
$result = mysqli_query($connection, "
    SELECT j.id_jadwal, j.hari, j.jam, j.mata_pelajaran, 
    k.nama_kelas, g.nama AS nama_guru 
    FROM jadwal j
    JOIN kelas k ON j.kelas_id = k.id_kelas
    JOIN guru g ON j.guru_id = g.id_guru
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Jadwal Kelas</h1>
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
                  <th>No</th>
                  <th>Kode Jadwal</th>
                  <th>Hari</th>
                  <th>Jam Ke</th>
                  <th>Mata Pelajaran</th>
                  <th>Kelas</th>
                  <th>Guru</th>
                  <th style="width: 150">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data['id_jadwal'] ?></td>
                    <td><?= $data['hari'] ?></td>
                    <td><?= $data['jam'] ?></td>
                    <td><?= $data['mata_pelajaran'] ?></td>
                    <td><?= $data['nama_kelas'] ?></td> <!-- Menampilkan nama kelas -->
                    <td><?= $data['nama_guru'] ?></td> <!-- Menampilkan nama guru -->
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id_jadwal=<?= $data['id_jadwal'] ?>">
                        <i class="fas fa-trash fa-fw"></i>
                      </a>
                      <a class="btn btn-sm btn-info" href="edit.php?id_jadwal=<?= $data['id_jadwal'] ?>">
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
