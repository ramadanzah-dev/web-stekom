<?php

declare(strict_types=1);

/**
 * Escape output untuk konteks HTML.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Baca konfigurasi dengan notasi titik, mis. config('site.name').
 */
function config(?string $key = null, mixed $default = null): mixed
{
    $config = $GLOBALS['app_config'] ?? [];

    if ($key === null) {
        return $config;
    }

    foreach (explode('.', $key) as $segment) {
        if (!is_array($config) || !array_key_exists($segment, $config)) {
            return $default;
        }

        $config = $config[$segment];
    }

    return $config;
}

/**
 * Bangun URL absolut terhadap base URL aplikasi.
 */
function url(string $path = '/'): string
{
    $baseUrl = rtrim((string) config('base_url', ''), '/');
    $path = '/' . ltrim($path, '/');

    if ($path === '/') {
        return $baseUrl === '' ? '/' : $baseUrl . '/';
    }

    return $baseUrl . $path;
}

/**
 * URL untuk aset di public/assets.
 */
function asset(string $path): string
{
    return url('/assets/' . ltrim($path, '/'));
}

/**
 * URL gambar dari database, atau null jika kolomnya kosong.
 */
function gambar_url(?string $path): ?string
{
    $path = trim((string) $path);

    return $path === '' ? null : asset($path);
}

/**
 * Ubah teks menjadi slug URL: huruf kecil, angka, dan tanda hubung.
 */
function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? '';

    return trim($text, '-');
}

/**
 * Ambil (atau buat) token CSRF untuk session aktif.
 */
function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['_csrf'];
}

/**
 * Input hidden berisi token CSRF.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

/**
 * Validasi token CSRF dari form POST.
 */
function verify_csrf(?string $token): bool
{
    $sessionToken = $_SESSION['_csrf'] ?? null;

    return is_string($token) && is_string($sessionToken) && hash_equals($sessionToken, $token);
}

/**
 * Nama bulan dalam bahasa Indonesia.
 */
function bulan_id(int $bulan, bool $singkat = false): string
{
    $panjang = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $pendek = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    return ($singkat ? $pendek : $panjang)[$bulan - 1] ?? '';
}

/**
 * Format tanggal, mis. "24 Oktober 2026".
 */
function tanggal_id(string $datetime, bool $denganWaktu = false): string
{
    $waktu = strtotime($datetime);

    if ($waktu === false) {
        return $datetime;
    }

    $hasil = date('j', $waktu) . ' ' . bulan_id((int) date('n', $waktu)) . ' ' . date('Y', $waktu);

    if ($denganWaktu) {
        $hasil .= ' · ' . date('H.i', $waktu) . ' WIB';
    }

    return $hasil;
}

/**
 * Pecah teks menjadi paragraf berdasarkan baris kosong.
 *
 * @return array<int, string>
 */
function paragraphs(string $text): array
{
    $bagian = preg_split('/\R{2,}/u', trim($text)) ?: [];
    $bagian = array_map('trim', $bagian);

    return array_values(array_filter($bagian, static fn (string $paragraf): bool => $paragraf !== ''));
}

/**
 * Estimasi waktu baca dalam menit (asumsi 200 kata per menit).
 */
function reading_time(string $text): int
{
    $jumlahKata = str_word_count(strip_tags($text));

    return max(1, (int) ceil($jumlahKata / 200));
}

/**
 * Inisial dua kata pertama dari sebuah nama.
 */
function initials(string $name): string
{
    $bagian = preg_split('/\s+/u', trim($name)) ?: [];
    $inisial = '';

    foreach (array_slice($bagian, 0, 2) as $kata) {
        $inisial .= strtoupper(substr($kata, 0, 1));
    }

    return $inisial !== '' ? $inisial : '?';
}

