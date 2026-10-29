-- 004 — Pengaturan situs: judul, footer, logo, dan kontak.
-- Nilai awal mengikuti config/config.php. Baris yang diubah admin akan
-- dipakai situs; bila baris dihapus, situs kembali ke nilai bawaan config.

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
