<?php
session_start();
require_once '../helper/connection.php';

$id_laporan= $_GET['id_laporan'];

$result = mysqli_query($connection, "DELETE FROM laporan_absensi WHERE id_laporan='$id_laporan'");

if (mysqli_affected_rows($connection) > 0) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
