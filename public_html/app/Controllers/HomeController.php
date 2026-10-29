<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Kegiatan;
use App\Models\Pengurus;

final class HomeController extends Controller
{
    public function index(): void
    {
        $berita = new Berita();
        $divisi = new Divisi();
        $pengurus = new Pengurus();
        $kegiatanModel = new Kegiatan();

        $daftarDivisi = $divisi->withKoordinator((string) config('site.periode'));

        foreach ($daftarDivisi as $index => $item) {
            $daftarDivisi[$index]['minat'] = trim((string) ($item['tagline'] ?? '')) !== '' 
                ? $item['tagline'] 
                : ('Coba ' . $item['nama']);
        }

        $core = $pengurus->core((string) config('site.periode'));

        $rawMarquee = (string) config('site_marquee', 'Ngoprek bareng, Bikin karya, Buka peluang, IIB Darmajaya, Sistem Komputer, Teknik Komputer');
        $marquee = array_filter(array_map('trim', explode(',', $rawMarquee)));
        if ($marquee === []) {
            $marquee = ['Ngoprek bareng', 'Bikin karya', 'Buka peluang'];
        }

        $rawKegiatan = $kegiatanModel->upcoming(10);
        $kegiatanList = [];

        foreach ($rawKegiatan as $item) {
            $timestamp = strtotime((string) $item['tanggal_mulai']);
            $kegiatanList[] = [
                'datetime' => (string) $item['tanggal_mulai'],
                'day' => $timestamp !== false ? date('d', $timestamp) : '01',
                'month' => $timestamp !== false ? date('M', $timestamp) : 'Nov',
                'category' => (string) ($item['kategori'] ?? 'Agenda'),
                'title' => (string) $item['judul'],
                'description' => (string) ($item['deskripsi'] ?? ''),
                'location' => (string) ($item['lokasi'] ?? ''),
            ];
        }

        if ($kegiatanList === []) {
            $kegiatanList = [
                [
                    'datetime' => date('Y-m-d'),
                    'day' => date('d'),
                    'month' => date('M'),
                    'category' => 'Agenda',
                    'title' => 'Belum ada agenda terdekat',
                    'description' => 'Pantau terus kabar dan kegiatan terbaru dari HIMA Sistem Komputer.',
                    'location' => 'Kampus',
                ]
            ];
        }

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
            'kegiatan' => $kegiatanList,
            'marquee' => array_values($marquee),
        ]);
    }
}
