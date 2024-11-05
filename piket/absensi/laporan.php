<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil jadwal_id dari parameter GET
$jadwal_id = isset($_GET['jadwal_id']) ? intval($_GET['jadwal_id']) : 0;

// Query untuk mendapatkan semua nama siswa berdasarkan status kehadiran, diurutkan berdasarkan id_siswa
$result_absensi = mysqli_query($connection, "
    SELECT 
        a.tanggal, 
        g.nama AS guru_nama, 
        SUM(CASE WHEN a.status_kehadiran = 'Tidak Hadir' THEN 1 ELSE 0 END) AS jumlah_tidak_hadir,
        SUM(CASE WHEN a.status_kehadiran = 'Izin' THEN 1 ELSE 0 END) AS jumlah_izin,
        SUM(CASE WHEN a.status_kehadiran = 'Sakit' THEN 1 ELSE 0 END) AS jumlah_sakit,
        GROUP_CONCAT(CASE WHEN a.status_kehadiran = 'Tidak Hadir' THEN s.nama END ORDER BY s.id_siswa ASC SEPARATOR ', ') AS siswa_tidak_hadir,
        GROUP_CONCAT(CASE WHEN a.status_kehadiran = 'Izin' THEN s.nama END ORDER BY s.id_siswa ASC SEPARATOR ', ') AS siswa_izin,
        GROUP_CONCAT(CASE WHEN a.status_kehadiran = 'Sakit' THEN s.nama END ORDER BY s.id_siswa ASC SEPARATOR ', ') AS siswa_sakit
    FROM absensi a
    JOIN siswa s ON a.siswa_id = s.id_siswa
    JOIN guru g ON a.guru_id = g.id_guru
    WHERE a.jadwal_id = $jadwal_id 
    GROUP BY a.tanggal, g.nama
");

if (!$result_absensi) {
    die("Query Error: " . mysqli_error($connection));
}
?>

<style>
    section {
        color: black;
    }

    .table {
        border: 0.5px solid gray;
        border-collapse: collapse;
        width: 100%;
    }

    .table th, .table td {
        border: 0.5px solid gray;
        padding: 8px;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .table tbody td {
        vertical-align: top;
    }

    .table ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: block;
    }

    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 14px;
            padding: 4px;
        }

        .table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>

<section class="section">
    <div class="section-header text-center">
        <h1>Laporan Absensi Siswa</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="cetak_absensi.php?jadwal_id=<?= $jadwal_id ?>" target="_blank" class="btn btn-primary">Cetak PDF</a>
                    <br>
                    <br>
                    <table class="table" id="table-1">
                        <thead class="text-center">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Tanggal</th>
                            <th style="width: 25%">Guru</th>
                            <th style="width: 5%">Tidak Hadir</th>
                            <th style="width: 5%">Izin</th>
                            <th style="width: 5%">Sakit</th>
                            <th style="width: 30%">Nama Siswa (Tidak Hadir, Izin, Sakit)</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1; // Inisialisasi nomor urut
                            while ($absensi = mysqli_fetch_assoc($result_absensi)) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $absensi['tanggal'] ?></td>
                                    <td><?= $absensi['guru_nama'] ?></td>
                                    <td class="text-center"><?= $absensi['jumlah_tidak_hadir'] ?></td>
                                    <td class="text-center"><?= $absensi['jumlah_izin'] ?></td>
                                    <td class="text-center"><?= $absensi['jumlah_sakit'] ?></td>
                                    <td class="p-2">
                                        <?php 
                                        $list_html = '';
                                        if (!empty($absensi['siswa_tidak_hadir'])) {
                                            $list_html .= '<strong>Tidak Hadir:</strong><ul>';
                                            foreach (explode(', ', $absensi['siswa_tidak_hadir']) as $nama) {
                                                $list_html .= '<li>' . htmlspecialchars($nama) . '</li>';
                                            }
                                            $list_html .= '</ul>';
                                        }
                                        if (!empty($absensi['siswa_izin'])) {
                                            $list_html .= '<strong>Izin:</strong><ul>';
                                            foreach (explode(', ', $absensi['siswa_izin']) as $nama) {
                                                $list_html .= '<li>' . htmlspecialchars($nama) . '</li>';
                                            }
                                            $list_html .= '</ul>';
                                        }
                                        if (!empty($absensi['siswa_sakit'])) {
                                            $list_html .= '<strong>Sakit:</strong><ul>';
                                            foreach (explode(', ', $absensi['siswa_sakit']) as $nama) {
                                                $list_html .= '<li>' . htmlspecialchars($nama) . '</li>';
                                            }
                                            $list_html .= '</ul>';
                                        }

                                        echo $list_html ?: 'Tidak ada data';
                                        ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
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

<script src="../../assets/js/page/modules-datatables.js"></script>
