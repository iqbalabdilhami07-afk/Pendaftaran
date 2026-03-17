<?php

// ==============================
// FUNCTION KONEKSI DATABASE
// ==============================
function koneksi_db() {
    $koneksi = mysqli_connect("localhost", "root", "", "db_pesantren");
    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    return $koneksi;
}

// ==============================
// FUNCTION SANITASI INPUT
// ==============================
function bersihkan_input($koneksi, $data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($koneksi, $data);
    return $data;
}

// ==============================
// FUNCTION SIMPAN SANTRI
// ==============================
function simpan_santri($koneksi, $data) {
    $query = "INSERT INTO santri 
            (nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, 
            alamat, asal_sekolah, nama_wali, no_telp_wali, program)
            VALUES 
            ('{$data['nama_lengkap']}', '{$data['tempat_lahir']}', 
            '{$data['tanggal_lahir']}', '{$data['jenis_kelamin']}',
            '{$data['alamat']}', '{$data['asal_sekolah']}', 
            '{$data['nama_wali']}', '{$data['no_telp_wali']}', 
            '{$data['program']}')";
    return mysqli_query($koneksi, $query);
}

// ==============================
// FUNCTION AMBIL SEMUA SANTRI
// ==============================
function get_semua_santri($koneksi) {
    $query  = "SELECT * FROM santri ORDER BY id DESC";
    $result = mysqli_query($koneksi, $query);
    $data   = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// ==============================
// FUNCTION HITUNG TOTAL SANTRI
// ==============================
function hitung_santri($koneksi) {
    $result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM santri");
    $row    = mysqli_fetch_assoc($result);
    return $row['total'];
}

// ==============================
// FUNCTION HITUNG PER PROGRAM
// ==============================
function hitung_per_program($koneksi, $program) {
    $program = mysqli_real_escape_string($koneksi, $program);
    $result  = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM santri WHERE program='$program'");
    $row     = mysqli_fetch_assoc($result);
    return $row['total'];
}

// ==============================
// FUNCTION FORMAT TANGGAL
// ==============================
function format_tanggal($tanggal) {
    $bulan = [
        '01' => 'Januari',  '02' => 'Februari', '03' => 'Maret',
        '04' => 'April',    '05' => 'Mei',       '06' => 'Juni',
        '07' => 'Juli',     '08' => 'Agustus',   '09' => 'September',
        '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember'
    ];
    $arr = explode('-', $tanggal);
    return $arr[2] . ' ' . $bulan[$arr[1]] . ' ' . $arr[0];
}

// ==============================
// FUNCTION HITUNG UMUR
// ==============================
function hitung_umur($tanggal_lahir) {
    $lahir = new DateTime($tanggal_lahir);
    $skrg  = new DateTime();
    $umur  = $lahir->diff($skrg);
    return $umur->y . ' tahun';
}

// ==============================
// FUNCTION CEK EMAIL DUPLIKAT
// ==============================
function cek_duplikat($koneksi, $nama, $tgl_lahir) {
    $nama    = mysqli_real_escape_string($koneksi, $nama);
    $tgl     = mysqli_real_escape_string($koneksi, $tgl_lahir);
    $result  = mysqli_query($koneksi, 
        "SELECT id FROM santri WHERE nama_lengkap='$nama' AND tanggal_lahir='$tgl'");
    return mysqli_num_rows($result) > 0;
}

// ==============================
// FUNCTION HAPUS SANTRI
// ==============================
function hapus_santri($koneksi, $id) {
    $id    = (int)$id;
    $query = "DELETE FROM santri WHERE id=$id";
    return mysqli_query($koneksi, $query);
}

// ==============================
// FUNCTION AMBIL DATA BY ID
// ==============================
function get_santri_by_id($koneksi, $id) {
    $id     = (int)$id;
    $result = mysqli_query($koneksi, "SELECT * FROM santri WHERE id=$id");
    return mysqli_fetch_assoc($result);
}

// ==============================
// FUNCTION UPDATE SANTRI
// ==============================
function update_santri($koneksi, $id, $data) {
    $id    = (int)$id;
    $query = "UPDATE santri SET
            nama_lengkap='{$data['nama_lengkap']}',
            tempat_lahir='{$data['tempat_lahir']}',
            tanggal_lahir='{$data['tanggal_lahir']}',
            jenis_kelamin='{$data['jenis_kelamin']}',
            alamat='{$data['alamat']}',
            asal_sekolah='{$data['asal_sekolah']}',
            nama_wali='{$data['nama_wali']}',
            no_telp_wali='{$data['no_telp_wali']}',
            program='{$data['program']}'
            WHERE id=$id";
    return mysqli_query($koneksi, $query);
}
?>