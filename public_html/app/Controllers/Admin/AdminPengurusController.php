<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Upload;
use App\Models\Divisi;
use App\Models\Pengurus;

final class AdminPengurusController extends BaseAdminController
{
    public function index(): void
    {
        $this->adminView('pengurus/index', [
            'title' => 'Kelola Pengurus',
            'items' => (new Pengurus())->adminList(),
        ]);
    }

    public function create(): void
    {
        $this->adminView('pengurus/form', $this->formData(null, [
            'nama' => '',
            'foto' => null,
            'jabatan' => '',
            'divisi_id' => '',
            'periode' => (string) config('site.periode'),
            'urutan' => '0',
            'aktif' => '1',
        ]));
    }

    public function store(): void
    {
        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST);
        $upload = Upload::image($_FILES['foto'] ?? null, 'pengurus');

        if (isset($upload['error'])) {
            $errors['foto'] = $upload['error'];
        }

        if ($errors !== []) {
            if (isset($upload['path'])) {
                Upload::delete($upload['path']);
            }

            $this->adminView('pengurus/form', $this->formData(null, $this->valuesFromPost(), $errors));

            return;
        }

        $data['foto'] = $upload['path'] ?? null;

        (new Pengurus())->create($data);

        $this->flash('success', 'Pengurus baru berhasil ditambahkan.');
        $this->redirect('/admin/pengurus');
    }

    public function edit(string $id): void
    {
        $pengurus = (new Pengurus())->find((int) $id);

        if ($pengurus === null) {
            $this->abortAdmin(404, 'Data pengurus tidak ditemukan.');
        }

        $this->adminView('pengurus/form', $this->formData($pengurus, $pengurus));
    }

    public function update(string $id): void
    {
        $pengurus = (new Pengurus())->find((int) $id);

        if ($pengurus === null) {
            $this->abortAdmin(404, 'Data pengurus tidak ditemukan.');
        }

        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST);
        $upload = Upload::image($_FILES['foto'] ?? null, 'pengurus');

        if (isset($upload['error'])) {
            $errors['foto'] = $upload['error'];
        }

        if ($errors !== []) {
            if (isset($upload['path'])) {
                Upload::delete($upload['path']);
            }

            $values = $this->valuesFromPost();
            $values['foto'] = (string) $pengurus['foto'];
            $this->adminView('pengurus/form', $this->formData($pengurus, $values, $errors));

            return;
        }

        $data['foto'] = $upload['path'] ?? $pengurus['foto'];

        (new Pengurus())->update((int) $id, $data);

        if (isset($upload['path'])) {
            Upload::delete((string) $pengurus['foto']);
        }

        $this->flash('success', 'Data pengurus berhasil diperbarui.');
        $this->redirect('/admin/pengurus');
    }

    public function destroy(string $id): void
    {
        $this->guardCsrf();

        $pengurus = (new Pengurus())->find((int) $id);

        if ($pengurus === null) {
            $this->abortAdmin(404, 'Data pengurus tidak ditemukan.');
        }

        (new Pengurus())->delete((int) $id);
        Upload::delete((string) $pengurus['foto']);

        $this->flash('success', 'Data pengurus “' . $pengurus['nama'] . '” sudah dihapus.');
        $this->redirect('/admin/pengurus');
    }

    /**
     * @param array<string, mixed> $input
     * @return array{0: array{nama: string, jabatan: string, divisi_id: ?int, periode: string, urutan: int, aktif: int}, 1: array<string, string>}
     */
    private function validated(array $input): array
    {
        $errors = [];

        $nama = trim((string) ($input['nama'] ?? ''));
        $jabatan = trim((string) ($input['jabatan'] ?? ''));
        $periode = trim((string) ($input['periode'] ?? ''));
        $divisiInput = trim((string) ($input['divisi_id'] ?? ''));
        $urutanInput = trim((string) ($input['urutan'] ?? '0'));
        $aktif = isset($input['aktif']) ? 1 : 0;

        if ($nama === '') {
            $errors['nama'] = 'Nama wajib diisi.';
        } elseif (mb_strlen($nama) > 100) {
            $errors['nama'] = 'Nama maksimal 100 karakter.';
        }

        if ($jabatan === '') {
            $errors['jabatan'] = 'Jabatan wajib diisi.';
        } elseif (mb_strlen($jabatan) > 80) {
            $errors['jabatan'] = 'Jabatan maksimal 80 karakter.';
        }

        if ($periode === '') {
            $errors['periode'] = 'Periode wajib diisi.';
        } elseif (mb_strlen($periode) > 20) {
            $errors['periode'] = 'Periode maksimal 20 karakter.';
        }

        $urutan = filter_var($urutanInput, FILTER_VALIDATE_INT);

        if ($urutan === false || $urutan < 0 || $urutan > 255) {
            $errors['urutan'] = 'Urutan harus angka 0–255.';
        }

        $divisiId = null;

        if ($divisiInput !== '') {
            $divisiId = filter_var($divisiInput, FILTER_VALIDATE_INT);

            if ($divisiId === false || (new Divisi())->find((int) $divisiId) === null) {
                $errors['divisi_id'] = 'Divisi yang dipilih tidak valid.';
                $divisiId = null;
            }
        }

        return [
            [
                'nama' => $nama,
                'jabatan' => $jabatan,
                'divisi_id' => $divisiId === false ? null : $divisiId,
                'periode' => $periode,
                'urutan' => $urutan === false ? 0 : $urutan,
                'aktif' => $aktif,
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
            'nama' => $this->input('nama'),
            'foto' => null,
            'jabatan' => $this->input('jabatan'),
            'divisi_id' => $this->input('divisi_id'),
            'periode' => $this->input('periode'),
            'urutan' => $this->input('urutan', '0'),
            'aktif' => isset($_POST['aktif']) ? '1' : '0',
        ];
    }

    /**
     * @param array<string, mixed>|null $pengurus
     * @param array<string, mixed> $values
     * @param array<string, string> $errors
     * @return array<string, mixed>
     */
    private function formData(?array $pengurus, array $values, array $errors = []): array
    {
        return [
            'title' => $pengurus === null ? 'Tambah Pengurus' : 'Edit Pengurus',
            'mode' => $pengurus === null ? 'create' : 'edit',
            'action' => $pengurus === null ? url('/admin/pengurus') : url('/admin/pengurus/' . $pengurus['id']),
            'pengurus' => $values,
            'errors' => $errors,
            'divisiList' => (new Divisi())->all(),
            'isEdit' => $pengurus !== null,
        ];
    }
}
