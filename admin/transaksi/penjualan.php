<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inventory/controller/controldata.php';
$controller = new admin();
session_start();
if (!isset($_SESSION['role'])) {
    header('location: ../../');
} else {
    $namaadmin = $_SESSION['adminname'];
    $admin = $_SESSION['admin'];
    $role = $_SESSION['role'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pengeluaran</title>
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
    <main class="mt-5">
        <div class="container pt-5">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="font-weight-bold text-center">Data Transaksi Pengeluaran</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="penjualan" method="get">
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1 red-border" type="text" value="<?= !isset($_GET['cari']) ? '' : $_GET['cari'] ?>" id="cari" name="cari" placeholder="Pencarian" oninvalid="this.setCustomValidity('Isi Kolom Ini Untuk Mencari')" required>
                            <div class="input-group-append">
                                <span class="input-group-text yellow lighten-1" id="basic-text1">
                                    <i class="fas fa-search text-grey" aria-hidden="true"></i>
                                </span>
                                <a href="add/penjualan" title="Tambah Transaksi Penjualan" class="input-group-text blue lighten-1">
                                    <i class="fas fa-plus text-grey"></i>
                                </a>
                                <a href="#" title="Cetak Laporan" class="input-group-text red lighten-1" data-toggle="modal" data-target="#modalcetak">
                                    <i class="fas fa-print text-dark"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            if (!isset($_GET['cari'])) {
                // 
            } else if ($_GET['cari'] == '') {
                // 
            } else {
            ?>
                <div class="row">
                    <div class="col-12">
                        <p>Pencarian Untuk '<?= $_GET['cari'] ?>' <a class="text-dark" href="penjualan">Tekan untuk kembali</a></p>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered">
                            <thead class="special-color white-text">
                                <tr>
                                    <th class="text-center font-weight-bold">No.</th>
                                    <th class="text-center font-weight-bold">ID Transaksi</th>
                                    <th class="text-center font-weight-bold">Total Transaksi</th>
                                    <th class="text-center font-weight-bold">Tanggal</th>
                                    <th class="text-center font-weight-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $databarang = null;
                                if (!isset($_GET['cari'])) {
                                    $databarang = $controller->transaksi(null, 'J');
                                } else if ($_GET['cari'] == '') {
                                    $databarang = $controller->transaksi(null, 'J');
                                } else {
                                    $id = $_GET['cari'];
                                    $databarang = $controller->transaksi($id, 'J');
                                }

                                if ($databarang) {
                                    foreach ($databarang as $key) { ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= $key['id_trx'] ?></td>
                                            <td>Rp. <?= number_format($key['total'], 0, ',', '.') ?></td>
                                            <td><?= date("d M Y", strtotime($key['tanggal'])) ?></td>
                                            <td>
                                                <a href="view?id_trx=<?= $key['id_trx'] ?>" class="btn btn-sm btn-warning">View</a>
                                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4">
                                            <h4 class="text-center">Data Kosong</h4>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
    <div class="modal fade" id="modalcetak">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Cetak Laporan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modaltahunan" class="btn btn-sm red lighten-3 btn-block text-dark font-weight-bold">Cetak Laporan Tahunan</a>
                        </div>
                        <div class="col-12">
                            <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalbulanan" class="btn btn-sm blue lighten-3 btn-block text-dark font-weight-bold">Cetak Laporan Bulanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalbulanan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Cetak Laporan Bulanan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form target="_blank" action="../laporan/penjualan" method="post">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <select class="form-control form-control-sm" name="bulan" id="bulan" required>
                                    <option selected disabled hidden value="">Pilih Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <select class="form-control form-control-sm" name="tahun" id="tahun" required>
                                    <option selected disabled hidden value="">Pilih Tahun</option>
                                    <?php
                                    for ($i = 0; $i < 5; $i++) {
                                    ?>
                                        <option value="<?= date('Y') - $i ?>"><?= date('Y') - $i ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm cyan lighten-3">Cetak</button>
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalcetak" class="btn btn-sm pink lighten-3">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modaltahunan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Cetak Laporan Tahunan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form target="_blank" action="../laporan/penjualan" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <select class="form-control form-control-sm" name="tahun" id="tahun" required>
                                    <option selected disabled hidden value="">Pilih Tahun</option>
                                    <?php
                                    for ($i = 0; $i < 5; $i++) {
                                    ?>
                                        <option value="<?= date('Y') - $i ?>"><?= date('Y') - $i ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm cyan lighten-3">Cetak</button>
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalcetak" class="btn btn-sm pink lighten-3">Kembali</a>
                    </div>
                </form>
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