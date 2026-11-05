# AGENTS.md — web-hima

Website Himpunan Mahasiswa (HIMA). PHP native dengan struktur MVC sederhana, tanpa framework.

## Stack
- PHP 8.x native (tanpa Laravel/Composer framework)
- MariaDB, akses lewat PDO (prepared statement wajib)
- Tailwind CSS via CDN (`<script src="https://cdn.tailwindcss.com"></script>`), tanpa build step
- Dijalankan dengan built-in server: `php -S 0.0.0.0:8000 -t public public/index.php`
- Lingkungan: proot-distro (Debian/Ubuntu) di Termux, jadi hindari dependensi berat

## Struktur Folder
```
web-hima/
├── public/              # satu-satunya folder yang diakses browser
│   ├── index.php        # front controller (semua request lewat sini)
│   └── assets/          # gambar, js, css kustom, upload
├── app/
│   ├── Controllers/     # logika request (HomeController.php, dst.)
│   ├── Models/          # akses database (Anggota.php, Kegiatan.php, dst.)
│   ├── Views/
│   │   ├── layouts/     # main.php (head, navbar, footer, CDN Tailwind)
│   │   ├── partials/    # navbar.php, footer.php, komponen kecil
│   │   └── pages/       # satu folder per fitur
│   └── Core/            # Router.php, Database.php, Controller.php (base)
├── config/
│   ├── config.php       # konfigurasi umum (nama situs, base URL)
│   └── database.php     # kredensial DB (JANGAN di-commit nilai asli)
├── routes/
│   └── web.php          # daftar route
├── database/
│   └── schema.sql       # struktur tabel + seed contoh
├── storage/             # log, cache (tidak publik)
├── AGENTS.md
└── .gitignore
```

## Konvensi Kode
- `declare(strict_types=1);` di setiap file PHP.
- Class di `app/` memakai namespace `App\...` dan autoload sederhana (spl_autoload_register) di `public/index.php`.
- Nama class PascalCase, file sama dengan nama class. Method dan variabel camelCase. Nama tabel/kolom snake_case.
- Controller tipis: ambil input, panggil Model, kirim data ke View. Tidak ada query SQL di Controller atau View.
- Model berisi semua query. Gunakan PDO prepared statement, tidak boleh menyambung string SQL dengan input user.
- View hanya menampilkan data. Logika minimal (loop, if). Semua output user wajib di-escape: `htmlspecialchars($x, ENT_QUOTES, 'UTF-8')`, sediakan helper `e()`.
- Routing: didefinisikan di `routes/web.php`, contoh `$router->get('/kegiatan', [KegiatanController::class, 'index']);`
- Redirect dan render lewat helper di base Controller (`view()`, `redirect()`), bukan `include` langsung di Controller.

## Tampilan (Tailwind CDN)
- Semua halaman memakai `app/Views/layouts/main.php`, jangan menduplikasi `<head>`.
- Gunakan utility class Tailwind langsung di HTML. CSS kustom hanya jika terpaksa, taruh di `public/assets/css/custom.css`.
- Mobile-first, pakai prefix responsif (`sm:`, `md:`, `lg:`).
- Bahasa antarmuka: Indonesia. Tampilan rapi, bersih, nuansa organisasi mahasiswa.
- Gambar diberi atribut `alt`; tombol dan form punya label yang jelas.

## Keamanan (wajib)
- Prepared statement untuk semua query.
- Escape output dengan `e()`.
- Form POST memakai token CSRF (simpan di session, validasi di Controller).
- Password disimpan dengan `password_hash()` dan dicek dengan `password_verify()`.
- Upload file: validasi tipe MIME dan ukuran, ganti nama file, simpan di `public/assets/uploads/`.
- Halaman admin dilindungi cek session; regenerate session ID saat login.
- `config/database.php` tidak boleh berisi kredensial asli di repo; sediakan `config/database.example.php`.

## Database
- Skema ada di `database/schema.sql`. Setiap perubahan struktur ditulis ke file itu (atau `database/migrations/NNN_nama.sql`).
- Charset `utf8mb4`, engine InnoDB.
- Jangan pernah memakai user `root` di aplikasi; pakai user khusus (mis. `dev`).

## Perintah Umum
```
mariadbd-safe --user=mysql &                      # nyalakan database
php -S 0.0.0.0:8000 -t public public/index.php    # jalankan web
mariadb -u dev -p nama_database < database/schema.sql
```

## Cara Bekerja
- Sebelum mengubah, baca file terkait dan ikuti pola yang sudah ada.
- Perubahan kecil dan terfokus; jangan merombak struktur tanpa diminta.
- Fitur baru: buat Route, Controller, Model, dan View secara berurutan, lalu uji di browser.
- Jangan menambah library/dependensi tanpa persetujuan; utamakan PHP bawaan.
- Setelah selesai, jelaskan singkat file apa yang diubah dan cara mengujinya.
- Commit message berbahasa Indonesia, singkat, imperatif (mis. "Tambah halaman daftar kegiatan").
