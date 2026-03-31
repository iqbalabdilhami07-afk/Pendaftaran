<?php
ob_start();
include 'function.php';

$koneksi = koneksi_db();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    if (hapus_santri($koneksi, $id)) {
        mysqli_close($koneksi);
        header("Location: data.php?status=hapus");
        exit;
    } else {
        echo "Gagal menghapus data!";
    }
} else {
    header("Location: data.php");
    exit;
}
?>