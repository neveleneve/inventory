<?php
session_start();
include 'koneksi.php';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username ='$username' AND password='$password'");
    if (mysqli_num_rows($query) == 0) {
        echo '<script>alert("Data login anda salah! Silahkan Ulangi!");window.location.href="../";</script>';
    } else {
        $row = mysqli_fetch_assoc($query);
        if ($row) {
            $_SESSION['admin'] = $username;
            $_SESSION['adminname'] = $row['nama'];
            $_SESSION['role'] = $row['level'];
            echo '<script>alert("Selamat Datang, ' . $row['nama'] . '! Anda Akan Diarahkan ke Halaman Dashboard...!");window.location.href="../admin";</script>';
        }
    }
}
