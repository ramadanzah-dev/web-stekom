-- 005 — Fitur dinamis beranda: marquee, tagline divisi, oprec setting, dan tabel kegiatan.

-- 1. Pengaturan marquee & oprec
INSERT INTO pengaturan (kunci, nilai) VALUES
    ('site_marquee', 'Ngoprek bareng, Bikin karya, Buka peluang, IIB Darmajaya, Sistem Komputer, Teknik Komputer'),
    ('oprec_deadline', '30 November 2026'),
    ('oprec_link', '/berita/open-recruitment-anggota-stekom-2026-2027'),
    ('oprec_aktif', '1')
ON DUPLICATE KEY UPDATE
    kunci = VALUES(kunci);

-- 2. Tambah kolom tagline di tabel divisi (jika belum ada)
SET @column_exists = (
    SELECT COUNT(*) 
    FROM information_schema.columns 
    WHERE table_schema = DATABASE() 
      AND table_name = 'divisi' 
      AND column_name = 'tagline'
);

SET @sql = IF(@column_exists = 0, 
    'ALTER TABLE divisi ADD COLUMN tagline VARCHAR(255) NULL AFTER nama', 
    'SELECT "Column tagline already exists"'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE divisi SET tagline = 'Bikin web & produk digital' WHERE slug = 'web-product';
UPDATE divisi SET tagline = 'Rancang aplikasi & antarmuka' WHERE slug = 'mobile-ui-ux';
UPDATE divisi SET tagline = 'Ubah data jadi keputusan' WHERE slug = 'data-ai';
UPDATE divisi SET tagline = 'Amankan sistem & jaringan' WHERE slug = 'keamanan-siber';
UPDATE divisi SET tagline = 'Rakit perangkat & sensor' WHERE slug = 'embedded-iot';
UPDATE divisi SET tagline = 'Bikin konten & cerita' WHERE slug = 'media-komunikasi';

-- 3. Tabel kegiatan/agenda
CREATE TABLE IF NOT EXISTS kegiatan (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    judul VARCHAR(150) NOT NULL,
    kategori VARCHAR(50) NOT NULL DEFAULT 'Agenda',
    deskripsi TEXT NULL,
    lokasi VARCHAR(150) NULL,
    tanggal_mulai DATE NOT NULL,
    aktif TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_kegiatan_tanggal (tanggal_mulai, aktif)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO kegiatan (judul, kategori, deskripsi, lokasi, tanggal_mulai, aktif) VALUES
    ('Workshop Embedded', 'Workshop', 'Dari sensor ke dashboard: praktik langsung merakit perangkat IoT.', 'Lab Hardware', '2026-11-08', 1),
    ('Sistem Komputer Expo', 'Expo', 'Pameran karya mahasiswa, talkshow industri, dan jejaring alumni.', 'Auditorium Kampus', '2026-11-12', 1),
    ('Batas Open Recruitment', 'Pendaftaran', 'Kesempatan terakhir buat gabung angkatan 2026/2027.', 'Online', '2026-11-30', 1);
