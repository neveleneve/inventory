<?php
require($_SERVER['DOCUMENT_ROOT'] . '/inventory/controller/koneksi.php');
session_start();
if (!isset($_SESSION['role'])) {
    header('location: ../');
} else {
    $namaadmin = $_SESSION['adminname'];
    $admin = $_SESSION['admin'];
    $role = $_SESSION['role'];
}
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM item where id = '$id'");
header('location: ../barang');
