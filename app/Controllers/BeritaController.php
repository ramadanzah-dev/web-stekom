<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Berita;

final class BeritaController extends Controller
{
    public function index(): void
    {
        $berita = new Berita();
        $featured = $berita->latest(1)[0] ?? null;

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $page = is_int($page) && $page > 0 ? $page : 1;

        $pagination = $berita->paginate($page, 9, $featured !== null ? (int) $featured['id'] : null);

        $this->view('pages/berita/index', [
            'title' => 'Berita',
            'description' => 'Kabar terbaru, prestasi, kegiatan, dan gagasan dari Himpunan Mahasiswa Sistem Komputer STEKOM.',
            'featured' => $featured,
            'pagination' => $pagination,
            'ogImage' => $featured !== null ? gambar_url($featured['gambar'] ?? null) : null,
        ]);
    }

    public function show(string $slug): void
    {
        $berita = new Berita();
        $artikel = $berita->findBySlug($slug);

        if ($artikel === null) {
            $this->abort(404);
        }

        $lainnya = $berita->latest(3, (int) $artikel['id']);

        $this->view('pages/berita/show', [
            'title' => $artikel['judul'],
            'description' => $artikel['ringkasan'],
            'artikel' => $artikel,
            'lainnya' => $lainnya,
            'ogImage' => gambar_url($artikel['gambar'] ?? null),
        ]);
    }
}
