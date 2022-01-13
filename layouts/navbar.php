<?php
function PageName()
{
    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
}

function linkfull()
{
    return $_SERVER['REQUEST_URI'];
}
$current_page = PageName();
$link = linkfull();
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top scrolling-navbar <?= !isset($_SESSION['role']) ? 'rgba-black-strong' : 'blue-gradient' ?>">
    <div class="container">
        <a class="navbar-brand font-weight-bold <?= !isset($_SESSION['role']) ? '' : 'text-light' ?>" href="/inventory">PT. Kepri Citra Buana</a>
        <?php
        if (!isset($_SESSION['role'])) {
        } else {
        ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?= $current_page == 'dashboard.php' ? 'active' : NULL ?>">
                        <a class="nav-link <?= $current_page == 'dashboard.php' ? 'text-light font-weight-bold' : NULL ?>" href="/inventory/admin/dashboard">
                            Dashboard <?= $current_page == 'dashboard.php' ? '<span class="sr-only">(current)</span>' : NULL ?>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page == 'supplier.php' ? 'active' : NULL ?>">
                        <a class="nav-link <?= $current_page == 'supplier.php' ? 'text-light font-weight-bold' : NULL ?>" href="/inventory/admin/supplier">
                            Supplier <?= $current_page == 'supplier.php' ? '<span class="sr-only">(current)</span>' : NULL ?>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page == 'barang.php' ? 'active' : NULL ?>">
                        <a class="nav-link <?= $current_page == 'barang.php' ? 'text-light font-weight-bold' : NULL ?>" href="/inventory/admin/barang">
                            Barang <?= $current_page == 'barang.php' ? '<span class="sr-only">(current)</span>' : NULL ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown <?= $link == '/inventory/admin/transaksi/penjualan' || $link == '/inventory/admin/transaksi/pembelian' || $link == '/inventory/admin/transaksi/add/penjualan' || $link == '/inventory/admin/transaksi/add/pembelian' || strpos($link, '/inventory/admin/transaksi/view') !== FALSE ? 'active' : NULL ?>">
                        <a class="nav-link dropdown-toggle <?= $link == '/inventory/admin/transaksi/penjualan' || $link == '/inventory/admin/transaksi/pembelian' || $link == '/inventory/admin/transaksi/add/penjualan' || strpos($link, '/inventory/admin/transaksi/view') !== FALSE ? 'text-light font-weight-bold' : NULL ?>" id="navbartransaksi" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Transaksi <?= $link == '/inventory/admin/transaksi/penjualan' || $link == '/inventory/admin/transaksi/pembelian' || $link == '/inventory/admin/transaksi/add/penjualan' || strpos($link, '/inventory/admin/transaksi/view') !== FALSE ? '<span class="sr-only">(current)</span>' : NULL ?>
                        </a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbartransaksi">
                            <a class="dropdown-item <?= $link == '/inventory/admin/transaksi/penjualan' || $link == '/inventory/admin/transaksi/add/penjualan' ? 'active' : NULL ?>" href="/inventory/admin/transaksi/penjualan">Pengeluaran</a>
                            <a class="dropdown-item <?= $link == '/inventory/admin/transaksi/pembelian' || $link == '/inventory/admin/transaksi/add/pembelian' ? 'active' : NULL ?>" href="/inventory/admin/transaksi/pembelian">Pemasukan</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto nav-flex-icons">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                            <a class="dropdown-item" href="http://localhost/inventory/controller/logout">Log Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        <?php
        }
        ?>

    </div>
</nav>