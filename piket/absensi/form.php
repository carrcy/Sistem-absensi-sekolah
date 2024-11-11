<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Pastikan sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$id_guru = $_SESSION['login']['id_guru'];
$jadwal_id = isset($_GET['jadwal_id']) ? $_GET['jadwal_id'] : null;

// Ambil data kelas berdasarkan jadwal
$kelas_result = mysqli_query($connection, "
    SELECT k.id_kelas, k.nama_kelas 
    FROM jadwal j
    JOIN kelas k ON j.kelas_id = k.id_kelas
    WHERE j.id_jadwal = '$jadwal_id'
");

if ($kelas = mysqli_fetch_assoc($kelas_result)) {
    $id_kelas = $kelas['id_kelas'];
    $nama_kelas = $kelas['nama_kelas'];
} else {
    echo "Tidak ada kelas yang ditemukan.";
    exit;
}

// Ambil data siswa berdasarkan kelas
$siswa_result = mysqli_query($connection, "SELECT id_siswa, nama FROM siswa WHERE kelas_id = '$id_kelas'");

// Ambil data jadwal
$jadwal_result = mysqli_query($connection, "
    SELECT j.hari, j.jam, j.mata_pelajaran 
    FROM jadwal j
    WHERE j.id_jadwal = '$jadwal_id'
");

if ($jadwal_detail = mysqli_fetch_assoc($jadwal_result)) {
    $hari = $jadwal_detail['hari'];
} else {
    echo "Tidak ada data jadwal ditemukan.";
    exit;
}
?>

<!-- Modal Alert -->
<?php if (isset($_SESSION['info'])): ?>
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Pesan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="alertMessage"><?= $_SESSION['info']['message']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
            alertModal.show();
        });
    </script>
    <?php unset($_SESSION['info']); ?>
<?php endif; ?>

<style>
    input[type="radio"] {
        width: 20px;  
        height: 20px; 
        margin: 10px; 
    }

    section {
        color: black;
    }
    
    .table {
        border: 0.5px solid gray; 
        border-collapse: collapse;
    }
    .table th, .table td {
        border: 0.5px solid gray;
        padding: 8px; 
    }
    .table th {
        background-color: #f2f2f2; 
    }

    @media (max-width: 768px) {
        .table {
            display: block;
            overflow-x: auto; 
            white-space: nowrap; 
        }
    }
</style>

<section class="section">
    <div class="section-header text-center">
        <h1>Form Absensi Siswa</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="store.php" class="g-4">
                        <input type="hidden" name="jadwal_id" value="<?= $jadwal_id ?>">
                        <div class="form-group w-75 m-auto">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <div class="form-group w-75 m-auto mb-5">
                            <label for="kelas_id">Kelas</label>
                            <input type="text" class="form-control" value="<?= $nama_kelas ?>" disabled>
                            <input type="hidden" name="kelas_id" value="<?= $id_kelas ?>">
                        </div>
                        <div class="table-responsive">
                            <table class="table mt-5" id="table-1">
                                <thead class="text-white">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 50%">Nama Siswa</th>
                                        <th style="width: 10%" class="text-center">Hadir</th>
                                        <th style="width: 10%" class="text-center">Tidak Hadir</th>
                                        <th style="width: 10%" class="text-center">Izin</th>
                                        <th style="width: 10%" class="text-center">Sakit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($siswa = mysqli_fetch_assoc($siswa_result)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $siswa['nama'] ?></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $siswa['id_siswa'] ?>]" value="Hadir"></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $siswa['id_siswa'] ?>]" value="Tidak Hadir"></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $siswa['id_siswa'] ?>]" value="Izin"></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $siswa['id_siswa'] ?>]" value="Sakit"></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary end">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
