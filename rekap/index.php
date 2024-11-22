<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data dari kelas dan guru
$result = mysqli_query($connection, "
    SELECT kelas.id_kelas, kelas.nama_kelas, guru.nama 
    FROM kelas 
    LEFT JOIN guru ON kelas.guru_id = guru.id_guru
");

// Cek jika query gagal
if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}
?>

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1>Data Kelas</h1>
        <!-- <a href="./create.php" class="btn btn-primary btn-lg">Tambah Data</a> -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover w-100" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kelas</th>
                                    <th>Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th style="width: 150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data = mysqli_fetch_array($result)) :
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($data['id_kelas']) ?></td>
                                        <td><?= htmlspecialchars($data['nama_kelas']) ?></td>
                                        <td><i class="fas fa-user-graduate m-2" style='font-size:14px'></i><?= htmlspecialchars($data['nama'] ?: 'Belum Ditentukan') ?></td>
                                        <td>
                                            <a href="detail.php?kelas_id=<?= htmlspecialchars($data['id_kelas']) ?>" class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
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
                message: `<?= htmlspecialchars($_SESSION['info']['message']) ?>`,
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
                message: `<?= htmlspecialchars($_SESSION['info']['message']) ?>`,
                timeout: 5000,
                position: 'topCenter'
            });
        </script>
<?php
    }

    unset($_SESSION['info']);
endif;
?>

<script src="../assets/js/page/modules-datatables.js"></script>

<!-- Styling Enhancement -->
<style>
    section {
        color: #444;
        font-family: 'Arial', sans-serif;
    }

    .section-header h1 {
        font-size: 28px;
        color: #495057;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .table {
        font-size: 14px;
    }

    .table th, .table td {
        padding: 10px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-sm {
        padding: 5px 10px;
    }

    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 12px;
            padding: 8px;
        }
    }
</style>
