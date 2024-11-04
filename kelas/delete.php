<?php
session_start();
require_once '../helper/connection.php';

$id_kelas= $_GET['id_kelas'];

$result = mysqli_query($connection, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");

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
