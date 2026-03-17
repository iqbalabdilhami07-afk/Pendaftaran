<?php
include 'koneksi.php';
include 'function.php';

$koneksi     = koneksi_db();
$list_santri = get_semua_santri($koneksi);
$total       = hitung_santri($koneksi);

// Hitung per program menggunakan function
$jml_tahfidz = hitung_per_program($koneksi, "Tahfidz Al-Qur'an");
$jml_fiqih   = hitung_per_program($koneksi, "Takhassus Fiqih");
$jml_arab    = hitung_per_program($koneksi, "Bahasa Arab");
$jml_reguler = hitung_per_program($koneksi, "Reguler");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Santri</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f0;
            padding: 30px 20px;
        }
        h2 { color: #1b5e20; text-align: center; margin-bottom: 20px; font-size: 22px; }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .topbar a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        /* KARTU STATISTIK */
        .stats-grid {
            display: flex;
            gap: 12px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }
        .stat-card {
            flex: 1;
            min-width: 120px;
            background: white;
            border-radius: 10px;
            padding: 14px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-top: 4px solid #2e7d32;
        }
        .stat-card .angka {
            font-size: 26px;
            font-weight: bold;
            color: #2e7d32;
        }
        .stat-card .label {
            font-size: 11px;
            color: #777;
            margin-top: 4px;
        }
        /* TABEL */
        .table-wrap {
            overflow-x: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.09);
        }
        table { width: 100%; border-collapse: collapse; min-width: 750px; }
        th {
            background: #2e7d32;
            color: white;
            padding: 12px 14px;
            text-align: left;
            font-size: 13px;
        }
        td {
            padding: 10px 14px;
            font-size: 13px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }
        tr:hover td { background: #f1f8e9; }
        .badge {
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
        }
        .laki     { background: #e3f2fd; color: #1565c0; }
        .perempuan{ background: #fce4ec; color: #c62828; }
        .prog     { background: #e8f5e9; color: #1b5e20; }
        .btn-hapus {
            background: #e53935;
            color: white;
            border: none;
            padding: 5px 11px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-hapus:hover { background: #b71c1c; }
        .btn-edit {
            background: #f57c00;
            color: white;
            border: none;
            padding: 5px 11px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
        }
        .btn-edit:hover { background: #e65100; }
        .kosong { text-align: center; color: #aaa; padding: 30px; }
        .pesan-hapus {
            background: #ffebee;
            color: #b71c1c;
            border: 1px solid #ef9a9a;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>🕌 Data Santri Terdaftar</h2>

    <div class="topbar">
        <a href="index.php">← Kembali ke Form Pendaftaran</a>
        <span style="font-size:13px;color:#666">Total: <strong><?= $total ?> santri</strong></span>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'hapus'): ?>
        <div class="pesan-hapus">🗑️ Data santri berhasil dihapus.</div>
    <?php endif; ?>

    <!-- STATISTIK -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="angka"><?= $total ?></div>
            <div class="label">Total Santri</div>
        </div>
        <div class="stat-card">
            <div class="angka"><?= $jml_tahfidz ?></div>
            <div class="label">Tahfidz Al-Qur'an</div>
        </div>
        <div class="stat-card">
            <div class="angka"><?= $jml_fiqih ?></div>
            <div class="label">Takhassus Fiqih</div>
        </div>
        <div class="stat-card">
            <div class="angka"><?= $jml_arab ?></div>
            <div class="label">Bahasa Arab</div>
        </div>
        <div class="stat-card">
            <div class="angka"><?= $jml_reguler ?></div>
            <div class="label">Reguler</div>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="table-wrap">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Umur</th>
                <th>JK</th>
                <th>Asal Sekolah</th>
                <th>Nama Wali</th>
                <th>No. Telp</th>
                <th>Program</th>
                <th>Tgl Daftar</th>
                <th>Aksi</th>
            </tr>

            <?php if (count($list_santri) > 0): ?>
                <?php $no = 1; foreach ($list_santri as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= $row['nama_lengkap'] ?></strong></td>
                    <td><?= $row['tempat_lahir'] ?>, <?= format_tanggal($row['tanggal_lahir']) ?></td>
                    <td><?= hitung_umur($row['tanggal_lahir']) ?></td>
                    <td>
                        <span class="badge <?= $row['jenis_kelamin'] == 'Laki-laki' ? 'laki' : 'perempuan' ?>">
                            <?= $row['jenis_kelamin'] ?>
                        </span>
                    </td>
                    <td><?= $row['asal_sekolah'] ?></td>
                    <td><?= $row['nama_wali'] ?></td>
                    <td><?= $row['no_telp_wali'] ?></td>
                    <td><span class="badge prog"><?= $row['program'] ?></span></td>
                    <td><?= format_tanggal(date('Y-m-d', strtotime($row['tanggal_daftar']))) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏️ Edit</a>
                        &nbsp;
                        <button class="btn-hapus"
                            onclick="if(confirm('Yakin hapus data <?= $row['nama_lengkap'] ?>?')) 
                                    window.location='hapus.php?id=<?= $row['id'] ?>'">
                            🗑️ Hapus
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="11" class="kosong">Belum ada data santri yang terdaftar.</td></tr>
            <?php endif; ?>
        </table>
    </div>

</body>
</html>