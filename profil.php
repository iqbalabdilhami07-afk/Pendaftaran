<?php
include 'function.php';
$koneksi = koneksi_db();
$total   = hitung_santri($koneksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pesantren</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f0;
            color: #333;
        }

        /* ===== HERO ===== */
        .hero {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #388e3c 100%);
            color: white;
            text-align: center;
            padding: 60px 20px 80px;
            position: relative;
        }
        .hero .icon { font-size: 60px; margin-bottom: 16px; }
        .hero h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
        .hero .subtitle { font-size: 15px; opacity: 0.85; margin-bottom: 6px; }
        .hero .tagline {
            font-size: 13px;
            opacity: 0.7;
            font-style: italic;
            margin-bottom: 30px;
        }
        .btn-daftar {
            display: inline-block;
            background: white;
            color: #1b5e20;
            padding: 13px 36px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }
        .btn-daftar:hover { transform: translateY(-2px); }

        /* ===== STATISTIK ===== */
        .stats-section {
            background: white;
            padding: 30px 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        .stats-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            max-width: 700px;
            margin: auto;
        }
        .stat-box {
            text-align: center;
            padding: 16px 24px;
            background: #f1f8e9;
            border-radius: 12px;
            min-width: 130px;
        }
        .stat-box .angka {
            font-size: 30px;
            font-weight: 700;
            color: #1b5e20;
        }
        .stat-box .label {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }

        /* ===== SECTION UMUM ===== */
        .section { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        .section h2 {
            font-size: 20px;
            color: #1b5e20;
            border-left: 5px solid #2e7d32;
            padding-left: 12px;
            margin-bottom: 20px;
        }

        /* ===== TENTANG ===== */
        .about-text {
            font-size: 14px;
            line-height: 1.9;
            color: #555;
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
        }

        /* ===== VISI MISI ===== */
        .vm-grid { display: flex; gap: 16px; flex-wrap: wrap; }
        .vm-card {
            flex: 1;
            min-width: 220px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e0e0e0;
        }
        .vm-card h3 {
            font-size: 15px;
            color: #1b5e20;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .vm-card p, .vm-card li {
            font-size: 13px;
            color: #555;
            line-height: 1.8;
        }
        .vm-card ul { padding-left: 18px; }

        /* ===== PROGRAM ===== */
        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 14px;
        }
        .program-card {
            background: white;
            border-radius: 12px;
            padding: 20px 16px;
            text-align: center;
            border: 1px solid #e0e0e0;
            transition: box-shadow 0.2s;
        }
        .program-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
        .program-card .p-icon { font-size: 32px; margin-bottom: 10px; }
        .program-card h3 { font-size: 14px; color: #1b5e20; font-weight: 600; margin-bottom: 6px; }
        .program-card p { font-size: 12px; color: #777; line-height: 1.6; }

        /* ===== FASILITAS ===== */
        .fasilitas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
        }
        .fasilitas-item {
            background: white;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            border: 1px solid #e0e0e0;
            font-size: 13px;
            color: #444;
        }
        .fasilitas-item .f-icon { font-size: 26px; margin-bottom: 8px; }

        /* ===== KONTAK ===== */
        .kontak-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e0e0e0;
        }
        .kontak-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #444;
        }
        .kontak-row:last-child { border-bottom: none; }
        .kontak-row .k-icon { font-size: 18px; flex-shrink: 0; margin-top: 2px; }

        /* ===== CTA BAWAH ===== */
        .cta-section {
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
            color: white;
            text-align: center;
            padding: 50px 20px;
        }
        .cta-section h2 { font-size: 22px; margin-bottom: 10px; }
        .cta-section p { font-size: 14px; opacity: 0.85; margin-bottom: 24px; }
        .btn-daftar-2 {
            display: inline-block;
            background: white;
            color: #1b5e20;
            padding: 13px 40px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
        }
        .btn-daftar-2:hover { opacity: 0.9; }

        /* ===== FOOTER ===== */
        footer {
            background: #1b5e20;
            color: rgba(255,255,255,0.7);
            text-align: center;
            padding: 16px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <!-- HERO -->
    <div class="hero">
        <div class="icon">🕌</div>
        <h1>Pondok Pesantren Wahid Hasyim</h1>
        <p class="subtitle">Jl. Nologaten No. 01, Yogyakarta</p>
        <p class="tagline">"Membentuk Generasi Berilmu, Berakhlak, dan Beramal"</p>
        <a href="daftar.php" class="btn-daftar">📝 Daftar Sekarang</a>
    </div>

    <!-- STATISTIK -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-box">
                <div class="angka"><?= $total ?>+</div>
                <div class="label">Santri Terdaftar</div>
            </div>
            <div class="stat-box">
                <div class="angka">4</div>
                <div class="label">Program Unggulan</div>
            </div>
            <div class="stat-box">
                <div class="angka">15+</div>
                <div class="label">Ustadz & Pengajar</div>
            </div>
            <div class="stat-box">
                <div class="angka">1995</div>
                <div class="label">Tahun Berdiri</div>
            </div>
        </div>
    </div>

    <!-- TENTANG -->
    <div class="section">
        <h2>🏫 Tentang Pesantren</h2>
        <p class="about-text">
            Pondok Pesantren Wahid Hasyim Yogyakarta, didirikan oleh KH. Abdul Hadi As-Syafi'i pada 11 Maret 1977 di Condongcatur, Sleman,
            merupakan pesantren modern yang memadukan pendidikan agama berbasis Ahlus Sunnah Wal Jama'ah dengan kurikulum nasional, sains, dan tahfidz.
            Pesantren ini fokus pada pengembangan akhlak, penguasaan kitab kuning, bahasa asing, dan kepemimpinan
            untuk mencetak generasi Muslim yang berilmu, berakhlak mulia, dan siap berkontribusi positif bagi umat dan bangsa.
        </p>
    </div>

    <!-- VISI MISI -->
    <div class="section" style="padding-top:0">
        <h2>🌟 Visi & Misi</h2>
        <div class="vm-grid">
            <div class="vm-card">
                <h3>🎯 Visi</h3>
                <p>Menjadi pusat pendidikan Islam terkemuka yang melahirkan generasi Muslim yang berilmu, berakhlak mulia, dan bermanfaat bagi umat dan bangsa.</p>
            </div>
            <div class="vm-card">
                <h3>📌 Misi</h3>
                <ul>
                    <li>Menyelenggarakan pendidikan Islam berkualitas</li>
                    <li>Membentuk karakter santri yang Islami</li>
                    <li>Mengembangkan potensi santri secara holistik</li>
                    <li>Membangun lingkungan pesantren yang kondusif</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- PROGRAM -->
    <div class="section" style="padding-top:0">
        <h2>📚 Program Unggulan</h2>
        <div class="program-grid">
            <div class="program-card">
                <div class="p-icon">📖</div>
                <h3>Tahfidz Al-Qur'an</h3>
                <p>Program menghafal Al-Qur'an 30 juz dengan metode yang teruji dan pembimbing berpengalaman</p>
            </div>
            <div class="program-card">
                <div class="p-icon">⚖️</div>
                <h3>Takhassus Fiqih</h3>
                <p>Pendalaman ilmu fiqih klasik dan kontemporer dari sumber-sumber terpercaya</p>
            </div>
            <div class="program-card">
                <div class="p-icon">🌍</div>
                <h3>Bahasa Arab</h3>
                <p>Penguasaan bahasa Arab aktif dan pasif sebagai kunci memahami khazanah Islam</p>
            </div>
            <div class="program-card">
                <div class="p-icon">🏫</div>
                <h3>Reguler</h3>
                <p>Program terpadu yang mencakup ilmu agama dan umum secara seimbang</p>
            </div>
        </div>
    </div>

    <!-- FASILITAS -->
    <div class="section" style="padding-top:0">
        <h2>🏗️ Fasilitas</h2>
        <div class="fasilitas-grid">
            <div class="fasilitas-item"><div class="f-icon">🕌</div>Masjid</div>
            <div class="fasilitas-item"><div class="f-icon">📚</div>Perpustakaan</div>
            <div class="fasilitas-item"><div class="f-icon">🛏️</div>Asrama</div>
            <div class="fasilitas-item"><div class="f-icon">🍽️</div>Dapur & Kantin</div>
            <div class="fasilitas-item"><div class="f-icon">⚽</div>Lapangan Olahraga</div>
            <div class="fasilitas-item"><div class="f-icon">💻</div>Lab Komputer</div>
            <div class="fasilitas-item"><div class="f-icon">🏥</div>Klinik Kesehatan</div>
            <div class="fasilitas-item"><div class="f-icon">🌿</div>Taman Belajar</div>
        </div>
    </div>

    <!-- KONTAK -->
    <div class="section" style="padding-top:0">
        <h2>📞 Informasi & Kontak</h2>
        <div class="kontak-card">
            <div class="kontak-row">
                <span class="k-icon">📍</span>
                <span>Jl. Wahid Hasyim No. 3, Gaten, Condongcatur, Depok, Sleman, Yogyakarta.</span>
            </div>
            <div class="kontak-row">
                <span class="k-icon">📞</span>
                <span>0821-3355-7377</span>
            </div>
            <div class="kontak-row">
                <span class="k-icon">📱</span>
                <span>0857-2721-5874 (WhatsApp)</span>
            </div>
            <div class="kontak-row">
                <span class="k-icon">📧</span>
                <span>ppwahidhasyim.com</span>
            </div>
            <div class="kontak-row">
                <span class="k-icon">🕐</span>
                <span>Jam layanan: Senin – Sabtu, 08.00 – 16.00 WIB</span>
            </div>
        </div>
    </div>

    <!-- CTA BAWAH -->
    <div class="cta-section">
        <h2>Bergabunglah Bersama Kami!</h2>
        <p>Daftarkan putra/putri Anda sekarang dan wujudkan generasi Islam yang unggul</p>
        <a href="daftar.php" class="btn-daftar-2">📝 Mulai Pendaftaran</a>
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; <?= date('Y') ?> Pondok Pesantren wahid hasyim Yogyakarta. All rights reserved.
    </footer>

</body>
</html>