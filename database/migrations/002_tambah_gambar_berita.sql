-- 002 — Tambah kolom gambar (cover) pada tabel berita.
-- Aman dijalankan berulang pada MariaDB (mendukung IF NOT EXISTS).

ALTER TABLE berita
    ADD COLUMN IF NOT EXISTS gambar VARCHAR(255) NULL AFTER slug;

UPDATE berita SET gambar = 'img/berita/tim-stekom-juara-2-kompetisi-iot-nasional.svg'
    WHERE slug = 'tim-stekom-juara-2-kompetisi-iot-nasional';
UPDATE berita SET gambar = 'img/berita/open-recruitment-anggota-stekom-2026-2027.svg'
    WHERE slug = 'open-recruitment-anggota-stekom-2026-2027';
UPDATE berita SET gambar = 'img/berita/sistem-komputer-expo-2026.svg'
    WHERE slug = 'sistem-komputer-expo-2026';
UPDATE berita SET gambar = 'img/berita/workshop-embedded-sensor-ke-dashboard.svg'
    WHERE slug = 'workshop-embedded-sensor-ke-dashboard';
UPDATE berita SET gambar = 'img/berita/stekom-komunitas-data-kampus-kolaborasi.svg'
    WHERE slug = 'stekom-komunitas-data-kampus-kolaborasi';
UPDATE berita SET gambar = 'img/berita/menyusun-peta-belajar-sistem-komputer.svg'
    WHERE slug = 'menyusun-peta-belajar-sistem-komputer';
