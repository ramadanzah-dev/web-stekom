<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOStatement;

final class Pengurus
{
    /**
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function pastByPeriod(string $currentPeriod): array
    {
        $statement = Database::connection()->prepare(
            'SELECT p.id, p.nama, p.foto, p.jabatan, p.divisi_id, p.periode, p.urutan,
                    d.nama AS divisi_nama
             FROM pengurus p
             LEFT JOIN divisi d ON d.id = p.divisi_id
             WHERE p.periode <> :currentPeriod
             ORDER BY p.periode DESC, p.urutan ASC, p.id ASC'
        );
        $statement->bindValue(':currentPeriod', $currentPeriod);
        $statement->execute();

        $rows = $statement->fetchAll();
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['periode']][] = $row;
        }

        return $grouped;
    }

    /**
     * Pengurus inti (tanpa divisi), diurutkan sesuai struktur.
     *
     * @return array<int, array<string, mixed>>
     */
    public function core(string $periode): array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, nama, foto, jabatan, divisi_id, periode
             FROM pengurus
             WHERE aktif = 1 AND divisi_id IS NULL AND periode = :periode
             ORDER BY urutan ASC, id ASC'
        );
        $statement->bindValue(':periode', $periode);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function adminList(): array
    {
        $statement = Database::connection()->query(
            'SELECT p.id, p.nama, p.foto, p.jabatan, p.divisi_id, p.periode, p.urutan, p.aktif,
                    d.nama AS divisi_nama
             FROM pengurus p
             LEFT JOIN divisi d ON d.id = p.divisi_id
             ORDER BY p.urutan ASC, p.id ASC'
        );

        return $statement->fetchAll();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT p.id, p.nama, p.foto, p.jabatan, p.divisi_id, p.periode, p.urutan, p.aktif,
                    d.nama AS divisi_nama
             FROM pengurus p
             LEFT JOIN divisi d ON d.id = p.divisi_id
             WHERE p.id = :id
             LIMIT 1'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $pengurus = $statement->fetch();

        return $pengurus === false ? null : $pengurus;
    }

    /**
     * @param array{nama: string, foto: ?string, jabatan: string, divisi_id: ?int, periode: string, urutan: int, aktif: int} $data
     */
    public function create(array $data): int
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO pengurus (nama, foto, jabatan, divisi_id, periode, urutan, aktif)
             VALUES (:nama, :foto, :jabatan, :divisi_id, :periode, :urutan, :aktif)'
        );

        $this->bindData($statement, $data);
        $statement->execute();

        return (int) Database::connection()->lastInsertId();
    }

    /**
     * @param array{nama: string, foto: ?string, jabatan: string, divisi_id: ?int, periode: string, urutan: int, aktif: int} $data
     */
    public function update(int $id, array $data): bool
    {
        $statement = Database::connection()->prepare(
            'UPDATE pengurus
             SET nama = :nama,
                 foto = :foto,
                 jabatan = :jabatan,
                 divisi_id = :divisi_id,
                 periode = :periode,
                 urutan = :urutan,
                 aktif = :aktif
             WHERE id = :id'
        );

        $this->bindData($statement, $data);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $statement = Database::connection()->prepare('DELETE FROM pengurus WHERE id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * @param array<int> $ids
     * @return array<int, array<string, mixed>>
     */
    public function findMany(array $ids): array
    {
        if ($ids === []) {
            return [];
        }

        $pdo = Database::connection();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $statement = $pdo->prepare(
            'SELECT p.id, p.nama, p.foto, p.jabatan, p.divisi_id, p.periode, p.urutan, p.aktif,
                    d.nama AS divisi_nama
             FROM pengurus p
             LEFT JOIN divisi d ON d.id = p.divisi_id
             WHERE p.id IN (' . $placeholders . ')'
        );
        $statement->execute($ids);

        return $statement->fetchAll();
    }

    /**
     * @param array<int> $ids
     */
    public function deleteMany(array $ids): bool
    {
        if ($ids === []) {
            return false;
        }

        $pdo = Database::connection();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $statement = $pdo->prepare("DELETE FROM pengurus WHERE id IN ($placeholders)");

        return $statement->execute($ids);
    }

    public function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM pengurus')->fetchColumn();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function recent(int $limit = 5): array
    {
        $limit = max(1, min($limit, 20));

        $statement = Database::connection()->prepare(
            'SELECT id, nama, foto, jabatan, periode, urutan, aktif
             FROM pengurus
             ORDER BY created_at DESC, id DESC
             LIMIT :limit'
        );
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param array{nama: string, foto: ?string, jabatan: string, divisi_id: ?int, periode: string, urutan: int, aktif: int} $data
     */
    private function bindData(PDOStatement $statement, array $data): void
    {
        $statement->bindValue(':nama', $data['nama']);
        $statement->bindValue(':foto', $data['foto']);

        if ($data['divisi_id'] === null) {
            $statement->bindValue(':divisi_id', null, PDO::PARAM_NULL);
        } else {
            $statement->bindValue(':divisi_id', $data['divisi_id'], PDO::PARAM_INT);
        }

        $statement->bindValue(':jabatan', $data['jabatan']);
        $statement->bindValue(':periode', $data['periode']);
        $statement->bindValue(':urutan', $data['urutan'], PDO::PARAM_INT);
        $statement->bindValue(':aktif', $data['aktif'], PDO::PARAM_INT);
    }
}
