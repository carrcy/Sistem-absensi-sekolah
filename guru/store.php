<?php
session_start();
require_once '../helper/connection.php';

$nip = $_POST['id_guru'];
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$username_guru = $_POST['username_guru'];
$password_guru = $_POST['password_guru'];

$query = mysqli_query($connection, "INSERT INTO guru (id_guru, nip, nama, alamat, username_guru, password_guru) VALUES('$id_guru', '$nip', '$nama', '$alamat', '$username_guru','$password_guru')");
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
