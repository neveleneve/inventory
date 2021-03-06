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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier</title>
    <link rel="stylesheet" href="../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/all.min.css">
</head>

<body>
    <header>
        <?php
        include '../layouts/navbar.php';
        ?>
    </header>
    <main class="mt-5">
        <div class="container pt-5">
            <div class="row mb-2">
                <div class="col-12">
                    <h5 class="font-weight-bold text-center">Daftar Supplier</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="supplier" method="get">
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1 red-border" type="text" id="cari" name="cari" placeholder="Pencarian" oninvalid="this.setCustomValidity('Isi Kolom Ini Untuk Mencari')" required>
                            <div class="input-group-append">
                                <span class="input-group-text yellow lighten-1" id="basic-text1">
                                    <i class="fas fa-search text-grey" aria-hidden="true"></i>
                                </span>
                                <span title="Tambah Supplier" class="input-group-text blue lighten-1" data-target="#fullHeightModalRight" data-toggle="modal">
                                    <i class="fas fa-plus text-grey"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered">
                            <thead class="special-color white-text">
                                <tr>
                                    <th class="text-center font-weight-bold">No.</th>
                                    <th class="text-center font-weight-bold">Nama Supplier</th>
                                    <th class="text-center font-weight-bold">Alamat</th>
                                    <th class="text-center font-weight-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $datasupplier = null;
                                if (!isset($_GET['cari'])) {
                                    $datasupplier = $controller->datasupplier(null);
                                } else if($_GET['cari'] == '') {
                                    $datasupplier = $controller->datasupplier(null);
                                }else {
                                    $id = $_GET['cari'];
                                    $datasupplier = $controller->datasupplier($id);
                                }

                                if ($datasupplier) {
                                    foreach ($datasupplier as $key) { ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= $key['nama'] ?></td>
                                            <td><?= $key['alamat'] ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="profil/index?id=<?= $key['id'] ?>">Profil</a>
                                                <a class="btn btn-sm btn-warning" href="transaksi/index?id=<?= $key['id'] ?>">Transaksi</a>
                                                <a class="btn btn-sm btn-danger" href="hapus/supplier?id=<?= $key['id'] ?>" onclick="return confirm('Hapus Data Supplier?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4">
                                            <h4 class="text-center">Data Kosong</h4>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>

    <div class="modal fade bottom" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-full-height modal-bottom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../controller/controldata.php" method="post">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama Supplier" required>
                            </div>
                            <div class="col">
                                <input class="form-control" type="text" id="alamat" name="alamat" placeholder="Alamat Supplier" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" name="tambahsupplier" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/popper.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/font-awesome/js/all.min.js"></script>
    <script type="text/javascript" src="../assets/js/mdb.min.js"></script>
</body>

</html>