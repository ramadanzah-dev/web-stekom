<?php

declare(strict_types=1);

return [
    /*
     * Kosongkan untuk domain root, atau isi mis. https://stekom.example
     * saat aplikasi dipasang di subfolder.
     */
    'base_url' => getenv('APP_URL') !== false ? rtrim((string) getenv('APP_URL'), '/') : '',

    'timezone' => 'Asia/Jakarta',

    'site' => [
        'name' => 'STEKOM',
        'full_name' => 'Himpunan Mahasiswa Sistem Komputer',
        'short_name' => 'HIMASI',
        'tagline' => 'Ruang tumbuh mahasiswa Sistem Komputer.',
        'description' => 'STEKOM adalah himpunan mahasiswa Sistem Komputer: wadah kolaborasi, karya, dan pengembangan diri di bidang teknologi.',
        'periode' => '2026/2027',
        'email' => 'halo@stekom.id',
        'instagram' => 'https://www.instagram.com/stekom',
        'location' => 'Kampus Sistem Komputer',
        'logo' => '',
        'footer_text' => 'Belajar, berkarya, dan bertumbuh bersama.',
        'footer_note' => 'Dibuat dengan rapi.',
    ],
];
