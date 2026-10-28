<?php

declare(strict_types=1);

/*
 * Contoh konfigurasi koneksi database.
 * Salin file ini menjadi config/database.php, lalu isi nilainya.
 * Jangan memakai user root untuk aplikasi.
 */
return [
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'port' => 3306,
    'database' => 'stekom',
    'username' => 'dev',
    'password' => 'ganti-dengan-password-aman',
    'charset' => 'utf8mb4',
];
