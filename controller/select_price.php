<?php
include "koneksi.php";
$id = $_POST['id'];
$sql = mysqli_query($koneksi, "SELECT * FROM item WHERE id='" . $id . "'");
$html = null;
while ($data = mysqli_fetch_array($sql)) {
	$html = $data['harga'];
}
$callback = array('data_kota' => $html);
echo json_encode($callback);
