-- 003 — Akun admin untuk halaman /admin.
-- Login default: admin@stekom.id / admin123
-- Segera ganti kata sandi setelah login pertama.

ALTER TABLE users
    ADD COLUMN IF NOT EXISTS aktif TINYINT(1) NOT NULL DEFAULT 1;

ALTER TABLE users
    ADD COLUMN IF NOT EXISTS last_login_at DATETIME NULL;

INSERT INTO users (nama, email, password_hash, role)
VALUES (
    'Admin STEKOM',
    'admin@stekom.id',
    '$2y$12$AVE4/jjO9ZrIRJcpu96cOeskBYMw51aWDkazUpQXtuXB8qt/Hqx8W',
    'admin'
)
ON DUPLICATE KEY UPDATE
    nama = VALUES(nama),
    role = VALUES(role);
