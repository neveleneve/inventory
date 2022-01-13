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
$status = $_GET['status'];
$id = $_GET['id'];
$idtrx = $_GET['id_trx'];
// =============================================
$data = mysqli_query($koneksi, "SELECT * FROM transaksi where id = '$id'");
$row = mysqli_fetch_all($data);
// =============================================
$id_barang = $row[0][2];
$jumlah = $row[0][3];
// =============================================
if ($status == 'B') {
    mysqli_query($koneksi, "UPDATE item set stok = stok - $jumlah  where id = '$id_barang'");
} else if($status == 'J'){
    mysqli_query($koneksi, "UPDATE item set stok = stok + $jumlah  where id = '$id_barang'");
}
mysqli_query($koneksi, "DELETE FROM transaksi where id = '$id'");
// =============================================
header('location: ../transaksi/add/penjualan');
