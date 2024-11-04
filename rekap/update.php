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
$query = mysqli_query($connection, "UPDATE laporan_absensi SET absensi_id = '$absensi_id', total_hadir = '$total_hadir', total_tidak_hadir ='$total_tidak_hadir' , total_izin='$total_izin', total_sakit='$total_sakit', guru_id='$guru_id' WHERE nim = '$nim'");
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
