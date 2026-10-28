<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use Throwable;

final class Pengaturan
{
    /**
     * Cache nilai pengaturan untuk satu request.
     *
     * @var array<string, string>|null
     */
    private static ?array $cache = null;

    /**
     * Seluruh pengaturan dalam bentuk kunci => nilai.
     *
     * @return array<string, string>
     */
    public function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $statement = Database::connection()->query(
            'SELECT kunci, nilai FROM pengaturan ORDER BY kunci ASC'
        );

        $values = [];

        foreach ($statement->fetchAll() as $row) {
            $values[(string) $row['kunci']] = (string) ($row['nilai'] ?? '');
        }

        return self::$cache = $values;
    }

    /**
     * Terapkan pengaturan bertanda "site_" ke konfigurasi situs.
     *
     * @param array<string, mixed> $defaults
     * @return array<string, mixed>
     */
    public function apply(array $defaults): array
    {
        foreach ($this->all() as $key => $value) {
            if (!str_starts_with($key, 'site_')) {
                continue;
            }

            $defaults[substr($key, 5)] = $value;
        }

        return $defaults;
    }

    /**
     * Simpan beberapa pengaturan sekaligus (insert atau update).
     *
     * @param array<string, string> $values
     */
    public function save(array $values): void
    {
        $connection = Database::connection();
        $statement = $connection->prepare(
            'INSERT INTO pengaturan (kunci, nilai) VALUES (:kunci, :nilai)
             ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)'
        );

        $connection->beginTransaction();

        try {
            foreach ($values as $key => $value) {
                $statement->bindValue(':kunci', (string) $key);
                $statement->bindValue(':nilai', (string) $value);
                $statement->execute();
            }

            $connection->commit();
        } catch (Throwable $error) {
            $connection->rollBack();

            throw $error;
        }

        self::$cache = null;
    }

    /**
     * Hapus semua penyesuaian sehingga situs kembali ke nilai bawaan.
     */
    public function reset(): void
    {
        Database::connection()->exec('DELETE FROM pengaturan');

        self::$cache = null;
    }
}
