<?php
include 'koneksi.php';
include 'function.php';
$koneksi = koneksi_db();
$total   = hitung_santri($koneksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Santri Baru</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f0;
            padding: 30px 20px;
        }
        .container {
            max-width: 620px;
            margin: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
            color: white;
            text-align: center;
            padding: 30px 25px;
        }
        .header .icon { font-size: 44px; }
        .header h1 { font-size: 22px; margin: 8px 0 4px; }
        .header p  { font-size: 13px; opacity: 0.85; }
        .stats {
            background: #e8f5e9;
            text-align: center;
            padding: 10px;
            font-size: 13px;
            color: #2e7d32;
            border-bottom: 1px solid #c8e6c9;
        }
        .form-body { padding: 28px; }
        .section-title {
            font-weight: bold;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
            padding-left: 10px;
            margin: 22px 0 14px;
            font-size: 14px;
        }
        label {
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
            color: #555;
            font-weight: 600;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #ccc;
            border-radius: 7px;
            font-size: 14px;
            margin-bottom: 14px;
            transition: border-color 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #2e7d32;
            outline: none;
        }
        textarea { resize: vertical; height: 75px; }
        .row { display: flex; gap: 14px; }
        .row > div { flex: 1; }
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 6px;
            letter-spacing: 0.5px;
        }
        .btn-submit:hover { background: linear-gradient(135deg, #145214, #1b5e20); }
        .pesan-sukses {
            background: #e8f5e9;
            color: #1b5e20;
            border: 1px solid #a5d6a7;
            padding: 12px 16px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .pesan-error {
            background: #ffebee;
            color: #b71c1c;
            border: 1px solid #ef9a9a;
            padding: 12px 16px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .footer-link {
            text-align: center;
            padding: 16px;
            background: #f9fbe7;
            border-top: 1px solid #e0e0e0;
        }
        .footer-link a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="icon">🕌</div>
        <h1>Pendaftaran Santri Baru</h1>
        <p>Isi formulir di bawah ini dengan lengkap dan benar</p>
    </div>

    <div class="stats">
        📊 Total santri terdaftar: <strong><?= $total ?> orang</strong>
    </div>

    <div class="form-body">

        <?php if (isset($_GET['status']) && $_GET['status'] == 'berhasil'): ?>
            <div class="pesan-sukses">✅ Pendaftaran berhasil! Data santri telah tersimpan.</div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'duplikat'): ?>
            <div class="pesan-error">⚠️ Santri dengan nama dan tanggal lahir yang sama sudah terdaftar!</div>
        <?php endif; ?>

        <form action="proses.php" method="POST">

            <div class="section-title">📋 Data Diri Santri</div>

            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>

            <div class="row">
                <div>
                    <label>Tempat Lahir:</label>
                    <input type="text" name="tempat_lahir" placeholder="Kota kelahiran" required>
                </div>
                <div>
                    <label>Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" required>
                </div>
            </div>

            <label>Jenis Kelamin:</label>
            <select name="jenis_kelamin" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <label>Alamat Lengkap:</label>
            <textarea name="alamat" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota" required></textarea>

            <label>Asal Sekolah:</label>
            <input type="text" name="asal_sekolah" placeholder="Contoh: SDN 01 Yogyakarta" required>

            <div class="section-title">👨‍👩‍👦 Data Orang Tua / Wali</div>

            <label>Nama Orang Tua / Wali:</label>
            <input type="text" name="nama_wali" placeholder="Nama lengkap orang tua/wali" required>

            <label>No. Telepon Wali:</label>
            <input type="text" name="no_telp_wali" placeholder="08xxxxxxxxxx" required>

            <div class="section-title">📚 Pilihan Program</div>

            <label>Program yang Dipilih:</label>
            <select name="program" required>
                <option value="">-- Pilih Program --</option>
                <option value="Tahfidz Al-Qur'an">Tahfidz Al-Qur'an</option>
                <option value="Takhassus Fiqih">Takhassus Fiqih</option>
                <option value="Bahasa Arab">Bahasa Arab</option>
                <option value="Reguler">Reguler</option>
            </select>

            <button type="submit" class="btn-submit">📨 Kirim Pendaftaran</button>

        </form>
    </div>

    <div class="footer-link">
        <a href="data.php">📋 Lihat Daftar Santri →</a>
    </div>

</div>
</body>
</html>