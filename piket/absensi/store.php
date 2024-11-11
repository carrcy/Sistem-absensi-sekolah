<?php
require_once '../helper/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$tanggal = $_POST['tanggal'];
$jadwal_id = $_POST['jadwal_id'];
$kelas_id = $_POST['kelas_id'];
$guru_id = $_SESSION['login']['id_guru'];
$status_kehadiran = $_POST['status'];

$total_hadir = 0;
$total_tidak_hadir = 0;
$total_izin = 0;
$total_sakit = 0;
$all_absensi_success = true; // Flag untuk memeriksa jika semua query absensi sukses

// Loop melalui setiap status kehadiran siswa dan simpan dalam tabel absensi
foreach ($status_kehadiran as $siswa_id => $status) {
    switch ($status) {
        case 'Hadir':
            $total_hadir++;
            break;
        case 'Tidak Hadir':
            $total_tidak_hadir++;
            break;
        case 'Izin':
            $total_izin++;
            break;
        case 'Sakit':
            $total_sakit++;
            break;
    }

    $query_absensi = "INSERT INTO absensi (tanggal, status_kehadiran, siswa_id, kelas_id, guru_id, jadwal_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_absensi = mysqli_prepare($connection, $query_absensi);

    if ($stmt_absensi) {
        mysqli_stmt_bind_param($stmt_absensi, 'ssiiii', $tanggal, $status, $siswa_id, $kelas_id, $guru_id, $jadwal_id);
        $result_absensi = mysqli_stmt_execute($stmt_absensi);

        if (!$result_absensi) {
            $all_absensi_success = false;
            $_SESSION['info'] = [
                'status' => 'failed',
                'message' => 'Gagal menyimpan data absensi: ' . mysqli_stmt_error($stmt_absensi)
            ];
            break; // Hentikan loop jika terjadi kesalahan
        }

        mysqli_stmt_close($stmt_absensi);
    } else {
        $all_absensi_success = false;
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Persiapan query absensi gagal: ' . mysqli_error($connection)
        ];
        break;
    }
}

// Jika semua data absensi berhasil disimpan, lanjutkan ke laporan_absensi
if ($all_absensi_success) {
    $query_laporan = "INSERT INTO laporan_absensi (total_hadir, total_tidak_hadir, total_izin, total_sakit, guru_id) VALUES (?, ?, ?, ?, ?)";
    $stmt_laporan = mysqli_prepare($connection, $query_laporan);

    if ($stmt_laporan) {
        mysqli_stmt_bind_param($stmt_laporan, 'iiiii', $total_hadir, $total_tidak_hadir, $total_izin, $total_sakit, $guru_id);
        $result_laporan = mysqli_stmt_execute($stmt_laporan);

        if ($result_laporan) {
            $_SESSION['info'] = [
                'status' => 'success',
                'message' => 'Berhasil Absensi '
            ];
        } else {
            $_SESSION['info'] = [
                'status' => 'failed',
                'message' => 'Gagal menyimpan laporan absensi: ' . mysqli_stmt_error($stmt_laporan)
            ];
        }

        mysqli_stmt_close($stmt_laporan);
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Persiapan query laporan gagal: ' . mysqli_error($connection)
        ];
    }
}

header('Location: index.php');
exit;

?>
