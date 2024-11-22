<?php
session_start();
require_once '../helper/connection.php';

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas_id = $_POST['kelas_id'];
$alamat = $_POST['alamat'];
$tanggal_lahir = $_POST['tanggal_lahir'];

$query = mysqli_query($connection, "INSERT INTO siswa (nis, nama, kelas_id, alamat, tanggal_lahir) VALUES ('$nis', '$nama', '$kelas_id','$alamat','$tanggal_lahir')");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
