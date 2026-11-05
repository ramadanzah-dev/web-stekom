<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Pengurus;

final class HomeController extends Controller
{
    public function index(): void
    {
        $berita = new Berita();
        $divisi = new Divisi();
        $pengurus = new Pengurus();

        $daftarDivisi = $divisi->withKoordinator((string) config('site.periode'));
        $minat = [
            'web-product' => 'Bikin web & produk digital',
            'mobile-ui-ux' => 'Rancang aplikasi & antarmuka',
            'data-ai' => 'Ubah data jadi keputusan',
            'keamanan-siber' => 'Amankan sistem & jaringan',
            'embedded-iot' => 'Rakit perangkat & sensor',
            'media-komunikasi' => 'Bikin konten & cerita',
        ];

        foreach ($daftarDivisi as $index => $item) {
            $daftarDivisi[$index]['minat'] = $minat[$item['slug']] ?? ('Coba ' . $item['nama']);
        }

        $core = $pengurus->core((string) config('site.periode'));

        $this->view('pages/home/index', [
            'title' => null,
            'description' => config('site.description'),
            'beritaTerbaru' => $berita->latest(3),
            'divisi' => $daftarDivisi,
            'core' => $core,
            'ketua' => $core[0] ?? null,
            'stats' => [
                ['value' => (string) count($daftarDivisi), 'label' => 'Divisi belajar'],
                ['value' => (string) $pengurus->count(), 'label' => 'Pengurus aktif'],
                ['value' => (string) $berita->count(), 'label' => 'Kabar terbit'],
                ['value' => (string) config('site.periode'), 'label' => 'Periode berjalan'],
            ],
            'kegiatan' => [
                [
                    'datetime' => '2026-11-08',
                    'day' => '08',
                    'month' => 'Nov',
                    'category' => 'Workshop',
                    'title' => 'Workshop Embedded',
                    'description' => 'Dari sensor ke dashboard: praktik langsung merakit perangkat IoT.',
                    'location' => 'Lab Hardware',
                ],
                [
                    'datetime' => '2026-11-12',
                    'day' => '12',
                    'month' => 'Nov',
                    'category' => 'Expo',
                    'title' => 'Sistem Komputer Expo',
                    'description' => 'Pameran karya mahasiswa, talkshow industri, dan jejaring alumni.',
                    'location' => 'Auditorium Kampus',
                ],
                [
                    'datetime' => '2026-11-30',
                    'day' => '30',
                    'month' => 'Nov',
                    'category' => 'Pendaftaran',
                    'title' => 'Batas Open Recruitment',
                    'description' => 'Kesempatan terakhir buat gabung angkatan 2026/2027.',
                    'location' => 'Online',
                ],
            ],
            'marquee' => [
                'Ngoprek bareng',
                'Bikin karya',
                'Buka peluang',
                'IIB Darmajaya',
                'Sistem Komputer',
                'Teknik Komputer',
            ],
        ]);
    }
}
