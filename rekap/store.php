<?php
session_start();
require_once '../helper/connection.php';

$id_laporan = $_POST['id_laporan'];
$absensi_id = $_POST['absensi_id'];
$total_hadir = $_POST['total_hadir'];
$total_tidak_hadir = $_POST['total_tidak_hadir'];
$total_izin = $_POST['total_izin'];
$total_sakit = $_POST['total_sakit'];
$guru_id = $_POST['guru_id'];
$query = mysqli_query($connection, "INSERT INTO laporan_absensi (id_laporan, absensi_id, total_hadir,total_tidak_hadir,total_izin,total_sakit,status) values ('$id_laporan', '$absensi_id', '$total_hadir','$total_tidak_hadir','$total_izin','$total_sakit','$guru_id')");
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
