<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Upload;
use App\Models\Berita;

final class AdminBeritaController extends BaseAdminController
{
    public function index(): void
    {
        $q = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
        $berita = new Berita();

        $this->adminView('berita/index', [
            'title' => 'Kelola Berita',
            'items' => $berita->adminList($q),
            'q' => $q,
            'total' => $berita->count(),
        ]);
    }

    public function create(): void
    {
        $this->adminView('berita/form', $this->formData(null, [
            'judul' => '',
            'slug' => '',
            'kategori' => '',
            'ringkasan' => '',
            'isi' => '',
            'penulis' => 'Humas STEKOM',
            'diterbitkan_pada' => date('Y-m-d\TH:i'),
            'gambar' => null,
        ]));
    }

    public function store(): void
    {
        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST, null);
        $upload = Upload::image($_FILES['gambar'] ?? null, 'berita');

        if (isset($upload['error'])) {
            $errors['gambar'] = $upload['error'];
        }

        if ($errors !== []) {
            if (isset($upload['path'])) {
                Upload::delete($upload['path']);
            }

            $values = $this->valuesFromPost();
            $this->adminView('berita/form', $this->formData(null, $values, $errors));

            return;
        }

        $data['gambar'] = $upload['path'] ?? null;

        (new Berita())->create($data);

        $this->flash('success', 'Berita baru berhasil ditambahkan.');
        $this->redirect('/admin/berita');
    }

    public function edit(string $id): void
    {
        $berita = (new Berita())->find((int) $id);

        if ($berita === null) {
            $this->abortAdmin(404, 'Berita yang kamu cari tidak ditemukan.');
        }

        $values = $berita;
        $values['diterbitkan_pada'] = date('Y-m-d\TH:i', strtotime((string) $berita['diterbitkan_pada']));

        $this->adminView('berita/form', $this->formData($berita, $values));
    }

    public function update(string $id): void
    {
        $berita = (new Berita())->find((int) $id);

        if ($berita === null) {
            $this->abortAdmin(404, 'Berita yang kamu cari tidak ditemukan.');
        }

        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST, (int) $id);
        $upload = Upload::image($_FILES['gambar'] ?? null, 'berita');

        if (isset($upload['error'])) {
            $errors['gambar'] = $upload['error'];
        }

        if ($errors !== []) {
            if (isset($upload['path'])) {
                Upload::delete($upload['path']);
            }

            $values = $this->valuesFromPost();
            $values['gambar'] = (string) $berita['gambar'];
            $values['diterbitkan_pada'] = $this->input('diterbitkan_pada');
            $this->adminView('berita/form', $this->formData($berita, $values, $errors));

            return;
        }

        $data['gambar'] = $upload['path'] ?? $berita['gambar'];

        (new Berita())->update((int) $id, $data);

        if (isset($upload['path'])) {
            Upload::delete((string) $berita['gambar']);
        }

        $this->flash('success', 'Perubahan berita berhasil disimpan.');
        $this->redirect('/admin/berita');
    }

    public function destroy(string $id): void
    {
        $this->guardCsrf();

        $berita = (new Berita())->find((int) $id);

        if ($berita === null) {
            $this->abortAdmin(404, 'Berita yang ingin dihapus tidak ditemukan.');
        }

        (new Berita())->delete((int) $id);
        Upload::delete((string) $berita['gambar']);

        $this->flash('success', 'Berita “' . $berita['judul'] . '” sudah dihapus.');
        $this->redirect('/admin/berita');
    }

    /**
     * @param array<string, mixed> $input
     * @return array{0: array{judul: string, slug: string, kategori: string, ringkasan: string, isi: string, penulis: string, diterbitkan_pada: string}, 1: array<string, string>}
     */
    private function validated(array $input, ?int $ignoreId): array
    {
        $model = new Berita();
        $errors = [];

        $judul = trim((string) ($input['judul'] ?? ''));
        $kategori = trim((string) ($input['kategori'] ?? ''));
        $ringkasan = trim((string) ($input['ringkasan'] ?? ''));
        $isi = trim((string) ($input['isi'] ?? ''));
        $penulis = trim((string) ($input['penulis'] ?? ''));
        $slugInput = trim((string) ($input['slug'] ?? ''));
        $tanggalInput = trim((string) ($input['diterbitkan_pada'] ?? ''));

        if ($judul === '') {
            $errors['judul'] = 'Judul wajib diisi.';
        } elseif (mb_strlen($judul) > 180) {
            $errors['judul'] = 'Judul maksimal 180 karakter.';
        }

        if ($kategori === '') {
            $errors['kategori'] = 'Kategori wajib diisi.';
        } elseif (mb_strlen($kategori) > 50) {
            $errors['kategori'] = 'Kategori maksimal 50 karakter.';
        }

        if ($ringkasan === '') {
            $errors['ringkasan'] = 'Ringkasan wajib diisi.';
        } elseif (mb_strlen($ringkasan) > 320) {
            $errors['ringkasan'] = 'Ringkasan maksimal 320 karakter.';
        }

        if ($isi === '') {
            $errors['isi'] = 'Isi berita wajib diisi.';
        }

        if ($penulis === '') {
            $errors['penulis'] = 'Penulis wajib diisi.';
        } elseif (mb_strlen($penulis) > 100) {
            $errors['penulis'] = 'Nama penulis maksimal 100 karakter.';
        }

        $tanggal = $tanggalInput !== '' ? date_create($tanggalInput) : false;

        if ($tanggal === false) {
            $errors['diterbitkan_pada'] = 'Tanggal terbit tidak valid.';
        }

        $baseSlug = slugify($slugInput !== '' ? $slugInput : $judul);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'berita';

        return [
            [
                'judul' => $judul,
                'slug' => $model->uniqueSlug($baseSlug, $ignoreId),
                'kategori' => $kategori,
                'ringkasan' => $ringkasan,
                'isi' => $isi,
                'penulis' => $penulis,
                'diterbitkan_pada' => $tanggal !== false ? $tanggal->format('Y-m-d H:i:s') : '',
            ],
            $errors,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function valuesFromPost(): array
    {
        return [
            'judul' => $this->input('judul'),
            'slug' => $this->input('slug'),
            'kategori' => $this->input('kategori'),
            'ringkasan' => $this->input('ringkasan'),
            'isi' => $this->input('isi'),
            'penulis' => $this->input('penulis'),
            'diterbitkan_pada' => $this->input('diterbitkan_pada'),
            'gambar' => $this->input('gambar_lama') !== '' ? $this->input('gambar_lama') : null,
        ];
    }

    /**
     * @param array<string, mixed>|null $berita
     * @param array<string, mixed> $values
     * @param array<string, string> $errors
     * @return array<string, mixed>
     */
    private function formData(?array $berita, array $values, array $errors = []): array
    {
        return [
            'title' => $berita === null ? 'Tambah Berita' : 'Edit Berita',
            'mode' => $berita === null ? 'create' : 'edit',
            'action' => $berita === null ? url('/admin/berita') : url('/admin/berita/' . $berita['id']),
            'berita' => $values,
            'errors' => $errors,
            'kategoriList' => (new Berita())->kategoriList(),
            'isEdit' => $berita !== null,
        ];
    }
}
