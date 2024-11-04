<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Pastikan sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil ID guru dari sesi
$id_guru = $_SESSION['login']['id_guru'];

// Ambil jadwal_id dari parameter GET
$jadwal_id = isset($_GET['jadwal_id']) ? $_GET['jadwal_id'] : null;

// Query untuk mendapatkan data kelas dari absensi berdasarkan jadwal_id
$kelas_result = mysqli_query($connection, "
    SELECT k.id_kelas, k.nama_kelas 
    FROM jadwal j
    JOIN kelas k ON j.kelas_id = k.id_kelas
    WHERE j.id_jadwal = '$jadwal_id'
");

// Periksa apakah ada kelas yang ditemukan
if ($kelas = mysqli_fetch_assoc($kelas_result)) {
    $id_kelas = $kelas['id_kelas'];
    $nama_kelas = $kelas['nama_kelas'];
} else {
    echo "Tidak ada kelas yang ditemukan.";
    exit;
}

// Query untuk mendapatkan data siswa berdasarkan id_kelas
$siswa_result = mysqli_query($connection, "SELECT id_siswa, nama FROM siswa WHERE kelas_id = '$id_kelas'");

// Query untuk mendapatkan detail jadwal yang dipilih
$jadwal_result = mysqli_query($connection, "
    SELECT j.hari, j.jam, j.mata_pelajaran 
    FROM jadwal j
    WHERE j.id_jadwal = '$jadwal_id'
");

// Periksa apakah query berhasil dan memiliki hasil
if ($jadwal_detail = mysqli_fetch_assoc($jadwal_result)) {
    $hari = $jadwal_detail['hari'];
} else {
    echo "Tidak ada data jadwal ditemukan.";
    exit;
}
?>

<style>
    input[type="radio"] {
        width: 20px;  
        height: 20px; 
        margin: 10px; 
    }

    section {
        color: black;
    }

    /* CSS untuk mengatur warna border tabel */
    .table {
        border: 0.5px solid gray; /* Mengatur ketebalan border */
        border-collapse: collapse; /* Menghindari jarak antara border */
    }
    .table th, .table td {
        border: 0.5px solid gray; /* Mengatur ketebalan border pada sel */
        padding: 8px; /* Menambah jarak dalam sel */
    }
    .table th {
        background-color: #f2f2f2; /* Warna latar belakang untuk header tabel */
    }

    @media (max-width: 768px) {
        /* Mengatur tampilan tabel pada layar kecil */
        .table {
            display: block;
            overflow-x: auto; /* Menambahkan scroll horizontal */
            white-space: nowrap; /* Mencegah teks dibungkus */
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
                                    <?php
                                    endwhile;
                                    ?>
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
endif;
?>
<?php
require_once '../layout/_bottom.php';
?>
