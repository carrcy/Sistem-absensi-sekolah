<?php
require_once '../helper/connection.php';

// Pastikan sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data dari POST
$tanggal = $_POST['tanggal'];
$jadwal_id = $_POST['jadwal_id'];
$kelas_id = $_POST['kelas_id'];
$guru_id = $_SESSION['login']['id_guru'];
$status_kehadiran = $_POST['status'];

// Inisialisasi total
$total_hadir = 0;
$total_tidak_hadir = 0;
$total_izin = 0;
$total_sakit = 0;

// Loop melalui setiap siswa untuk menyimpan data kehadiran
foreach ($status_kehadiran as $siswa_id => $status) {
    // Hitung total berdasarkan status
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

    // Query untuk menyimpan data ke tabel absensi
    $query_absensi = "INSERT INTO absensi (tanggal, status_kehadiran, siswa_id, kelas_id, guru_id, jadwal_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_absensi = mysqli_prepare($connection, $query_absensi);

    // Cek apakah query absensi berhasil dipersiapkan
    if (!$stmt_absensi) {
        die('Query absensi preparation failed: ' . mysqli_error($connection));
    }

    // Bind parameter dan eksekusi untuk menyimpan absensi
    mysqli_stmt_bind_param($stmt_absensi, 'ssiiii', $tanggal, $status, $siswa_id, $kelas_id, $guru_id, $jadwal_id);
    $result_absensi = mysqli_stmt_execute($stmt_absensi);

    // Cek jika penyimpanan absensi gagal
    if (!$result_absensi) {
        die('Execute absensi failed: ' . mysqli_stmt_error($stmt_absensi));
    }
}

// Simpan laporan absensi setelah semua data absensi siswa tersimpan
$query_laporan = "INSERT INTO laporan_absensi (total_hadir, total_tidak_hadir, total_izin, total_sakit, guru_id) VALUES (?, ?, ?, ?, ?)";
$stmt_laporan = mysqli_prepare($connection, $query_laporan);

// Cek apakah query laporan berhasil dipersiapkan
if (!$stmt_laporan) {
    die('Query laporan preparation failed: ' . mysqli_error($connection));
}

// Bind dan eksekusi query untuk menyimpan laporan
mysqli_stmt_bind_param($stmt_laporan, 'iiiii', $total_hadir, $total_tidak_hadir, $total_izin, $total_sakit, $guru_id);
$result_laporan = mysqli_stmt_execute($stmt_laporan);

// Periksa apakah penyimpanan laporan berhasil
if ($result_laporan) {
    // Tambahkan informasi jika laporan berhasil disimpan
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Data absensi dan laporan berhasil disimpan!'
    ];
} else {
    // Set session info untuk memberi tahu pengguna bahwa penyimpanan gagal
    $_SESSION['info'] = [
        'status' => 'error',
        'message' => 'Gagal menyimpan data laporan absensi!'
    ];
}

// Redirect kembali ke halaman absensi
header("Location: index.php");  
exit;
?>
