<?php
$idtrx = $_GET['id_trx'];
require $_SERVER['DOCUMENT_ROOT'] . '/inventory/controller/controldata.php';
$controller = new admin();
session_start();
if (!isset($_SESSION['role'])) {
    header('location: ../');
} else {
    $namaadmin = $_SESSION['adminname'];
    $admin = $_SESSION['admin'];
    $role = $_SESSION['role'];
}
$data = $controller->showtrx($idtrx);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Transaksi</title>
    <link rel="stylesheet" href="../../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">
</head>

<body>
    <header>
        <?php
        include '../../layouts/navbar.php'
        ?>
    </header>
    <main class="mt-5 mb-5">
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card card-cascade narrower">
                        <div class="view view-cascade gradient-card-header blue-gradient">
                            <h2 class="card-header-title">Lihat Transaksi</h2>
                        </div>
                        <div class="card-body card-body-cascade text-center">
                            <div class="md-form">
                                <label class="font-weight-bold" for="namasupplier">ID Transaksi</label>
                                <input class="form-control text-center" type="text" name="idtrx" id="idtrx" value="<?= $data[0]['id_trx'] ?>" readonly>
                            </div>
                            <div class="md-form">
                                <label class="font-weight-bold" for="namasupplier">Jenis</label>
                                <input class="form-control text-center" type="text" name="jenistrx" id="jenistrx" value="<?= $data[0]['jenis'] == 'B' ? 'Pembelian' : 'Penjualan'  ?>" readonly>
                            </div>
                            <?php
                            if ($data[0]['jenis'] == 'B') {
                                $nama = $controller->getsupname($data[0]['id_trx']);
                            ?>
                                <div class="md-form">
                                    <label class="font-weight-bold" for="namasupplier">Nama Supplier</label>
                                    <input class="form-control text-center" type="text" name="namasupplier" id="namasupplier" value="<?= $nama[0]['nama'] ?>" readonly>
                                </div>
                            <?php } ?>
                            <div class="md-form">
                                <label class="font-weight-bold" for="alamatsupplie">Tanggal Transaksi</label>
                                <input class="form-control text-center" type="text" name="tanggal" id="tanggal" value="<?= date('d M Y',  strtotime($data[0]['tanggal'])) ?>" readonly>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="<?= $data[0]['jenis'] == 'B' ? 'pembelian' : 'penjualan'  ?>" class="btn btn-sm red accent-4 btn-block font-weight-bold white-text">Kembali</a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover">
                                        <thead class="special-color white-text">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $total = 0;
                                            $totalsemua = 0;
                                            foreach ($data as $key) {
                                                $total = $key['harga'] * $key['jumlah'];
                                            ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $key['namabarang'] ?></td>
                                                    <td><?= $key['jumlah'] ?></td>
                                                    <td class="text-right">Rp. <?= number_format($key['harga'] , 0, ',', '.') ?></td>
                                                    <td class="text-right">Rp. <?= number_format($total, 0, ',', '.') ?></td>
                                                </tr>
                                            <?php
                                                $totalsemua += $total;
                                            } ?>
                                        </tbody>
                                        <tfoot class="special-color">
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="font-weight-bold white-text">Total</td>
                                                <td class=" text-right font-weight-bold white-text">Rp. <?= number_format($totalsemua, 0, ',', '.') ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="../../assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/popper.min.js"></script>
    <script type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../assets/font-awesome/js/all.min.js"></script>
    <script type="text/javascript" src="../../assets/js/mdb.min.js"></script>
</body>

</html>