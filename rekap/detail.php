<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

if (isset($_GET['kelas_id']) && is_numeric($_GET['kelas_id'])) {
    $id_kelas = intval($_GET['kelas_id']); 
} else {
    echo "<script>alert('ID Kelas tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$query = "
    SELECT j.id_jadwal, j.hari, j.jam, j.mata_pelajaran, 
           k.nama_kelas, g.nama AS nama_guru 
    FROM jadwal j
    JOIN kelas k ON j.kelas_id = k.id_kelas
    JOIN guru g ON j.guru_id = g.id_guru
    WHERE j.kelas_id = ?
    ORDER BY j.hari, j.jam
";

$stmt = mysqli_prepare($connection, $query);
if ($stmt === false) {
    die("Error preparing the query: " . mysqli_error($connection));
}

mysqli_stmt_bind_param($stmt, 'i', $id_kelas);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$jadwal_harian = [];
while ($data = mysqli_fetch_array($result)) {
    $jadwal_harian[$data['hari']][] = $data;
}

$urutan_hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];

uksort($jadwal_harian, function($a, $b) use ($urutan_hari) {
    $pos_a = array_search($a, $urutan_hari);
    $pos_b = array_search($b, $urutan_hari);
    return $pos_a - $pos_b;
});
?>

<section class="section">
  <div class="section-header text-center">
    <h1>ABSENSI SISWA BERDASARKAN JADWAL MENGAJAR</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table-1">
              <thead class="bg-success text-white text-center">
                <tr>
                  <th style="width: 5%">No</th>
                  <th style="width: 15%">Jam Ke</th>
                  <th style="width: 20%">Kelas</th>
                  <th style="width: 25%">Pelajaran</th>
                  <th style="width: 25%">Nama Guru</th>
                  <th style="width: 10%">Rekap</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if (count($jadwal_harian) > 0) {
                  $no = 1; 
                  foreach ($jadwal_harian as $hari => $jadwals) {
                    ?>
                    <tr class="table bg-light fw-bold">
                      <td colspan="6" class="text-uppercase"><?= $hari ?></td>
                    </tr>
                    <?php
                    foreach ($jadwals as $jadwal) :
                      ?>
                      <tr>
                        <td><?= $no++ ?></td> 
                        <td><?= $jadwal['jam'] ?></td>
                        <td><?= $jadwal['nama_kelas'] ?></td>
                        <td><?= $jadwal['mata_pelajaran'] ?></td>
                        <td><i class="fas fa-user-graduate m-2" style='font-size:14px'></i><?= $jadwal['nama_guru'] ?></td>
                        <td>
                            <a href="rekap.php?jadwal_id=<?= $jadwal['id_jadwal'] ?>" class="btn btn-danger btn-sm">Rekap</a>
                        </td>
                      </tr>
                    <?php
                    endforeach;
                  }
                } else {
                  echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada data absensi untuk kelas ini.</td></tr>";
                }
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

<script src="../../assets/js/page/modules-datatables.js"></script>
