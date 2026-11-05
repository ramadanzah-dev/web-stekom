-- Skema database STEKOM
-- MariaDB / MySQL, charset utf8mb4, engine InnoDB.

CREATE DATABASE IF NOT EXISTS stekom
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE stekom;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pengurus') NOT NULL DEFAULT 'pengurus',
    aktif TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (nama, email, password_hash, role) VALUES
    (
        'Admin STEKOM',
        'admin@stekom.id',
        '$2y$12$AVE4/jjO9ZrIRJcpu96cOeskBYMw51aWDkazUpQXtuXB8qt/Hqx8W',
        'admin'
    )
ON DUPLICATE KEY UPDATE
    nama = VALUES(nama),
    role = VALUES(role);

CREATE TABLE IF NOT EXISTS divisi (
    id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    deskripsi TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY divisi_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS kegiatan (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    divisi_id TINYINT UNSIGNED NULL,
    judul VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL,
    deskripsi TEXT NULL,
    lokasi VARCHAR(150) NULL,
    mulai_pada DATETIME NULL,
    selesai_pada DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY kegiatan_slug_unique (slug),
    KEY kegiatan_divisi_id_index (divisi_id),
    CONSTRAINT kegiatan_divisi_id_foreign
        FOREIGN KEY (divisi_id) REFERENCES divisi (id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS anggota (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    angkatan YEAR NOT NULL,
    divisi_id TINYINT UNSIGNED NULL,
    jabatan VARCHAR(50) NULL,
    aktif TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY anggota_nim_unique (nim),
    KEY anggota_divisi_id_index (divisi_id),
    CONSTRAINT anggota_divisi_id_foreign
        FOREIGN KEY (divisi_id) REFERENCES divisi (id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO divisi (nama, slug, deskripsi) VALUES
    ('Web & Product', 'web-product', 'Membangun produk digital dari riset, desain, sampai deploy.'),
    ('Mobile & UI/UX', 'mobile-ui-ux', 'Merancang pengalaman digital di layar kecil maupun besar.'),
    ('Data & AI', 'data-ai', 'Mengolah data menjadi insight, model, dan keputusan.'),
    ('Keamanan Siber', 'keamanan-siber', 'Pertahanan sistem, etika hacking, dan budaya aman digital.'),
    ('Embedded & IoT', 'embedded-iot', 'Menghubungkan perangkat fisik dengan kode dan sensor.'),
    ('Media & Komunikasi', 'media-komunikasi', 'Menceritakan karya himpunan lewat desain, foto, dan konten.')
ON DUPLICATE KEY UPDATE nama = VALUES(nama);

CREATE TABLE IF NOT EXISTS berita (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    judul VARCHAR(180) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    gambar VARCHAR(255) NULL,
    kategori VARCHAR(50) NOT NULL,
    ringkasan VARCHAR(320) NOT NULL,
    isi TEXT NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    diterbitkan_pada DATETIME NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY berita_slug_unique (slug),
    KEY berita_diterbitkan_pada_index (diterbitkan_pada)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pengurus (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    foto VARCHAR(255) NULL,
    jabatan VARCHAR(80) NOT NULL,
    divisi_id TINYINT UNSIGNED NULL,
    periode VARCHAR(20) NOT NULL,
    urutan TINYINT UNSIGNED NOT NULL DEFAULT 0,
    aktif TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY pengurus_periode_nama_unique (periode, nama),
    KEY pengurus_divisi_id_index (divisi_id),
    CONSTRAINT pengurus_divisi_id_foreign
        FOREIGN KEY (divisi_id) REFERENCES divisi (id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO berita (judul, slug, gambar, kategori, ringkasan, isi, penulis, diterbitkan_pada) VALUES
    (
        'Tim STEKOM Juara 2 Kompetisi IoT Nasional',
        'tim-stekom-juara-2-kompetisi-iot-nasional',
        'img/berita/tim-stekom-juara-2-kompetisi-iot-nasional.svg',
        'Prestasi',
        'Perangkat pemantau kualitas air karya tiga mahasiswa Sistem Komputer menempati posisi runner-up di kompetisi IoT nasional.',
        'Tim STEKOM kembali membawa pulang prestasi. Perangkat pemantau kualitas air berbasis sensor dan dashboard real-time karya tiga mahasiswa Sistem Komputer berhasil meraih juara kedua pada Kompetisi IoT Nasional yang digelar akhir pekan lalu.\n\nPerangkat bernama Tirta Watch ini membaca tingkat keasaman, kekeruhan, dan suhu air, lalu mengirimkan data ke dashboard yang bisa dipantau dari jarak jauh. Prototipe dikembangkan selama enam minggu dengan pendampingan dosen dan alumni.\n\n"Kami ingin teknologi tidak berhenti di demo. Tantangannya adalah membuat alat ini murah, tahan lama, dan mudah dipakai di lapangan," ujar ketua tim, Raka Pratama.\n\nKe depan, tim berencana menguji perangkat di beberapa titik sungai bersama komunitas lingkungan kampus.',
        'Humas STEKOM',
        '2026-10-24 09:00:00'
    ),
    (
        'Open Recruitment Anggota STEKOM 2026/2027 Resmi Dibuka',
        'open-recruitment-anggota-stekom-2026-2027',
        'img/berita/open-recruitment-anggota-stekom-2026-2027.svg',
        'Pengumuman',
        'Pendaftaran anggota baru STEKOM dibuka untuk seluruh mahasiswa aktif Sistem Komputer. Simak alur dan jadwal lengkapnya.',
        'STEKOM membuka pendaftaran anggota baru untuk periode 2026/2027. Rekrutmen terbuka bagi seluruh mahasiswa aktif program studi Sistem Komputer yang ingin belajar, berkarya, dan bertumbuh bersama.\n\nPendaftaran dilakukan secara daring sampai 30 November 2026. Setelah itu, peserta akan mengikuti sesi perkenalan divisi, wawancara singkat, dan proyek kolaborasi sebagai bagian dari proses seleksi.\n\nTidak ada syarat pengalaman sebelumnya. Yang kami cari adalah rasa ingin tahu, komitmen, dan kemauan untuk bekerja dalam tim. Setiap anggota baru akan didampingi mentor dari divisi pilihannya.\n\nInformasi lengkap dan tautan pendaftaran bisa didapat melalui akun Instagram resmi STEKOM atau dengan menghubungi pengurus.',
        'Pengurus STEKOM',
        '2026-10-18 08:00:00'
    ),
    (
        'Sistem Komputer Expo 2026, Ruang Temu Karya dan Industri',
        'sistem-komputer-expo-2026',
        'img/berita/sistem-komputer-expo-2026.svg',
        'Kegiatan',
        'Pameran karya mahasiswa, talkshow industri, dan jejaring alumni akan memeriahkan Sistem Komputer Expo 2026 di Auditorium Kampus.',
        'Sistem Komputer Expo kembali hadir pada 12 November 2026. Acara tahunan ini menjadi ruang temu antara karya mahasiswa, praktisi industri, dan alumni Sistem Komputer.\n\nTahun ini, lebih dari 30 proyek mahasiswa akan dipamerkan, mulai dari aplikasi web, perangkat IoT, sampai eksperimen kecerdasan artifisial. Setiap proyek akan didampingi tim yang siap menjelaskan proses dan tantangan di baliknya.\n\nSelain pameran, akan ada talkshow bertema "Menyiapkan Talenta Teknologi yang Relevan" bersama perwakilan industri dan sesi jejaring alumni.\n\nAcara terbuka untuk mahasiswa dan masyarakat umum. Pendaftaran pengunjung dibuka melalui tautan yang tersedia di Instagram STEKOM.',
        'Divisi Media & Komunikasi',
        '2026-10-10 10:00:00'
    ),
    (
        'Workshop Embedded: Dari Sensor ke Dashboard dalam Satu Akhir Pekan',
        'workshop-embedded-sensor-ke-dashboard',
        'img/berita/workshop-embedded-sensor-ke-dashboard.svg',
        'Kegiatan',
        'Dua hari praktik langsung merakit perangkat IoT, membaca sensor, dan menampilkan data ke dashboard.',
        'Divisi Embedded & IoT menggelar workshop intensif selama dua hari di Lab Hardware. Peserta belajar merakit perangkat, menghubungkan sensor, dan mengirim data ke dashboard sederhana.\n\nMateri dimulai dari dasar mikrokontroler, pembacaan sensor suhu dan kelembapan, lalu berlanjut ke komunikasi data melalui jaringan. Di akhir sesi, setiap tim mempresentasikan prototipe kecil yang mereka bangun.\n\n"Kami sengaja membuat formatnya praktik, bukan teori panjang. Peserta langsung menghadapi masalah nyata dan belajar mencari solusinya," kata koordinator divisi, Intan Permata.\n\nWorkshop ini merupakan bagian dari rangkaian kelas rutin STEKOM yang terbuka untuk seluruh anggota.',
        'Divisi Embedded & IoT',
        '2026-09-29 13:00:00'
    ),
    (
        'STEKOM dan Komunitas Data Kampus Jalin Kolaborasi',
        'stekom-komunitas-data-kampus-kolaborasi',
        'img/berita/stekom-komunitas-data-kampus-kolaborasi.svg',
        'Kolaborasi',
        'Kedua komunitas akan berbagi kelas, menggarap proyek data terbuka, dan menyiapkan program mentoring bersama.',
        'STEKOM menandatangani kerja sama dengan Komunitas Data Kampus untuk memperkuat ekosistem belajar berbasis data di lingkungan mahasiswa. Kolaborasi ini mencakup kelas bersama, proyek data terbuka, dan program mentoring lintas komunitas.\n\nProgram pertama akan berfokus pada pengolahan data kampus menjadi visualisasi yang mudah dipahami. Hasilnya direncanakan dipublikasikan sebagai bahan diskusi terbuka.\n\n"Kolaborasi ini membuka kesempatan bagi anggota untuk belajar dari perspektif lain. Data bukan hanya soal angka, tetapi juga cara memahami persoalan," ujar Nadia Putri, Wakil Ketua STEKOM.\n\nDetail jadwal kegiatan akan diumumkan melalui kanal resmi kedua komunitas.',
        'Divisi Data & AI',
        '2026-09-15 09:30:00'
    ),
    (
        'Menyusun Peta Belajar Sistem Komputer Bersama Alumni',
        'menyusun-peta-belajar-sistem-komputer',
        'img/berita/menyusun-peta-belajar-sistem-komputer.svg',
        'Teknologi',
        'Sesi diskusi bersama alumni menghasilkan peta belajar yang lebih terarah untuk mahasiswa baru Sistem Komputer.',
        'Apa saja yang sebaiknya dipelajari lebih dulu di Sistem Komputer? Pertanyaan itu menjadi titik awal diskusi STEKOM bersama sejumlah alumni pada akhir pekan lalu.\n\nDiskusi menghasilkan peta belajar yang dibagi ke dalam beberapa fase: dasar pemrograman, pemahaman sistem, penguatan proyek, dan persiapan karier. Setiap fase dilengkapi rekomendasi topik dan proyek kecil untuk latihan.\n\nAlumni menekankan pentingnya keseimbangan antara fondasi teori dan kebiasaan membangun. Menurut mereka, portofolio yang tumbuh dari proyek nyata lebih meyakinkan daripada daftar sertifikat yang panjang.\n\nRingkasan peta belajar akan dibagikan kepada anggota dan diperbarui secara berkala bersama divisi terkait.',
        'Divisi Web & Product',
        '2026-08-30 10:00:00'
    )
ON DUPLICATE KEY UPDATE
    judul = VALUES(judul),
    gambar = VALUES(gambar),
    kategori = VALUES(kategori),
    ringkasan = VALUES(ringkasan),
    isi = VALUES(isi),
    penulis = VALUES(penulis),
    diterbitkan_pada = VALUES(diterbitkan_pada);

INSERT INTO pengurus (nama, foto, jabatan, divisi_id, periode, urutan) VALUES
    ('Raka Pratama', 'img/pengurus/raka-pratama.svg', 'Ketua Umum', NULL, '2026/2027', 1),
    ('Nadia Putri', 'img/pengurus/nadia-putri.svg', 'Wakil Ketua Umum', NULL, '2026/2027', 2),
    ('Bima Saputra', 'img/pengurus/bima-saputra.svg', 'Sekretaris Umum', NULL, '2026/2027', 3),
    ('Salsabila Rahma', 'img/pengurus/salsabila-rahma.svg', 'Bendahara Umum', NULL, '2026/2027', 4),
    ('Fajar Nugroho', 'img/pengurus/fajar-nugroho.svg', 'Koordinator Divisi', (SELECT id FROM divisi WHERE slug = 'web-product'), '2026/2027', 5),
    ('Alya Kirana', 'img/pengurus/alya-kirana.svg', 'Koordinator Divisi', (SELECT id FROM divisi WHERE slug = 'mobile-ui-ux'), '2026/2027', 6),
    ('Dimas Aryo', 'img/pengurus/dimas-aryo.svg', 'Koordinator Divisi', (SELECT id FROM divisi WHERE slug = 'data-ai'), '2026/2027', 7),
    ('Rizky Maulana', 'img/pengurus/rizky-maulana.svg', 'Koordinator Divisi', (SELECT id FROM divisi WHERE slug = 'keamanan-siber'), '2026/2027', 8),
    ('Intan Permata', 'img/pengurus/intan-permata.svg', 'Koordinator Divisi', (SELECT id FROM divisi WHERE slug = 'embedded-iot'), '2026/2027', 9),
    ('Yusuf Hidayat', 'img/pengurus/yusuf-hidayat.svg', 'Koordinator Divisi', (SELECT id FROM divisi WHERE slug = 'media-komunikasi'), '2026/2027', 10)
ON DUPLICATE KEY UPDATE
    foto = VALUES(foto),
    jabatan = VALUES(jabatan),
    divisi_id = VALUES(divisi_id),
    urutan = VALUES(urutan);

CREATE TABLE IF NOT EXISTS pengaturan (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    kunci VARCHAR(100) NOT NULL,
    nilai TEXT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY pengaturan_kunci_unique (kunci)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO pengaturan (kunci, nilai) VALUES
    ('site_name', 'STEKOM'),
    ('site_full_name', 'Himpunan Mahasiswa Sistem Komputer'),
    ('site_tagline', 'Ruang tumbuh mahasiswa Sistem Komputer.'),
    ('site_description', 'STEKOM adalah himpunan mahasiswa Sistem Komputer: wadah kolaborasi, karya, dan pengembangan diri di bidang teknologi.'),
    ('site_periode', '2026/2027'),
    ('site_email', 'halo@stekom.id'),
    ('site_instagram', 'https://www.instagram.com/stekom'),
    ('site_location', 'Kampus Sistem Komputer'),
    ('site_logo', ''),
    ('site_footer_text', 'Belajar, berkarya, dan bertumbuh bersama.'),
    ('site_footer_note', 'Dibuat dengan rapi.')
ON DUPLICATE KEY UPDATE
    kunci = VALUES(kunci);
