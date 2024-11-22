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
    // Memeriksa password 
    $guru = $guru_result->fetch_assoc();
    if ($password == $guru['password_guru']) {
        $_SESSION['login'] = $guru;
        $_SESSION['guru_id'] = $guru['id_guru'];
        header("Location: piket/dashboard/index.php");
        exit;
    } else {
        $error = "Password salah";
    }
  } elseif (mysqli_num_rows($admin_result) === 1) {
    $admin = mysqli_fetch_assoc($admin_result);
    if ($password == $admin['password_admin']) {
        $_SESSION['login'] = $admin;
        header('Location: index.php');
        exit;
    } else {
        $error = "Password salah";
    }
  } else {
    $error = "Username atau password salah";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="shortcut icon" href="assets/img/a.png" type="image/x-icon">
    
    <style>
    body {
        position: relative;
        background-image: url("assets/img/zw.jpg");
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
        min-height: 100vh;
        color: #333;
        font-family: 'Arial', sans-serif;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(5px);
        z-index: -1;
    }

    .header-container {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 10px;
    }

    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .logo-img {
        height: 60px;
        width: auto;
    }

    .school-info {
        text-align: center;
    }

    .school-info h3 {
        color: #2c3e50;
        font-weight: bold;
        margin-bottom: 0;
    }

    .school-info h5 {
        color: #34495e;
        margin: 0;
    }

    .login-card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-top: 20px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
        margin-bottom: 15px;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .btn-success {
        border-radius: 8px;
        padding: 12px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }

    .alert {
        border-radius: 8px;
        margin-top: 15px;
    }

    
    @media (max-width: 768px) {
        .header-container {
            left: 0;
            top: 0;
            padding: 5px;
            text-align: center;
            width: 100%;
        }

        .logo-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .school-info h3,
        .school-info h5 {
            font-size: 18px;
            line-height: 1.2;
            margin: 5px 0;
        }

        .logo-img {
            height: 50px;
        }

        .login-card {
            margin: 20px 10px;
            padding: 20px;
        }
        
        h3.text-center {
            font-size: 24px;
        }
    }

    @media (max-width: 576px) {
        .header-container {
            padding: 3px;
        }

        .login-card {
            padding: 15px;
        }

        .form-control {
            padding: 10px;
        }

        .btn-success {
            padding: 10px;
            font-size: 14px;
        }
    }
    </style>

</head>

<body>
    <div class="container-fluid py-5">
        <!-- Header Section -->
        <div class="header-container">
            <div class="logo-container">
                <img src="assets/img/a.png" alt="logo" class="logo-img">
                <div class="school-info">
                    <h3>SISTEM INFORMASI</h3>
                    <h5>MTS ZUMROTUL WILDAN</h5>
                </div>
            </div>
        </div>

        <!-- Login Section -->
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="pt-5">
                    <h3 class="text-center mb-4">Login</h3>
                    <form method="POST" action="" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" type="text" 
                              class="form-control" name="username" 
                                  required autofocus>
                            <div class="invalid-feedback">
                                Mohon isi username
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" 
                              class="form-control" name="password" 
                              required>
                            <div class="invalid-feedback">
                                Mohon isi kata sandi
                            </div>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <button name="submit" type="submit" 
                            class="btn btn-success btn-lg btn-block">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzFwBhcYI1KFTwpj57jfo"
        crossorigin="anonymous"></script>
</body>

</html>
