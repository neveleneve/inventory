<?php
require($_SERVER['DOCUMENT_ROOT'] . '/inventory/controller/koneksi.php');

$query = mysqli_query($koneksi, "SELECT * FROM transaksi");
$row = mysqli_fetch_all($query);
print_r($row);
