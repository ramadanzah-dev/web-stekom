<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Divisi;
use App\Models\Pengurus;

final class OrganisasiController extends Controller
{
    public function index(): void
    {
        $core = (new Pengurus())->core((string) config('site.periode'));
        $divisi = (new Divisi())->withMembers((string) config('site.periode'));
        $pastPengurus = (new Pengurus())->pastByPeriod((string) config('site.periode'));

        $this->view('pages/organisasi/index', [
            'title' => 'Organisasi HIMA',
            'description' => 'Profil, visi, misi, nilai, dan struktur pengurus Himpunan Mahasiswa Sistem Komputer STEKOM.',
            'visi' => 'Menjadi himpunan mahasiswa Sistem Komputer yang adaptif, kolaboratif, dan berdampak—tempat setiap anggota tumbuh menjadi talenta teknologi yang berintegritas.',
            'misi' => [
                'Menyediakan ruang belajar yang terbuka dan relevan bagi seluruh mahasiswa Sistem Komputer.',
                'Mendorong lahirnya karya nyata melalui proyek, kompetisi, dan kolaborasi lintas disiplin.',
                'Membangun budaya organisasi yang sehat, inklusif, dan saling menghargai.',
                'Menjadi jembatan antara mahasiswa, alumni, dan industri teknologi.',
            ],
            'nilai' => [
                [
                    'title' => 'Kolaborasi',
                    'description' => 'Kami percaya karya terbaik lahir dari tim yang saling melengkapi, bukan dari satu orang yang bekerja sendiri.',
                ],
                [
                    'title' => 'Integritas',
                    'description' => 'Kami menjaga amanah, transparansi, dan etika dalam setiap keputusan serta kegiatan himpunan.',
                ],
                [
                    'title' => 'Dampak',
                    'description' => 'Setiap program diarahkan untuk memberi manfaat nyata bagi anggota, kampus, dan masyarakat.',
                ],
            ],
            'sejarah' => [
                ['tahun' => '2017', 'teks' => 'STEKOM berdiri sebagai wadah resmi mahasiswa Sistem Komputer.'],
                ['tahun' => '2020', 'teks' => 'Kelas daring pertama dibuka untuk menjaga tradisi belajar lintas angkatan.'],
                ['tahun' => '2023', 'teks' => 'Kolaborasi proyek dengan komunitas dan alumni mulai tumbuh.'],
                ['tahun' => '2026', 'teks' => 'Enam divisi belajar dan lebih dari 180 anggota aktif berkarya bersama.'],
            ],
            'core' => $core,
            'divisi' => $divisi,
            'pastPengurus' => $pastPengurus,
            'stats' => [
                ['value' => '2017', 'label' => 'Berdiri'],
                ['value' => (string) count($divisi), 'label' => 'Divisi'],
                ['value' => '180+', 'label' => 'Anggota'],
                ['value' => (string) (count($core) + count($divisi)), 'label' => 'Pengurus'],
            ],
        ]);
    }
}
