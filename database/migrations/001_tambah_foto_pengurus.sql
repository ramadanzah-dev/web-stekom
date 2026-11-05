-- 001 — Tambah kolom foto pada tabel pengurus (foto dummy sementara).
-- Aman dijalankan berulang pada MariaDB (mendukung IF NOT EXISTS).

ALTER TABLE pengurus
    ADD COLUMN IF NOT EXISTS foto VARCHAR(255) NULL AFTER nama;

UPDATE pengurus SET foto = 'img/pengurus/raka-pratama.svg' WHERE nama = 'Raka Pratama';
UPDATE pengurus SET foto = 'img/pengurus/nadia-putri.svg' WHERE nama = 'Nadia Putri';
UPDATE pengurus SET foto = 'img/pengurus/bima-saputra.svg' WHERE nama = 'Bima Saputra';
UPDATE pengurus SET foto = 'img/pengurus/salsabila-rahma.svg' WHERE nama = 'Salsabila Rahma';
UPDATE pengurus SET foto = 'img/pengurus/fajar-nugroho.svg' WHERE nama = 'Fajar Nugroho';
UPDATE pengurus SET foto = 'img/pengurus/alya-kirana.svg' WHERE nama = 'Alya Kirana';
UPDATE pengurus SET foto = 'img/pengurus/dimas-aryo.svg' WHERE nama = 'Dimas Aryo';
UPDATE pengurus SET foto = 'img/pengurus/rizky-maulana.svg' WHERE nama = 'Rizky Maulana';
UPDATE pengurus SET foto = 'img/pengurus/intan-permata.svg' WHERE nama = 'Intan Permata';
UPDATE pengurus SET foto = 'img/pengurus/yusuf-hidayat.svg' WHERE nama = 'Yusuf Hidayat';
