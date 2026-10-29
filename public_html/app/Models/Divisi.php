<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Divisi
{
    /**
     * Daftar divisi beserta nama koordinatornya.
     *
     * @return array<int, array<string, mixed>>
     */
    public function withKoordinator(string $periode): array
    {
        $statement = Database::connection()->prepare(
            'SELECT d.id, d.nama, d.slug, d.tagline, d.deskripsi, p.nama AS koordinator, p.foto AS koordinator_foto
             FROM divisi d
             LEFT JOIN pengurus p
                ON p.divisi_id = d.id
                AND p.aktif = 1
                AND p.jabatan = :jabatan
                AND p.periode = :periode
             ORDER BY d.id ASC'
        );
        $statement->bindValue(':jabatan', 'Koordinator Divisi');
        $statement->bindValue(':periode', $periode);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $statement = Database::connection()->query(
            'SELECT d.id, d.nama, d.slug, d.tagline, d.deskripsi,
                    (SELECT COUNT(*) FROM pengurus p WHERE p.divisi_id = d.id) AS jumlah_pengurus
             FROM divisi d
             ORDER BY d.id ASC'
        );

        return $statement->fetchAll();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, nama, slug, tagline, deskripsi FROM divisi WHERE id = :id LIMIT 1'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $divisi = $statement->fetch();

        return $divisi === false ? null : $divisi;
    }

    /**
     * @param array{nama: string, slug: string, tagline?: ?string, deskripsi: string} $data
     */
    public function create(array $data): int
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO divisi (nama, slug, tagline, deskripsi) VALUES (:nama, :slug, :tagline, :deskripsi)'
        );

        $this->bindData($statement, $data);
        $statement->execute();

        return (int) Database::connection()->lastInsertId();
    }

    /**
     * @param array{nama: string, slug: string, tagline?: ?string, deskripsi: string} $data
     */
    public function update(int $id, array $data): bool
    {
        $statement = Database::connection()->prepare(
            'UPDATE divisi
             SET nama = :nama, slug = :slug, tagline = :tagline, deskripsi = :deskripsi
             WHERE id = :id'
        );

        $this->bindData($statement, $data);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $statement = Database::connection()->prepare('DELETE FROM divisi WHERE id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM divisi')->fetchColumn();
    }

    public function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $base = trim($base) !== '' ? trim($base) : 'divisi';
        $slug = $base;
        $counter = 2;

        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $ignoreId): bool
    {
        $sql = 'SELECT COUNT(*) FROM divisi WHERE slug = :slug';

        if ($ignoreId !== null) {
            $sql .= ' AND id <> :id';
        }

        $statement = Database::connection()->prepare($sql);
        $statement->bindValue(':slug', $slug);

        if ($ignoreId !== null) {
            $statement->bindValue(':id', $ignoreId, PDO::PARAM_INT);
        }

        $statement->execute();

        return (int) $statement->fetchColumn() > 0;
    }

    /**
     * @param array{nama: string, slug: string, tagline?: ?string, deskripsi: string} $data
     */
    private function bindData(\PDOStatement $statement, array $data): void
    {
        $statement->bindValue(':nama', $data['nama']);
        $statement->bindValue(':slug', $data['slug']);
        $statement->bindValue(':tagline', $data['tagline'] ?? null);
        $statement->bindValue(':deskripsi', $data['deskripsi']);
    }
}
