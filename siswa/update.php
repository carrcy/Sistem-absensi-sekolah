<?php
session_start();
require_once '../helper/connection.php';

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas_id = $_POST['kelas_id'];
$alamat = $_POST['alamat'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$admin_id = $_POST['admin_id'];

$query = mysqli_query($connection, "UPDATE siswa SET nama = '$nama', kelas_id = '$kelas_id', alamat = '$alamat', tanggal_lahir = '$tanggal_lahir' WHERE nis = '$nis'");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil mengubah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
