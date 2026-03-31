<?php
include 'function.php';

$koneksi = koneksi_db();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: data.php");
    exit;
}

$id   = $_GET['id'];
$data = get_santri_by_id($koneksi, $id);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Proses UPDATE jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update = [
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

    if (update_santri($koneksi, $id, $update)) {
        mysqli_close($koneksi);
        header("Location: data.php?status=update");
        exit;
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Santri</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial; background: #f0f4f0; padding: 30px 20px; }
        .container {
            max-width: 1000px; margin: auto; background: white;
            border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.12); overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #e65100, #f57c00);
            color: white; text-align: center; padding: 25px;
        }
        .header h2 { font-size: 20px; margin-top: 6px; }
        .form-body { padding: 28px; }
        .section-title {
            font-weight: bold; color: #e65100;
            border-left: 4px solid #e65100;
            padding-left: 10px; margin: 20px 0 12px; font-size: 14px;
        }
        label { display: block; font-size: 13px; margin-bottom: 4px; color: #555; font-weight: 600; }
        input, select, textarea {
            width: 100%; padding: 10px 13px;
            border: 1.5px solid #ccc; border-radius: 7px;
            font-size: 14px; margin-bottom: 14px;
        }
        input:focus, select:focus { border-color: #f57c00; outline: none; }
        textarea { resize: vertical; height: 75px; }
        .row { display: flex; gap: 14px; }
        .row > div { flex: 1; }
        .btn-update {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #e65100, #f57c00);
            color: white; border: none; border-radius: 8px;
            font-size: 15px; font-weight: bold; cursor: pointer;
        }
        .btn-update:hover { background: linear-gradient(135deg, #bf360c, #e65100); }
        .footer-link { text-align: center; padding: 15px; }
        .footer-link a { color: #e65100; text-decoration: none; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div style="font-size:36px">✏️</div>
        <h2>Edit Data Santri</h2>
    </div>
    <div class="form-body">
        <form action="edit.php?id=<?= $id ?>" method="POST">

            <div class="section-title">📋 Data Diri Santri</div>

            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>" required>

            <div class="row">
                <div>
                    <label>Tempat Lahir:</label>
                    <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" required>
                </div>
                <div>
                    <label>Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required>
                </div>
            </div>

            <label>Jenis Kelamin:</label>
            <select name="jenis_kelamin" required>
                <option value="Laki-laki"  <?= $data['jenis_kelamin']=='Laki-laki'  ? 'selected':'' ?>>Laki-laki</option>
                <option value="Perempuan"  <?= $data['jenis_kelamin']=='Perempuan'  ? 'selected':'' ?>>Perempuan</option>
            </select>

            <label>Alamat Lengkap:</label>
            <textarea name="alamat" required><?= $data['alamat'] ?></textarea>

            <label>Asal Sekolah:</label>
            <input type="text" name="asal_sekolah" value="<?= $data['asal_sekolah'] ?>" required>

            <div class="section-title">👨‍👩‍👦 Data Orang Tua / Wali</div>

            <label>Nama Wali:</label>
            <input type="text" name="nama_wali" value="<?= $data['nama_wali'] ?>" required>

            <label>No. Telepon Wali:</label>
            <input type="text" name="no_telp_wali" value="<?= $data['no_telp_wali'] ?>" required>

            <div class="section-title">📚 Pilihan Program</div>

            <label>Program:</label>
            <select name="program" required>
                <option value="Tahfidz Al-Qur'an"  <?= $data['program']=="Tahfidz Al-Qur'an"  ? 'selected':'' ?>>Tahfidz Al-Qur'an</option>
                <option value="Takhassus Fiqih"     <?= $data['program']=="Takhassus Fiqih"     ? 'selected':'' ?>>Takhassus Fiqih</option>
                <option value="Bahasa Arab"          <?= $data['program']=="Bahasa Arab"          ? 'selected':'' ?>>Bahasa Arab</option>
                <option value="Reguler"              <?= $data['program']=="Reguler"              ? 'selected':'' ?>>Reguler</option>
            </select>

            <button type="submit" class="btn-update">💾 Simpan Perubahan</button>
        </form>
    </div>
    <div class="footer-link">
        <a href="data.php">← Kembali ke Daftar Santri</a>
    </div>
</div>
</body>
</html>