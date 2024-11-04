<?php
session_start();
require_once '../helper/connection.php';

$id_jadwal = $_POST['id_jadwal'];
$hari = $_POST['hari'];
$jam = $_POST['jam'];
$mata_pelajaran = $_POST['mata_pelajaran'];
$kelas_id = $_POST['kelas_id'];
$guru_id = $_POST['guru_id'];

$query = mysqli_query($connection, "insert into jadwal(id_jadwal, hari, jam, mata_pelajaran, kelas_id, guru_id) value('$id_jadwal', '$hari','$jam','$mata_pelajaran', '$kelas_id', '$guru_id')");
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
