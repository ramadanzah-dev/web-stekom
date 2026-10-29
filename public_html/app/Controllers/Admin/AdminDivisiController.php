<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Divisi;

final class AdminDivisiController extends BaseAdminController
{
    public function index(): void
    {
        $this->adminView('divisi/index', [
            'title' => 'Kelola Divisi',
            'items' => (new Divisi())->all(),
        ]);
    }

    public function create(): void
    {
        $this->adminView('divisi/form', $this->formData(null, [
            'nama' => '',
            'slug' => '',
            'tagline' => '',
            'deskripsi' => '',
        ]));
    }

    public function store(): void
    {
        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST, null);

        if ($errors !== []) {
            $this->adminView('divisi/form', $this->formData(null, $this->valuesFromPost(), $errors));

            return;
        }

        (new Divisi())->create($data);

        $this->flash('success', 'Divisi baru berhasil ditambahkan.');
        $this->redirect('/admin/divisi');
    }

    public function edit(string $id): void
    {
        $divisi = (new Divisi())->find((int) $id);

        if ($divisi === null) {
            $this->abortAdmin(404, 'Divisi yang kamu cari tidak ditemukan.');
        }

        $this->adminView('divisi/form', $this->formData($divisi, $divisi));
    }

    public function update(string $id): void
    {
        $divisi = (new Divisi())->find((int) $id);

        if ($divisi === null) {
            $this->abortAdmin(404, 'Divisi yang kamu cari tidak ditemukan.');
        }

        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST, (int) $id);

        if ($errors !== []) {
            $this->adminView('divisi/form', $this->formData($divisi, $this->valuesFromPost(), $errors));

            return;
        }

        (new Divisi())->update((int) $id, $data);

        $this->flash('success', 'Divisi berhasil diperbarui.');
        $this->redirect('/admin/divisi');
    }

    public function destroy(string $id): void
    {
        $this->guardCsrf();

        $divisi = (new Divisi())->find((int) $id);

        if ($divisi === null) {
            $this->abortAdmin(404, 'Divisi yang ingin dihapus tidak ditemukan.');
        }

        (new Divisi())->delete((int) $id);

        $this->flash('success', 'Divisi “' . $divisi['nama'] . '” sudah dihapus. Pengurus terkait kini tanpa divisi.');
        $this->redirect('/admin/divisi');
    }

    public function bulkDestroy(): void
    {
        $this->guardCsrf();

        $ids = $_POST['ids'] ?? [];

        if (!is_array($ids) || $ids === []) {
            $this->flash('error', 'Tidak ada divisi yang dipilih.');
            $this->redirect('/admin/divisi');

            return;
        }

        $cleanIds = array_map('intval', array_filter($ids, static fn ($id) => filter_var($id, FILTER_VALIDATE_INT) !== false));

        if ($cleanIds === []) {
            $this->flash('error', 'Pilihan divisi tidak valid.');
            $this->redirect('/admin/divisi');

            return;
        }

        $model = new Divisi();
        $items = $model->findMany($cleanIds);
        $model->deleteMany($cleanIds);

        $count = count($items);
        $this->flash('success', "Berhasil menghapus {$count} divisi. Pengurus terkait kini tanpa divisi.");
        $this->redirect('/admin/divisi');
    }

    /**
     * @param array<string, mixed> $input
     * @return array{0: array{nama: string, slug: string, tagline: string, deskripsi: string}, 1: array<string, string>}
     */
    private function validated(array $input, ?int $ignoreId): array
    {
        $errors = [];

        $nama = trim((string) ($input['nama'] ?? ''));
        $slugInput = trim((string) ($input['slug'] ?? ''));
        $tagline = trim((string) ($input['tagline'] ?? ''));
        $deskripsi = trim((string) ($input['deskripsi'] ?? ''));

        if ($nama === '') {
            $errors['nama'] = 'Nama divisi wajib diisi.';
        } elseif (mb_strlen($nama) > 100) {
            $errors['nama'] = 'Nama divisi maksimal 100 karakter.';
        }

        if (mb_strlen($tagline) > 255) {
            $errors['tagline'] = 'Tagline maksimal 255 karakter.';
        }

        if ($deskripsi === '') {
            $errors['deskripsi'] = 'Deskripsi wajib diisi.';
        }

        $baseSlug = slugify($slugInput !== '' ? $slugInput : $nama);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'divisi';

        return [
            [
                'nama' => $nama,
                'slug' => (new Divisi())->uniqueSlug($baseSlug, $ignoreId),
                'tagline' => $tagline,
                'deskripsi' => $deskripsi,
            ],
            $errors,
        ];
    }

    /**
     * @return array<string, string>
     */
    private function valuesFromPost(): array
    {
        return [
            'nama' => $this->input('nama'),
            'slug' => $this->input('slug'),
            'tagline' => $this->input('tagline'),
            'deskripsi' => $this->input('deskripsi'),
        ];
    }

    /**
     * @param array<string, mixed>|null $divisi
     * @param array<string, mixed> $values
     * @param array<string, string> $errors
     * @return array<string, mixed>
     */
    private function formData(?array $divisi, array $values, array $errors = []): array
    {
        return [
            'title' => $divisi === null ? 'Tambah Divisi' : 'Edit Divisi',
            'mode' => $divisi === null ? 'create' : 'edit',
            'action' => $divisi === null ? url('/admin/divisi') : url('/admin/divisi/' . $divisi['id']),
            'divisi' => $values,
            'errors' => $errors,
            'isEdit' => $divisi !== null,
        ];
    }
}
