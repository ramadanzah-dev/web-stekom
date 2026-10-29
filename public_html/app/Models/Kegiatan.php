<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Kegiatan
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $statement = Database::connection()->query(
            'SELECT id, judul, kategori, deskripsi, lokasi, tanggal_mulai, aktif
             FROM kegiatan
             ORDER BY tanggal_mulai ASC, id ASC'
        );

        return $statement->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function upcoming(int $limit = 10): array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, judul, kategori, deskripsi, lokasi, tanggal_mulai, aktif
             FROM kegiatan
             WHERE aktif = 1 AND tanggal_mulai >= CURDATE()
             ORDER BY tanggal_mulai ASC
             LIMIT :limit'
        );
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, judul, kategori, deskripsi, lokasi, tanggal_mulai, aktif
             FROM kegiatan
             WHERE id = :id
             LIMIT 1'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch();

        return $row === false ? null : $row;
    }

    /**
     * @param array{judul: string, kategori: string, deskripsi: ?string, lokasi: ?string, tanggal_mulai: string, aktif: int} $data
     */
    public function create(array $data): int
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO kegiatan (judul, kategori, deskripsi, lokasi, tanggal_mulai, aktif)
             VALUES (:judul, :kategori, :deskripsi, :lokasi, :tanggal_mulai, :aktif)'
        );

        $this->bindData($statement, $data);
        $statement->execute();

        return (int) Database::connection()->lastInsertId();
    }

    /**
     * @param array{judul: string, kategori: string, deskripsi: ?string, lokasi: ?string, tanggal_mulai: string, aktif: int} $data
     */
    public function update(int $id, array $data): bool
    {
        $statement = Database::connection()->prepare(
            'UPDATE kegiatan
             SET judul = :judul,
                 kategori = :kategori,
                 deskripsi = :deskripsi,
                 lokasi = :lokasi,
                 tanggal_mulai = :tanggal_mulai,
                 aktif = :aktif
             WHERE id = :id'
        );

        $this->bindData($statement, $data);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $statement = Database::connection()->prepare('DELETE FROM kegiatan WHERE id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM kegiatan')->fetchColumn();
    }

    /**
     * @param array{judul: string, kategori: string, deskripsi: ?string, lokasi: ?string, tanggal_mulai: string, aktif: int} $data
     */
    private function bindData(PDOStatement $statement, array $data): void
    {
        $statement->bindValue(':judul', $data['judul']);
        $statement->bindValue(':kategori', $data['kategori']);
        $statement->bindValue(':deskripsi', $data['deskripsi'] !== '' ? $data['deskripsi'] : null);
        $statement->bindValue(':lokasi', $data['lokasi'] !== '' ? $data['lokasi'] : null);
        $statement->bindValue(':tanggal_mulai', $data['tanggal_mulai']);
        $statement->bindValue(':aktif', $data['aktif'], PDO::PARAM_INT);
    }
}
