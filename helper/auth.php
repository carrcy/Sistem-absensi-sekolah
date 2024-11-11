<?php
session_start();

function isLogin($requiredRole = null)
{
    // Pastikan pengguna sudah login
    if (!isset($_SESSION['login'])) {
        header('Location: ../login.php');
        exit;
    }

    // Jika peran diperlukan, pastikan role pengguna sesuai
    if ($requiredRole !== null) {
        // Cek apakah pengguna memiliki peran yang sesuai
        if ($requiredRole === 'admin' && !isset($_SESSION['login']['username_admin'])) {
            header('Location: ../login.php');
            exit;
        }
        if ($requiredRole === 'guru' && !isset($_SESSION['login']['username_guru'])) {
            header('Location: ../login.php');
            exit;
        }
    }
}
