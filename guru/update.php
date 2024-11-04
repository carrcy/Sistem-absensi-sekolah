<?php
session_start();
require_once '../helper/connection.php';

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$username_guru = $_POST['username_guru'];
$password_guru = $_POST['password_guru'];

$query = mysqli_query($connection, "UPDATE guru SET nama = '$nama', alamat = '$alamat', username_guru = '$username_guru', password_guru = '$password_guru' WHERE nip = '$nip'");
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
