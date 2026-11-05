<?php

declare(strict_types=1);

namespace App\Core;

final class Upload
{
    private const MAX_BYTES = 2 * 1024 * 1024;

    /**
     * @var array<string, string>
     */
    private const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    /**
     * Simpan gambar upload dan kembalikan path relatif terhadap public/assets.
     *
     * @param array<string, mixed>|null $file
     * @return array{path?: string, error?: string}
     */
    public static function image(?array $file, string $folder): array
    {
        if ($file === null || (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return [];
        }

        if ((int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return ['error' => 'Berkas gagal diunggah. Coba pilih ulang.'];
        }

        if ((int) ($file['size'] ?? 0) > self::MAX_BYTES) {
            return ['error' => 'Ukuran gambar maksimal 2 MB.'];
        }

        $tmp = (string) ($file['tmp_name'] ?? '');

        if ($tmp === '' || !is_uploaded_file($tmp)) {
            return ['error' => 'Berkas upload tidak valid.'];
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($tmp);

        if (!is_string($mime) || !isset(self::ALLOWED[$mime])) {
            return ['error' => 'Format gambar harus JPG, PNG, atau WebP.'];
        }

        $folder = trim($folder, '/');
        $directory = BASE_PATH . '/public/assets/uploads/' . $folder;

        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            return ['error' => 'Folder upload tidak dapat dibuat.'];
        }

        $filename = bin2hex(random_bytes(12)) . '.' . self::ALLOWED[$mime];

        if (!move_uploaded_file($tmp, $directory . '/' . $filename)) {
            return ['error' => 'Gambar gagal disimpan. Coba lagi.'];
        }

        return ['path' => 'uploads/' . $folder . '/' . $filename];
    }

    /**
     * Hapus hanya berkas di folder upload (jangan sentuh aset contoh).
     */
    public static function delete(?string $path): void
    {
        $path = trim((string) $path);

        if (!str_starts_with($path, 'uploads/') || str_contains($path, '..')) {
            return;
        }

        $file = BASE_PATH . '/public/assets/' . $path;

        if (is_file($file)) {
            @unlink($file);
        }
    }
}
