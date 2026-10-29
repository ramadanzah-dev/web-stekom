<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Kegiatan;

final class AdminKegiatanController extends BaseAdminController
{
    public function index(): void
    {
        $this->adminView('kegiatan/index', [
            'title' => 'Kelola Kegiatan',
            'items' => (new Kegiatan())->all(),
        ]);
    }

    public function create(): void
    {
        $this->adminView('kegiatan/form', $this->formData(null, [
            'judul' => '',
            'kategori' => 'Agenda',
            'deskripsi' => '',
            'lokasi' => '',
            'tanggal_mulai' => date('Y-m-d'),
            'aktif' => 1,
        ]));
    }

    public function store(): void
    {
        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST);

        if ($errors !== []) {
            $this->adminView('kegiatan/form', $this->formData(null, $this->valuesFromPost(), $errors));

            return;
        }

        (new Kegiatan())->create($data);

        $this->flash('success', 'Kegiatan baru berhasil ditambahkan.');
        $this->redirect('/admin/kegiatan');
    }

    public function edit(string $id): void
    {
        $kegiatan = (new Kegiatan())->find((int) $id);

        if ($kegiatan === null) {
            $this->abortAdmin(404, 'Kegiatan yang kamu cari tidak ditemukan.');
        }

        $this->adminView('kegiatan/form', $this->formData($kegiatan, $kegiatan));
    }

    public function update(string $id): void
    {
        $kegiatan = (new Kegiatan())->find((int) $id);

        if ($kegiatan === null) {
            $this->abortAdmin(404, 'Kegiatan yang kamu cari tidak ditemukan.');
        }

        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST);

        if ($errors !== []) {
            $this->adminView('kegiatan/form', $this->formData($kegiatan, $this->valuesFromPost(), $errors));

            return;
        }

        (new Kegiatan())->update((int) $id, $data);

        $this->flash('success', 'Kegiatan berhasil diperbarui.');
        $this->redirect('/admin/kegiatan');
    }

    public function destroy(string $id): void
    {
        $this->guardCsrf();

        $kegiatan = (new Kegiatan())->find((int) $id);

        if ($kegiatan === null) {
            $this->abortAdmin(404, 'Kegiatan yang ingin dihapus tidak ditemukan.');
        }

        (new Kegiatan())->delete((int) $id);

        $this->flash('success', 'Kegiatan “' . $kegiatan['judul'] . '” sudah dihapus.');
        $this->redirect('/admin/kegiatan');
    }

    /**
     * @param array<string, mixed> $input
     * @return array{0: array{judul: string, kategori: string, deskripsi: string, lokasi: string, tanggal_mulai: string, aktif: int}, 1: array<string, string>}
     */
    private function validated(array $input): array
    {
        $errors = [];

        $judul = trim((string) ($input['judul'] ?? ''));
        $kategori = trim((string) ($input['kategori'] ?? 'Agenda'));
        $deskripsi = trim((string) ($input['deskripsi'] ?? ''));
        $lokasi = trim((string) ($input['lokasi'] ?? ''));
        $tanggalMulai = trim((string) ($input['tanggal_mulai'] ?? ''));
        $aktif = isset($input['aktif']) && $input['aktif'] === '1' ? 1 : 0;

        if ($judul === '') {
            $errors['judul'] = 'Judul kegiatan wajib diisi.';
        } elseif (mb_strlen($judul) > 150) {
            $errors['judul'] = 'Judul maksimal 150 karakter.';
        }

        if ($kategori === '') {
            $kategori = 'Agenda';
        } elseif (mb_strlen($kategori) > 50) {
            $errors['kategori'] = 'Kategori maksimal 50 karakter.';
        }

        if ($tanggalMulai === '') {
            $errors['tanggal_mulai'] = 'Tanggal mulai wajib diisi.';
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalMulai)) {
            $errors['tanggal_mulai'] = 'Format tanggal tidak valid.';
        }

        return [
            [
                'judul' => $judul,
                'kategori' => $kategori,
                'deskripsi' => $deskripsi,
                'lokasi' => $lokasi,
                'tanggal_mulai' => $tanggalMulai,
                'aktif' => $aktif,
            ],
            $errors,
        ];
    }

    /**
     * @return array<string, string|int>
     */
    private function valuesFromPost(): array
    {
        return [
            'judul' => $this->input('judul'),
            'kategori' => $this->input('kategori'),
            'deskripsi' => $this->input('deskripsi'),
            'lokasi' => $this->input('lokasi'),
            'tanggal_mulai' => $this->input('tanggal_mulai'),
            'aktif' => isset($_POST['aktif']) && $_POST['aktif'] === '1' ? 1 : 0,
        ];
    }

    /**
     * @param array<string, mixed>|null $kegiatan
     * @param array<string, mixed> $values
     * @param array<string, string> $errors
     * @return array<string, mixed>
     */
    private function formData(?array $kegiatan, array $values, array $errors = []): array
    {
        return [
            'title' => $kegiatan !== null ? 'Edit Kegiatan' : 'Tambah Kegiatan',
            'isEdit' => $kegiatan !== null,
            'kegiatan' => $kegiatan,
            'values' => $values,
            'errors' => $errors,
            'action' => $kegiatan !== null ? url('/admin/kegiatan/' . $kegiatan['id'] . '/edit') : url('/admin/kegiatan/tambah'),
        ];
    }
}
