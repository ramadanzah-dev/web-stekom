<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Berita
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function latest(int $limit = 3, ?int $excludeId = null): array
    {
        $limit = max(1, min($limit, 20));
        $sql = $this->selectColumns();

        if ($excludeId !== null) {
            $sql .= ' WHERE id <> :exclude';
        }

        $sql .= ' ORDER BY diterbitkan_pada DESC, id DESC LIMIT :limit';

        $statement = Database::connection()->prepare($sql);

        if ($excludeId !== null) {
            $statement->bindValue(':exclude', $excludeId, PDO::PARAM_INT);
        }

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @return array{
     *     items: array<int, array<string, mixed>>,
     *     total: int,
     *     page: int,
     *     pages: int,
     *     perPage: int
     * }
     */
    public function paginate(int $page = 1, int $perPage = 9, ?int $excludeId = null): array
    {
        $pdo = Database::connection();
        $perPage = max(1, min($perPage, 24));
        $where = $excludeId !== null ? ' WHERE id <> :exclude' : '';

        $countStatement = $pdo->prepare('SELECT COUNT(*) FROM berita' . $where);

        if ($excludeId !== null) {
            $countStatement->bindValue(':exclude', $excludeId, PDO::PARAM_INT);
        }

        $countStatement->execute();
        $total = (int) $countStatement->fetchColumn();

        $pages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $pages));
        $offset = ($page - 1) * $perPage;

        $sql = $this->selectColumns() . $where . ' ORDER BY diterbitkan_pada DESC, id DESC LIMIT :limit OFFSET :offset';
        $statement = $pdo->prepare($sql);

        if ($excludeId !== null) {
            $statement->bindValue(':exclude', $excludeId, PDO::PARAM_INT);
        }

        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return [
            'items' => $statement->fetchAll(),
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
            'perPage' => $perPage,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findBySlug(string $slug): ?array
    {
        $statement = Database::connection()->prepare(
            $this->selectColumns() . ' WHERE slug = :slug LIMIT 1'
        );
        $statement->bindValue(':slug', $slug);
        $statement->execute();

        $berita = $statement->fetch();

        return $berita === false ? null : $berita;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function adminList(?string $q = null): array
    {
        $sql = $this->selectColumns();
        $params = [];

        if ($q !== null && trim($q) !== '') {
            $sql .= ' WHERE judul LIKE :q1 OR ringkasan LIKE :q2 OR penulis LIKE :q3';
            $like = '%' . trim($q) . '%';
            $params = [':q1' => $like, ':q2' => $like, ':q3' => $like];
        }

        $sql .= ' ORDER BY diterbitkan_pada DESC, id DESC';

        $statement = Database::connection()->prepare($sql);

        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            $this->selectColumns() . ' WHERE id = :id LIMIT 1'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $berita = $statement->fetch();

        return $berita === false ? null : $berita;
    }

    /**
     * @param array{judul: string, slug: string, gambar: ?string, kategori: string, ringkasan: string, isi: string, penulis: string, diterbitkan_pada: string} $data
     */
    public function create(array $data): int
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO berita (judul, slug, gambar, kategori, ringkasan, isi, penulis, diterbitkan_pada)
             VALUES (:judul, :slug, :gambar, :kategori, :ringkasan, :isi, :penulis, :diterbitkan_pada)'
        );

        $this->bindData($statement, $data);
        $statement->execute();

        return (int) Database::connection()->lastInsertId();
    }

    /**
     * @param array{judul: string, slug: string, gambar: ?string, kategori: string, ringkasan: string, isi: string, penulis: string, diterbitkan_pada: string} $data
     */
    public function update(int $id, array $data): bool
    {
        $statement = Database::connection()->prepare(
            'UPDATE berita
             SET judul = :judul,
                 slug = :slug,
                 gambar = :gambar,
                 kategori = :kategori,
                 ringkasan = :ringkasan,
                 isi = :isi,
                 penulis = :penulis,
                 diterbitkan_pada = :diterbitkan_pada
             WHERE id = :id'
        );

        $this->bindData($statement, $data);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $statement = Database::connection()->prepare('DELETE FROM berita WHERE id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM berita')->fetchColumn();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function recent(int $limit = 5): array
    {
        return $this->latest($limit);
    }

    /**
     * @return array<int, string>
     */
    public function kategoriList(): array
    {
        $rows = Database::connection()
            ->query('SELECT DISTINCT kategori FROM berita ORDER BY kategori ASC')
            ->fetchAll();

        return array_map(static fn (array $row): string => (string) $row['kategori'], $rows);
    }

    public function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $base = trim($base) !== '' ? trim($base) : 'berita';
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
        $sql = 'SELECT COUNT(*) FROM berita WHERE slug = :slug';

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
     * @param array{judul: string, slug: string, gambar: ?string, kategori: string, ringkasan: string, isi: string, penulis: string, diterbitkan_pada: string} $data
     */
    private function bindData(\PDOStatement $statement, array $data): void
    {
        $statement->bindValue(':judul', $data['judul']);
        $statement->bindValue(':slug', $data['slug']);
        $statement->bindValue(':gambar', $data['gambar']);
        $statement->bindValue(':kategori', $data['kategori']);
        $statement->bindValue(':ringkasan', $data['ringkasan']);
        $statement->bindValue(':isi', $data['isi']);
        $statement->bindValue(':penulis', $data['penulis']);
        $statement->bindValue(':diterbitkan_pada', $data['diterbitkan_pada']);
    }

    private function selectColumns(): string
    {
        return 'SELECT id, judul, slug, gambar, kategori, ringkasan, isi, penulis, diterbitkan_pada FROM berita';
    }
}
