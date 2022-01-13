<?php
session_start();
if (!isset($_SESSION['role'])) {
    header('location: ../../');
    return false;
} else {
    $namaadmin = $_SESSION['adminname'];
    $admin = $_SESSION['admin'];
    $role = $_SESSION['role'];
}
$_SESSION['idsupplier'] = $_GET['id'];
header('location: supplier');