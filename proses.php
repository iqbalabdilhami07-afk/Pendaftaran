<?php
ob_start();
include 'koneksi.php';
include 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $koneksi = koneksi_db();

    // Sanitasi semua input menggunakan function
    $data = [
        'nama_lengkap'  => bersihkan_input($koneksi, $_POST['nama_lengkap']),
        'tempat_lahir'  => bersihkan_input($koneksi, $_POST['tempat_lahir']),
        'tanggal_lahir' => bersihkan_input($koneksi, $_POST['tanggal_lahir']),
        'jenis_kelamin' => bersihkan_input($koneksi, $_POST['jenis_kelamin']),
        'alamat'        => bersihkan_input($koneksi, $_POST['alamat']),
        'asal_sekolah'  => bersihkan_input($koneksi, $_POST['asal_sekolah']),
        'nama_wali'     => bersihkan_input($koneksi, $_POST['nama_wali']),
        'no_telp_wali'  => bersihkan_input($koneksi, $_POST['no_telp_wali']),
        'program'       => bersihkan_input($koneksi, $_POST['program']),
    ];

    // Cek duplikat menggunakan function
    if (cek_duplikat($koneksi, $data['nama_lengkap'], $data['tanggal_lahir'])) {
        header("Location: index.php?status=duplikat");
        exit;
    }

    // Simpan data menggunakan function
    if (simpan_santri($koneksi, $data)) {
        mysqli_close($koneksi);
        header("Location: index.php?status=berhasil");
        exit;
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: index.php");
    exit;
}
?>