<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Pengurus;

final class AdminDashboardController extends BaseAdminController
{
    public function index(): void
    {
        $berita = new Berita();
        $pengurus = new Pengurus();
        $divisi = new Divisi();

        $this->adminView('dashboard', [
            'title' => 'Dashboard',
            'stats' => [
                [
                    'label' => 'Berita',
                    'value' => $berita->count(),
                    'href' => url('/admin/berita'),
                    'description' => 'Artikel terpublikasi',
                ],
                [
                    'label' => 'Pengurus',
                    'value' => $pengurus->count(),
                    'href' => url('/admin/pengurus'),
                    'description' => 'Pengurus inti & koordinator',
                ],
                [
                    'label' => 'Divisi',
                    'value' => $divisi->count(),
                    'href' => url('/admin/divisi'),
                    'description' => 'Bidang kegiatan',
                ],
            ],
            'beritaTerbaru' => $berita->recent(5),
            'pengurusTerbaru' => $pengurus->recent(4),
        ]);
    }
}
