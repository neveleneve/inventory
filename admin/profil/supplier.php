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
$datax = $controller->datapersonalsupplier($id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Supplier</title>
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
                            <h2 class="card-header-title">Profil Supplier</h2>
                        </div>
                        <div class="card-body card-body-cascade text-center">
                            <form action="../../controller/controldata.php" method="post">
                                <input type="hidden" name="idsupplier" value="<?= $id ?>">
                                <div class="md-form">
                                    <label class="font-weight-bold" for="namasupplier">Nama Supplier</label>
                                    <input class="form-control text-center" type="text" name="namasupplier" id="namasupplier" value="<?= $datax[0]['nama'] ?>">
                                </div>
                                <div class="md-form">
                                    <label class="font-weight-bold" for="alamatsupplie">Alamat Supplier</label>
                                    <input class="form-control text-center" type="text" name="alamatsupplier" id="alamatsupplier" value="<?= $datax[0]['alamat'] ?>">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="../supplier" class="btn btn-sm red accent-4 btn-block font-weight-bold white-text">Kembali</a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="ubahdatasupplier" class="btn btn-sm blue accent-4 btn-block font-weight-bold white-text">Ubah</button>
                                    </div>
                                </div>
                            </form>
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