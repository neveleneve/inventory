<?php
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
$id = $_SESSION['idsupplier'];
$datasup = $controller->datapersonalsupplier($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Supplier</title>
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
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card card-cascade narrower">
                        <div class="view view-cascade gradient-card-header blue-gradient">
                            <h2 class="card-header-title">Transaksi Supplier</h2>
                        </div>
                        <div class="card-body card-body-cascade text-center">
                            <div class="row">
                                <div class="col-12">
                                    <h5><?= $datasup[0]['nama'] ?></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover table-bordered">
                                        <thead class="special-color white-text">
                                            <tr>
                                                <td>No</td>
                                                <td>ID Transaksi</td>
                                                <td>Total Belanja</td>
                                                <td>Tanggal Belanja</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $datax = $controller->transaksisupplier($id);
                                            if ($datax) {
                                                foreach ($datax as $key) { ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><a href="view?id_trx=<?= $key['id'] ?>"><?= $key['id'] ?></a></td>
                                                        <td>Rp. <?= number_format($key['total'], 0, ',', '.') ?></td>
                                                        <td><?= $key['tanggal'] ?></td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="4">
                                                        <h3>Data Kosong</h3>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn red accent-4 btn-block white-text" href="../supplier">Kembali</a>
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