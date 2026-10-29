<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Upload;
use App\Models\Pengaturan;
use Throwable;

final class AdminPengaturanController extends BaseAdminController
{
    /**
     * Kolom teks yang dapat diubah beserta batas panjangnya.
     *
     * @var array<string, int>
     */
    private const TEXT_FIELDS = [
        'site_name' => 60,
        'site_full_name' => 120,
        'site_tagline' => 180,
        'site_description' => 400,
        'site_periode' => 20,
        'site_email' => 150,
        'site_instagram' => 200,
        'site_location' => 120,
        'site_footer_text' => 240,
        'site_footer_note' => 160,
        'site_marquee' => 300,
        'oprec_deadline' => 60,
        'oprec_link' => 200,
        'oprec_aktif' => 10,
    ];

    public function index(): void
    {
        $this->renderForm($this->values());
    }

    public function update(): void
    {
        $this->guardCsrf();

        [$data, $errors] = $this->validated($_POST);

        $current = $this->values();
        $logoLama = (string) ($current['site_logo'] ?? '');

        $upload = Upload::image($_FILES['logo'] ?? null, 'pengaturan');

        if (isset($upload['error'])) {
            $errors['logo'] = $upload['error'];
        }

        $logoBaru = $upload['path'] ?? null;
        $hapusLogo = ($_POST['hapus_logo'] ?? '') === '1';

        if ($errors !== []) {
            if ($logoBaru !== null) {
                Upload::delete($logoBaru);
            }

            $values = array_merge($current, $data);
            $values['site_logo'] = $logoLama;

            $this->renderForm($values, $errors);

            return;
        }

        if ($logoBaru !== null) {
            $data['site_logo'] = $logoBaru;
        } elseif ($hapusLogo) {
            $data['site_logo'] = '';
        } else {
            $data['site_logo'] = $logoLama;
        }

        try {
            (new Pengaturan())->save($data);
        } catch (Throwable $error) {
            if ($logoBaru !== null) {
                Upload::delete($logoBaru);
            }

            throw $error;
        }

        if ($logoLama !== '' && ($logoBaru !== null || $hapusLogo)) {
            Upload::delete($logoLama);
        }

        $this->flash('success', 'Pengaturan situs berhasil disimpan.');
        $this->redirect('/admin/pengaturan');
    }

    public function reset(): void
    {
        $this->guardCsrf();

        $values = $this->values();
        (new Pengaturan())->reset();

        if (!empty($values['site_logo'])) {
            Upload::delete((string) $values['site_logo']);
        }

        $this->flash('success', 'Pengaturan dikembalikan ke nilai bawaan.');
        $this->redirect('/admin/pengaturan');
    }

    /**
     * @param array<string, mixed> $input
     * @return array{0: array<string, string>, 1: array<string, string>}
     */
    private function validated(array $input): array
    {
        $data = [];
        $errors = [];

        foreach (self::TEXT_FIELDS as $key => $maxLength) {
            if ($key === 'oprec_aktif') {
                $data[$key] = isset($input[$key]) && $input[$key] === '1' ? '1' : '0';
                continue;
            }

            $value = trim((string) ($input[$key] ?? ''));
            $data[$key] = $value;

            if (mb_strlen($value) > $maxLength) {
                $errors[$key] = 'Maksimal ' . $maxLength . ' karakter.';
            }
        }

        if ($data['site_name'] === '') {
            $errors['site_name'] = 'Nama situs wajib diisi.';
        }

        if ($data['site_full_name'] === '') {
            $errors['site_full_name'] = 'Nama lengkap wajib diisi.';
        }

        if ($data['site_email'] !== '' && filter_var($data['site_email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['site_email'] = 'Format email tidak valid.';
        }

        if ($data['site_instagram'] !== '' && filter_var($data['site_instagram'], FILTER_VALIDATE_URL) === false) {
            $errors['site_instagram'] = 'Tulis URL lengkap, mis. https://www.instagram.com/stekom';
        }

        return [$data, $errors];
    }

    /**
     * Nilai efektif: bawaan config yang ditimpa pengaturan tersimpan.
     *
     * @return array<string, string>
     */
    private function values(): array
    {
        $site = (array) config('site');
        $saved = (new Pengaturan())->all();

        return [
            'site_name' => (string) ($saved['site_name'] ?? $site['name'] ?? ''),
            'site_full_name' => (string) ($saved['site_full_name'] ?? $site['full_name'] ?? ''),
            'site_tagline' => (string) ($saved['site_tagline'] ?? $site['tagline'] ?? ''),
            'site_description' => (string) ($saved['site_description'] ?? $site['description'] ?? ''),
            'site_periode' => (string) ($saved['site_periode'] ?? $site['periode'] ?? ''),
            'site_email' => (string) ($saved['site_email'] ?? $site['email'] ?? ''),
            'site_instagram' => (string) ($saved['site_instagram'] ?? $site['instagram'] ?? ''),
            'site_location' => (string) ($saved['site_location'] ?? $site['location'] ?? ''),
            'site_footer_text' => (string) ($saved['site_footer_text'] ?? $site['footer_text'] ?? ''),
            'site_footer_note' => (string) ($saved['site_footer_note'] ?? $site['footer_note'] ?? ''),
            'site_logo' => (string) ($saved['site_logo'] ?? $site['logo'] ?? ''),
            'site_marquee' => (string) ($saved['site_marquee'] ?? ''),
            'oprec_deadline' => (string) ($saved['oprec_deadline'] ?? ''),
            'oprec_link' => (string) ($saved['oprec_link'] ?? ''),
            'oprec_aktif' => (string) ($saved['oprec_aktif'] ?? '0'),
        ];
    }

    /**
     * @param array<string, string> $values
     * @param array<string, string> $errors
     */
    private function renderForm(array $values, array $errors = []): void
    {
        $this->adminView('pengaturan/index', [
            'title' => 'Pengaturan Situs',
            'values' => $values,
            'errors' => $errors,
        ]);
    }
}
