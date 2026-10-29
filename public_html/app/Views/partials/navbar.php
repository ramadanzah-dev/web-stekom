<?php

declare(strict_types=1);

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$logo = gambar_url($site['logo'] ?? null);

$navLinks = [
    ['label' => 'Beranda', 'href' => url('/'), 'active' => $currentPath === '/'],
    ['label' => 'Divisi', 'href' => url('/#divisi'), 'active' => false],
    ['label' => 'Agenda', 'href' => url('/#agenda'), 'active' => false],
    ['label' => 'Kabar', 'href' => url('/berita'), 'active' => str_starts_with($currentPath, '/berita')],
    ['label' => 'Organisasi', 'href' => url('/organisasi'), 'active' => str_starts_with($currentPath, '/organisasi')],
];

$oprecAktif = (bool) config('oprec_aktif', false);
$gabungUrl = $oprecAktif ? url((string) config('oprec_link', '/berita')) : null;
?>
<header class="sticky top-0 z-50 bg-cobalt text-bone">
    <div class="mx-auto flex h-16 max-w-[1600px] items-center justify-between gap-4 px-4 sm:h-20 sm:px-6 lg:px-8">
        <a href="<?= url('/') ?>" class="group flex min-w-0 items-center gap-3" aria-label="<?= e($site['name'] . ' — ' . $site['full_name']) ?>">
            <?php if ($logo !== null): ?>
                <img
                    src="<?= e($logo) ?>"
                    alt="Logo <?= e($site['name']) ?>"
                    width="40"
                    height="40"
                    class="h-10 w-10 shrink-0 transition group-hover:scale-105"
                >
            <?php endif; ?>
            <span class="truncate font-display text-xl font-black uppercase tracking-[-0.03em]"><?= e($site['name'] ?? 'STEKOM') ?></span>
        </a>

        <nav class="hidden lg:flex items-center gap-1">
            <?php foreach ($navLinks as $link): ?>
                <a
                    href="<?= e($link['href']) ?>"
                    class="px-4 py-2 text-sm font-bold uppercase tracking-wider transition <?= $link['active'] ? 'text-gold' : 'text-bone hover:text-gold' ?>"
                >
                    <?= e($link['label']) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="flex items-center gap-3">
            <?php if ($gabungUrl !== null): ?>
                <a href="<?= e($gabungUrl) ?>" class="press hidden sm:flex items-center gap-2 bg-gold px-5 py-2.5 text-sm font-bold text-ink hover:bg-bone">
                    Gabung
                    <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                </a>
            <?php endif; ?>
            <button class="lg:hidden p-2" aria-label="Menu" data-menu-toggle>
                <svg class="h-6 w-6"><use href="#i-menu"/></svg>
            </button>
        </div>
    </div>
</header>
