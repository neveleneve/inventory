<?php
require($_SERVER['DOCUMENT_ROOT'] . '/inventory/controller/koneksi.php');

if (isset($_POST['tambahsupplier'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $admin = new admin();
    $admin->addsupplier($nama, $alamat);
}

if (isset($_POST['ubahdatasupplier'])) {
    $idsupplier = $_POST['idsupplier'];
    $nama = $_POST['namasupplier'];
    $alamat = $_POST['alamatsupplier'];
    $admin = new admin();
    $admin->ubahdatasupplier($idsupplier, $nama, $alamat);
}

if (isset($_POST['tambahbarang'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $admin = new admin();
    $admin->addbarang($nama, $harga);
}

if (isset($_POST['ubahdatabarang'])) {
    $idbarang = $_POST['idbarang'];
    $nama = $_POST['namabarang'];
    $harga = $_POST['hargabarang'];
    $admin = new admin();
    $admin->ubahdatabarang($idbarang, $nama, $harga);
}

if (isset($_POST['tambahtransaksipenjualan'])) {

    if ($_POST['hiddenharga'] == '' || $_POST['harga'] == '') {
        echo "<script LANGUAGE='JavaScript'>
        window.alert('Terdapat data yang kosong. Silahkan ulangi');
        window.location.href='../admin/transaksi/add/penjualan';
        </script>";
    } else {
        $idbelanja = $_POST['id_trx'];
        $idbarang = $_POST['selectbarang'];
        $jumlah = $_POST['jumlah'];
        $jenis = $_POST['jenis'];
        $harga = $_POST['hiddenharga'];
        echo $jumlah;
        $admin = new admin();
        $admin->addtransaksipenjualan($idbelanja, $idbarang, $jumlah, $harga, $jenis);
    }
}

if (isset($_POST['bataltransaksipenjualan'])) {
    $idbelanja = $_POST['id_trx'];
    $jenis = $_POST['jenis'];
    $admin = new admin();
    $jumlahbarang = $admin->counttransaksi($idbelanja);
    if ($jumlahbarang == 0) {
        echo 'barang 0';
    } else {
        if ($jenis == 'B') {
            $dabarang = mysqli_query($koneksi, 'SELECT * FROM transaksi WHERE id_trx = "' . $idbelanja . '"');
            $row = mysqli_fetch_all($dabarang);
            foreach ($row as $key) {
                mysqli_query($koneksi, 'update item set stok = stok - ' . $key[3] . ' where id = "' . $key[2] . '"');
            }
        } elseif ($jenis == 'J') {
            $dabarang = mysqli_query($koneksi, 'SELECT * FROM transaksi WHERE id_trx = "' . $idbelanja . '"');
            $row = mysqli_fetch_all($dabarang);
            foreach ($row as $key) {
                mysqli_query($koneksi, 'update item set stok = stok + ' . $key[3] . ' where id = "' . $key[2] . '"');
            }
        }
    }
    $admin->bataltransaksi($idbelanja, $jenis);
}

if (isset($_POST['selesaitransaksipenjualan'])) {
    $idbelanja = $_POST['id_trx'];
    $idsup = $_POST['idsupplier'];
    $jenis = $_POST['jenis'];
    $admin = new admin();
    if ($jenis == 'B') {
        $admin->selesaitransaksi($idbelanja, $jenis, $idsup);
    } elseif ($jenis == 'J') {
        $admin->selesaitransaksi($idbelanja, $jenis, null);
    }
}

class admin
{
    public function getnewidtrx()
    {
        global $koneksi;
        $data = null;
        $query = mysqli_query($koneksi, "SELECT max(right(id_trx, 4)) as idtrx FROM master_transaksi");
        $row = mysqli_fetch_array($query);
        $tanggal = date('dmY');

        if ($row['idtrx'] == '') {
            $data = 'T' . $tanggal . '-0001';
        } else {
            $dataterakhir = $row;
            $datax = $dataterakhir[0];
            $panjangkodelama = strlen($datax);
            $kodebaru = $datax + 1;
            $panjangkodebaru = strlen($kodebaru);
            for ($i = 0; $i < $panjangkodelama - $panjangkodebaru; $i++) {
                $kodebaru = '0' . $kodebaru;
            }
            $data = 'T' . $tanggal . '-' . $kodebaru;
        }
        return $data;
    }
    // ================================================= Dashboard ================================================================= //
    public function dashboard()
    {
        global $koneksi;
        $data = null;
        $query1 = mysqli_query($koneksi, "SELECT count(*) as totalstok FROM item WHERE stok <> 0");
        $query2 = mysqli_query($koneksi, "SELECT count(*) as totalbeli FROM master_transaksi WHERE jenis = 'B'");
        $query3 = mysqli_query($koneksi, "SELECT count(*) as totaljual FROM master_transaksi WHERE jenis = 'J'");
        while ($row1 = mysqli_fetch_array($query1)) {
            $data[] = $row1;
        }
        while ($row2 = mysqli_fetch_array($query2)) {
            $data[] = $row2;
        }
        while ($row3 = mysqli_fetch_array($query3)) {
            $data[] = $row3;
        }
        return $data;
    }
    // ================================================= Supplier ================================================================= //
    public function datasupplier($id)
    {
        global $koneksi;
        $data = null;
        $query = null;
        if ($id == !null) {
            $query = mysqli_query($koneksi, "SELECT * FROM supplier where nama like '%$id%' or alamat like '%$id%'");
        } else {
            $query = mysqli_query($koneksi, "SELECT * FROM supplier order by nama asc");
        }
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function addsupplier($name, $address)
    {
        global $koneksi;
        $tanggal = date('Y-m-d H:i:s');
        mysqli_query($koneksi, "ALTER TABLE supplier auto_increment = 1");
        mysqli_query($koneksi, "INSERT INTO supplier (nama, alamat, tanggal) values('$name', '$address', '$tanggal')");
        header('location: ../admin/supplier');
    }
    public function datapersonalsupplier($id)
    {
        global $koneksi;
        $data = null;
        $query = mysqli_query($koneksi, "SELECT * FROM supplier where id = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function ubahdatasupplier($id, $name, $address)
    {
        global $koneksi;
        mysqli_query($koneksi, "UPDATE supplier SET nama = '$name', alamat  = '$address' WHERE id = '$id'");
        header('location: ../admin/supplier');
    }
    // ================================================= Barang ================================================================= //
    public function databarang($id)
    {
        global $koneksi;
        $data = null;
        $query = null;
        if ($id == !null) {
            $query = mysqli_query($koneksi, "SELECT * FROM item where nama like '%$id%'");
        } else {
            $query = mysqli_query($koneksi, "SELECT * FROM item order by nama asc");
        }
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }

    public function databaranglist($tipe)
    {
        global $koneksi;
        $data = null;
        $query = null;
        if ($tipe == 'J') {
            $query = mysqli_query($koneksi, "SELECT * FROM item where stok > 0 order by nama asc");
        } elseif ($tipe == 'B') {
            $query = mysqli_query($koneksi, "SELECT * FROM item order by nama asc");
        }

        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function dataperbarang($id)
    {
        global $koneksi;
        $data = null;
        $query = mysqli_query($koneksi, "SELECT * FROM item where id = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function ubahdatabarang($id, $name, $price)
    {
        global $koneksi;
        mysqli_query($koneksi, "UPDATE item SET nama = '$name', harga = '$price' WHERE id = '$id'");
        header('location: ../admin/barang');
    }
    public function stokbarang($id, $stock, $operator)
    {
        global $koneksi;
        mysqli_query($koneksi, "UPDATE item SET stok  = stok $operator '$stock' WHERE id = '$id'");
    }
    public function addbarang($name, $price)
    {
        global $koneksi;
        mysqli_query($koneksi, "ALTER TABLE item auto_increment = 1");
        mysqli_query($koneksi, "INSERT INTO item (nama, stok, harga) values('$name', 0, '$price')");
        header('location: ../admin/barang');
    }
    // ================================================= Transaksi ================================================================= //
    public function counttransaksi($id)
    {
        global $koneksi;
        $query = mysqli_query($koneksi, "SELECT COUNT(id_trx) as jumlah FROM transaksi WHERE id_trx = '$id'");
        $row = mysqli_fetch_assoc($query);
        return $row['jumlah'];
    }
    public function gettrx($id, $index)
    {
        # code...
    }
    public function transaksi($id, $jenis)
    {
        global $koneksi;
        $data = null;
        $query = null;
        if ($id != null) {
            if ($jenis == 'B') {
                $query = mysqli_query($koneksi, "SELECT m.id_trx as 'id_trx', s.nama as 'nama', m.total as 'total', m.tanggal as 'tanggal' 
                FROM master_transaksi as m
                join supplier as s on m.id_supplier = s.id
                where m.jenis = '$jenis' and m.id_trx like '%$id%'");
            } elseif ($jenis == 'J') {
                $query = mysqli_query($koneksi, "SELECT * FROM master_transaksi where jenis = '$jenis' and id_trx like '%$id%'");
            }
        } else {
            if ($jenis == 'B') {
                $query = mysqli_query($koneksi, "SELECT m.id_trx as 'id_trx', s.nama as 'nama', m.total as 'total', m.tanggal as 'tanggal' 
                    FROM master_transaksi as m
                    join supplier as s on m.id_supplier = s.id
                    where m.jenis = '$jenis' order by id_trx desc");
            } elseif ($jenis == 'J') {
                $query = mysqli_query($koneksi, "SELECT * FROM master_transaksi where jenis = '$jenis' order by id_trx desc");
            }
        }
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function addtransaksipenjualan($idtrx, $idbrg, $qty, $harga, $jns)
    {
        global $koneksi;
        $tanggal = date('Y-m-d');
        $stokbarang = mysqli_query($koneksi, 'SELECT stok from item where id = "' . $idbrg . '"');
        $data = mysqli_fetch_array($stokbarang);
        if ($qty > $data['stok'] && $jns == 'J') {
            echo "<script LANGUAGE='JavaScript'>
                        window.alert('Stok barang kurang!');
                        window.location.href='../admin/transaksi/add/penjualan';
                        </script>";
        } else {
            // mysqli_query($koneksi, "ALTER TABLE transaksi auto_increment = 1");
            mysqli_query($koneksi, "INSERT INTO transaksi (id_trx, id_barang, jumlah, harga, tanggal, status) values('$idtrx', '$idbrg', '$qty', '$harga', '$tanggal', '$jns')");
            if ($jns == 'J') {
                mysqli_query($koneksi, "UPDATE item SET stok = stok - $qty WHERE id = $idbrg");
                header('location: ../admin/transaksi/add/penjualan');
            } elseif ($jns == 'B') {
                mysqli_query($koneksi, "UPDATE item SET stok = stok + $qty WHERE id = $idbrg");
                header('location: ../admin/transaksi/add/pembelian');
            }
        }
    }
    public function showtrxinadding($id)
    {
        global $koneksi;
        $data = null;
        $query = mysqli_query($koneksi, "SELECT t.id as 'id', t.id_trx as 'id_trx', i.nama as 'namabarang', 
            t.jumlah as 'jumlah', t.harga as 'harga' FROM transaksi as t
            join item as i on t.id_barang = i.id
            where t.id_trx = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function bataltransaksi($id, $jns)
    {
        global $koneksi;
        mysqli_query($koneksi, "DELETE FROM transaksi where id_trx = '$id'");
        if ($jns == 'B') {
            header('location: ../admin/transaksi/pembelian');
        } elseif ($jns == 'J') {
            header('location: ../admin/transaksi/penjualan');
        }
    }
    public function refreshcancel($id, $jns)
    {
        global $koneksi;
        $data = mysqli_query($koneksi, "SELECT * FROM transaksi where id_trx = '$id'");
        $row = mysqli_fetch_all($data);
        if (count($row) != 0) {
            $status = $row[0][6];
            if ($status != $jns) {
                if ($status == 'J') {
                    foreach ($row as $key) {
                        mysqli_query($koneksi, 'UPDATE item set stok = stok + ' . $key[3] . ' where id = "' . $key[2] . '"');
                    }
                } elseif ($status == 'B') {
                    foreach ($row as $key) {
                        mysqli_query($koneksi, 'UPDATE item set stok = stok - ' . $key[3] . ' where id = "' . $key[2] . '"');
                    }
                }
                mysqli_query($koneksi, 'DELETE FROM transaksi where id_trx = "' . $id . '"');
                mysqli_query($koneksi, 'ALTER TABLE transaksi AUTO_INCREMENT = 1');
            }
        }
    }
    public function selesaitransaksi($id, $jns, $idsupplier)
    {
        global $koneksi;
        $totalbelanja = 0;
        $subtotal = 0;
        $tanggal = date('Y-m-d');
        $q = mysqli_query($koneksi, "SELECT * FROM transaksi where id_trx = '$id'");
        $fetching = mysqli_fetch_all($q);
        $jumlahbarang = count($fetching);
        for ($i = 0; $i < $jumlahbarang; $i++) {
            $subtotal = $fetching[$i][3] * $fetching[$i][4];
            $totalbelanja += $subtotal;
        }
        $row = mysqli_fetch_assoc($q);
        if ($totalbelanja == 0) {
            if ($jns == 'B') {
                echo "<script LANGUAGE='JavaScript'>
                        window.alert('Barang belanja tidak ada!');
                        window.location.href='../admin/transaksi/pembelian';
                        </script>";
            } elseif ($jns == 'J') {
                echo "<script LANGUAGE='JavaScript'>
                window.alert('Barang belanja tidak ada!');
                window.location.href='../admin/transaksi/penjualan';
                </script>";
            }
        } else {
            if ($jns == 'B') {
                mysqli_query($koneksi, "ALTER TABLE master_transaksi auto_increment = 1");
                mysqli_query($koneksi, "INSERT INTO master_transaksi (id_trx, total, jenis, id_supplier, tanggal) values('$id', '$totalbelanja', '$jns', $idsupplier, '$tanggal')");
                header('location: ../admin/transaksi/pembelian');
            } elseif ($jns == 'J') {
                mysqli_query($koneksi, "ALTER TABLE master_transaksi auto_increment = 1");
                mysqli_query($koneksi, "INSERT INTO master_transaksi (id_trx, total, jenis, tanggal) values('$id', '$totalbelanja', '$jns', '$tanggal')");
                header('location: ../admin/transaksi/penjualan');
            }
        }
    }
    public function showtrx($id)
    {
        global $koneksi;
        $data = null;
        $query = null;
        $query = mysqli_query($koneksi, "SELECT 
        m.id_trx as 'id_trx', 
        m.jenis as 'jenis', 
        i.nama as 'namabarang', 
        t.harga as 'harga' ,
        t.jumlah as 'jumlah', 
        m.tanggal as 'tanggal' 
        FROM transaksi as t
        join item as i on t.id_barang=i.id
        join master_transaksi as m on t.id_trx=m.id_trx
        where t.id_trx = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function getsupname($id)
    {
        global $koneksi;
        $data = null;
        $query = null;
        $query = mysqli_query($koneksi, "SELECT
        s.nama as 'nama'
        FROM
        master_transaksi AS m
        JOIN supplier AS s ON s.id = m.id_supplier
        WHERE
        m.id_trx = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function transaksisupplier($id)
    {
        global $koneksi;
        $data = null;
        $query = null;
        $query = mysqli_query($koneksi, "SELECT
        s.nama as 'nama',
        m.total as 'total',
        m.id_trx as 'id',
        m.tanggal as 'tanggal'
        FROM
        master_transaksi AS m
        JOIN supplier AS s ON s.id = m.id_supplier
        WHERE
        m.id_supplier = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    // ================================================= Laporan ================================================================= //
    public function laporanpembelian($bulan, $tahun)
    {
        global $koneksi;
        $data = null;
        if ($bulan == null) {
            $query = mysqli_query($koneksi, "SELECT m.id_trx as id_trx, s.nama as nama, m.tanggal as tanggal, m.total as total FROM master_transaksi as m join supplier as s on m.id_supplier = s.id where m.jenis = 'B' and year(m.tanggal) = $tahun");
        } else {
            $query = mysqli_query($koneksi, "SELECT m.id_trx as id_trx, s.nama as nama, m.tanggal as tanggal, m.total as total FROM master_transaksi as m join supplier as s on m.id_supplier = s.id where m.jenis = 'B' and month(m.tanggal) = $bulan  and year(m.tanggal) = $tahun");
        }
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function laporanpenjualan($bulan, $tahun)
    {
        global $koneksi;
        $data = null;
        if ($bulan == null) {
            $query = mysqli_query($koneksi, "SELECT * FROM master_transaksi where jenis = 'J' and year(tanggal) = $tahun");
        } else {
            $query = mysqli_query($koneksi, "SELECT * FROM master_transaksi where jenis = 'J' and month(tanggal) = $bulan  and year(tanggal) = $tahun");
        }
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
    public function databaranglaporan($id)
    {
        global $koneksi;
        $data = null;
        $query = mysqli_query($koneksi, "SELECT 
        i.nama as 'namabarang', 
        t.harga as 'harga' ,
        t.jumlah as 'jumlah' 
        FROM transaksi as t
        join item as i on t.id_barang=i.id
        where t.id_trx = '$id'");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }
}
