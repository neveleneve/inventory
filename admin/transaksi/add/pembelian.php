<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inventory/controller/controldata.php';
$controller = new admin();
$idtrx = $controller->getnewidtrx();
session_start();
if (!isset($_SESSION['role'])) {
    header('location: ../');
} else {
    $namaadmin = $_SESSION['adminname'];
    $admin = $_SESSION['admin'];
    $role = $_SESSION['role'];
    // ===================================
    $controller->refreshcancel($idtrx, 'B');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pemasukan</title>
    <link rel="stylesheet" href="../../../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/font-awesome/css/all.min.css">
    <script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
</head>

<body>
    <header>
        <?php
        include '../../../layouts/navbar.php'
        ?>
    </header>
    <main class="mt-5 mb-5">
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card card-cascade narrower">
                        <div class="view view-cascade gradient-card-header blue-gradient">
                            <h2 class="card-header-title">Transaksi Pemasukan</h2>
                        </div>
                        <div class="card-body card-body-cascade text-center">
                            <form action="../../../controller/controldata.php" method="post">
                                <input type="hidden" name="jenis" value="B">
                                <div class="md-form">
                                    <label class="font-weight-bold" for="total">ID Transaksi</label>
                                    <input class="form-control text-center" type="text" name="id_trx" id="id_trx" value="<?= $idtrx ?>" required readonly>
                                </div>
                                <div class="md-form">
                                    <select autofocus class="browser-default custom-select" name="selectbarang" id="selectbarang" required oninvalid="this.setCustomValidity('Pilih Salah Satu Barang Untuk Di Jual')">
                                        <option value="" selected disabled hidden>Pilih Barang</option>
                                        <?php
                                        $databarang = $controller->databaranglist('B');
                                        if ($databarang) {
                                            foreach ($databarang as $key) { ?>
                                                <option value="<?= $key['id'] ?>"><?= $key['nama'] ?></option>
                                            <?php }
                                        } else { ?>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="md-form">
                                    <label class="font-weight-bold" for="total">Harga</label>
                                    <input class="form-control text-center" type="text" name="harga" id="harga" min="0" readonly required>
                                    <input class="form-control text-center" type="hidden" name="hiddenharga" id="hiddenharga" value="" required>
                                </div>
                                <div class="md-form">
                                    <label class="font-weight-bold" for="total">Jumlah</label>
                                    <input class="form-control text-center" type="number" name="jumlah" id="jumlah" value="" min="1" required oninput="changetotal()">
                                </div>
                                <div class="md-form">
                                    <label class="font-weight-bold" for="total">Total</label>
                                    <input class="form-control text-center" type="text" name="total" id="total" value="Rp. 0,00" readonly required>
                                    <input class="form-control text-center" type="hidden" name="hiddentotal" id="hiddentotal" value="">
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <button type="submit" name="bataltransaksipenjualan" class="btn btn-sm red accent-4 btn-block font-weight-bold white-text" onClick="removeRequired(this.form)">Kembali</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-sm green accent-4 btn-block font-weight-bold white-text" data-target="#modal" data-toggle="modal">Selesai</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" name="tambahtransaksipenjualan" class="btn btn-sm blue accent-4 btn-block font-weight-bold white-text">Tambah</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-1"></th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $databarang = null;
                                            $total = 0;
                                            $databarang = $controller->showtrxinadding($idtrx);
                                            if ($databarang) {
                                                foreach ($databarang as $key) { ?>
                                                    <tr class="text-center">
                                                        <td>
                                                            <a href="../../../admin/hapus/transaksi_barang.php?id=<?= $key['id'] ?>&id_trx=<?= $key['id_trx'] ?>&status=B" onclick="return confirm('Hapus Barang Transaksi Ini?')" class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                        <td><?= $key['namabarang'] ?></td>
                                                        <td>Rp. <?= number_format($key['harga'], 0, ',', '.') ?></td>
                                                        <td><?= $key['jumlah'] ?></td>
                                                        <td class="text-right">Rp. <?= number_format($key['harga'] * $key['jumlah'], 0, ',', '.') ?></td>
                                                        <?php $total += $key['harga'] * $key['jumlah'] ?>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <h4 class="text-center">Belum Ada Transaksi</h4>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right" colspan="5">
                                                    Rp. <?= number_format($total, 0, ',', '.') ?>
                                                </td>
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
    <footer>

    </footer>
    <div class="modal fade bottom" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Transaksi Pembelian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../../../controller/controldata.php" method="post">
                    <div class="modal-body">
                        <div class="form-row">
                            <input type="hidden" name="jenis" value="B">
                            <div class="col">
                                <input class="form-control-plaintext" type="text" id="id_trx" name="id_trx" placeholder="Nama Barang" value="<?= $idtrx ?>" required readonly>
                            </div>
                            <div class="col">
                                <select class="form-control" name="idsupplier" id="idsupplier" required oninvalid="this.setCustomValidity('Pilih Salah Satu Supplier')">
                                    <option value="" selected disabled>Pilih Supplier</option>
                                    <?php
                                    $databarang = $controller->datasupplier(null);
                                    if ($databarang) {
                                        foreach ($databarang as $key) { ?>
                                            <option value="<?= $key['id'] ?>"><?= $key['nama'] ?></option>
                                        <?php }
                                    } else { ?>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" name="selesaitransaksipenjualan" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#pilihsupplier").hide();
        $(document).ready(function() {
            $("#selectbarang").change(function() {
                $.ajax({
                    type: "POST",
                    url: "../../../controller/select_price.php",
                    data: {
                        id: $("#selectbarang").val()
                    },
                    dataType: "json",
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(response) {
                        $("#harga").val(new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(response.data_kota));
                        $("#harga").focus();
                        $("#hiddenharga").val(response.data_kota);
                        $("#jumlah").val('');
                        $("#jumlah").focus();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });
            });
        });

        function changetotal() {
            var harga = document.getElementById('hiddenharga');
            var jumlah = document.getElementById('jumlah');
            var tot = document.getElementById('total');
            var hidtot = document.getElementById('hiddentotal');

            var total = harga.value * jumlah.value;
            hidtot.value = total;
            tot.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(total);
            tot.focus();
            jumlah.focus();
            tot.prop('disabled', true);
        }

        function removeRequired(form) {
            $.each(form, function(key, value) {
                if (value.hasAttribute("required")) {
                    value.removeAttribute("required");
                }
            });
        }
    </script>
    <script type="text/javascript" src="../../../assets/js/popper.min.js"></script>
    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../../assets/font-awesome/js/all.min.js"></script>
    <script type="text/javascript" src="../../../assets/js/mdb.min.js"></script>
</body>

</html>