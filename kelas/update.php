<?php
session_start();
require_once '../helper/connection.php';

$id_kelas = $_POST['id_kelas'];
$nama_kelas = $_POST['nama_kelas'];
$guru_id = $_POST['guru_id'];

$query = mysqli_query($connection, "UPDATE kelas SET nama_kelas = '$nama_kelas', guru_id = '$guru_id' WHERE id_kelas = '$id_kelas'");
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
