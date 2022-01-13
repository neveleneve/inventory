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
    $data = $controller->dashboard();
}
// print_r($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/all.min.css">
</head>

<body onload="display_ct()">
    <header>
        <?php
        include '../layouts/navbar.php'
        ?>
    </header>
    <main class="mt-5 mb-5">
        <div class="container pt-5">
            <div class="row">
                <div class="col-4">
                    <div class="blockquote bq-primary">
                        <p class="bq-title">
                            Jenis Barang Tersedia : <?= $data[0][0] ?>
                        </p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="blockquote bq-danger">
                        <p class="bq-title">
                            Transaksi Penjualan : <?= $data[2][0] ?>
                        </p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="blockquote bq-warning">
                        <p class="bq-title">
                            Transaksi Pembelian : <?= $data[1][0] ?>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 text-center text-danger">
                    <h2 id="ct"></h2>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/popper.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/font-awesome/js/all.min.js"></script>
    <script type="text/javascript" src="../assets/js/mdb.min.js"></script>
    <script type="text/javascript">
        function display_c() {
            var refresh = 1000; // Refresh rate in milli seconds
            mytime = setTimeout('display_ct()', refresh);
        }

        function display_ct() {
            var hours = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
            var minutes = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'];
            var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            var x = new Date()
            var y = x.getDate() + ' ' + months[x.getMonth()] + ' ' + x.getFullYear() + ' ' + 'Pukul ' + hours[x.getHours()] + ':' + minutes[x.getMinutes()] + ':' + minutes[x.getSeconds()];
            document.getElementById('ct').innerHTML = y;
            display_c();
        }
    </script>
</body>

</html>