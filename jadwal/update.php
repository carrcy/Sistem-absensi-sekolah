<?php
session_start();
require_once '../helper/connection.php';

$id_jadwal = $_POST['id_jadwal'];
$hari = $_POST['hari'];
$jam = $_POST['jam'];
$mata_pelajaran = $_POST['mata_pelajaran'];

$query = mysqli_query($connection, "UPDATE matakuliah SET hari = '$hari', jam = '$jam', mata_pelajaran = '$mata_pelajaran' WHERE id_jadwal = '$id_jadwal'");
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
