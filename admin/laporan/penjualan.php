<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inventory/controller/controldata.php';
$controller = new admin();
session_start();
if (!isset($_SESSION['role'])) {
    header('location: ../../');
} else if ($_POST['tahun'] == null) {
    header('location: ../transaksi/pembelian');
} else {
    $namaadmin = $_SESSION['adminname'];
    $admin = $_SESSION['admin'];
    $role = $_SESSION['role'];
}

function bulan($angka)
{
    switch ($angka) {
        case '01':
            return 'Januari';
            break;
        case '02':
            return 'Februari';
            break;
        case '03':
            return 'Maret';
            break;
        case '04':
            return 'Apri';
            break;
        case '05':
            return 'Mei';
            break;
        case '06':
            return 'Juni';
            break;
        case '07':
            return 'Juli';
            break;
        case '08':
            return 'Agustus';
            break;
        case '09':
            return 'September';
            break;
        case '10':
            return 'Oktober';
            break;
        case '11':
            return 'November';
            break;
        case '12':
            return 'Desember';
            break;

        default:
            # code...
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran Barang</title>
    <link rel="stylesheet" href="../../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/font-awesome/css/all.min.css">
</head>

<body>
    <div class="container mt-3">
        <div class="row mb-2">
            <div class="col-2">
                <img src="../../assets/img/kcb.jpeg" alt="" style="width: 100%;">
            </div>
            <div class="col-8">
                <?php
                if (!isset($_POST['bulan'])) {
                    echo '<h2 class="text-center font-weight-bold">Laporan Pengeluaran Barang Tahunan</h2>';
                    echo '<h4 class="text-center font-weight-bold">PT. Kepri Citra Buana</h4>';
                    echo '<h6 class="text-center font-weight-bold">Tahun ' . $_POST['tahun'] . '</h6>';
                } else {
                    echo '<h2 class="text-center font-weight-bold">Laporan Pengeluaran Barang Bulanan</h2>';
                    echo '<h4 class="text-center font-weight-bold">PT. Kepri Citra Buana</h4>';
                    echo '<h6 class="text-center font-weight-bold">Bulan ' . bulan($_POST['bulan']) . ' ' . $_POST['tahun'] . '</h6>';
                }
                ?>
            </div>
            <div class="col-2">
            </div>
        </div>
        <div class="dropdown-divider border border-dark mb-5"></div>
        <div class="row justify-content-center mb-2">
            <div class="col-10">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="font-weight-bold">No</th>
                            <th class="font-weight-bold">ID Transaksi</th>
                            <th class="font-weight-bold">Tanggal</th>
                            <th class="text-right font-weight-bold">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sumtotal = 0;
                        if (!isset($_POST['bulan'])) {
                            $datatrx = $controller->laporanpenjualan(null, $_POST['tahun']);
                        } else {
                            $datatrx = $controller->laporanpenjualan($_POST['bulan'], $_POST['tahun']);
                        }
                        if ($datatrx) {
                            foreach ($datatrx as $key) {
                        ?>
                                <tr>
                                    <td>
                                        <?= $no++ ?>
                                    </td>
                                    <td>
                                        <?= $key['id_trx'] ?>
                                    </td>
                                    <td>
                                        <?= date_format(date_create($key['tanggal']), 'd') . ' ' . bulan(date_format(date_create($key['tanggal']), 'm')) . ' ' . date_format(date_create($key['tanggal']), 'Y')  ?>
                                    </td>
                                    <td class="text-right border-left-0">
                                        Rp. <?= number_format($key['total'], 0, ',', '.')  ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                Detail Pembelian <?= $key['id_trx'] ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Barang</th>
                                                            <th>Jumlah</th>
                                                            <th>Harga</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $barang = $controller->databaranglaporan($key['id_trx']);
                                                        $nobrg = 1;
                                                        foreach ($barang as $data) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $nobrg++ ?></td>
                                                                <td><?= $data['namabarang'] ?></td>
                                                                <td><?= $data['jumlah'] ?></td>
                                                                <td>Rp. <?= number_format($data['harga'], 0, ',', '.') ?></td>
                                                                <td>Rp. <?= number_format($data['harga'] * $data['jumlah'], 0, ',', '.') ?></td>

                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $sumtotal += $key['total'];
                            }
                        } else { ?>
                            <tr>
                                <td colspan="4">
                                    <h1 class="text-center">Data Kosong</h1>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                Total
                            </td>
                            <td class="text-right border-left-0">
                                Rp. <?= number_format($sumtotal, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-4 text-center">
                <h6 class="font-weight-bold">Pimpinan</h6>
                <br>
                <br>
                <br>
                <br>
                <h6>(............................)</h6>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-10">
                <a href="javascript:window.print()" class="btn btn-sm red lighten-1 noprint">
                    Cetak
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../../assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/popper.min.js"></script>
    <script type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../assets/font-awesome/js/all.min.js"></script>
    <script type="text/javascript" src="../../assets/js/mdb.min.js"></script>
</body>

</html>