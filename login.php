<?php
require_once 'helper/connection.php';
session_start();

$error = false; // Tambahkan ini untuk menghindari peringatan "undefined variable"

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Memeriksa apakah user adalah guru atau admin
  $guru_query = "SELECT * FROM guru WHERE username_guru='$username'";
  $admin_query = "SELECT * FROM admin WHERE username_admin='$username'";

  $guru_result = mysqli_query($connection, $guru_query);
  $admin_result = mysqli_query($connection, $admin_query);

  if ($guru_result->num_rows > 0) {
    // Memeriksa password guru
    $guru = $guru_result->fetch_assoc();
    if ($password == $guru['password_guru']) {
      $_SESSION['login'] = $guru;
      $_SESSION['guru_id'] = $guru['id_guru']; // Simpan id_guru dalam sesi
      header("Location: piket/dashboard/index.php");
      exit;
    } else {
      $error = "Password salah"; // Menyimpan pesan kesalahan
    }
  } elseif (mysqli_num_rows($admin_result) === 1) {
    // Memeriksa admin umum
    $admin = mysqli_fetch_assoc($admin_result);
    if ($password == $admin['password_admin']) {
      $_SESSION['login'] = $admin;
      header('Location: index.php');
      exit;
    } else {
      $error = "Password salah"; // Menyimpan pesan kesalahan
    }
  } else {
    $error = "Username atau password salah"; // Pesan jika user tidak ditemukan
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; ABSENKU</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="shortcut icon" href="assets/img/a.png" type="image/x-icon">
  <style>
    body {
      background-image: url("assets/img/c.jpg");
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      height: 100%;
    }

    .card {
      backdrop-filter: none;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
    }
  </style>

</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/a.png" alt="logo" width="200">
            </div>
            <div class="card card-success">
              <div class="card-header">
                <h4>Login</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Mohon isi username
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Mohon isi kata sandi
                    </div>
                  </div>
                  
                  <?php if ($error): ?>
                    <div class="alert alert-danger">
                      <?= $error; ?>
                    </div>
                  <?php endif; ?>
                  <div class="form-group">
                    <button name="submit" type="submit" class="btn btn-success btn-lg btn-block" tabindex="3">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>

</html>