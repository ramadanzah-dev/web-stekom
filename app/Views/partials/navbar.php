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

$gabungUrl = url('/berita/open-recruitment-anggota-stekom-2026-2027');
?>
<header class="sticky top-0 z-50 bg-cobalt text-bone">
    <div class="mx-auto flex h-16 max-w-[1600px] items-center justify-between gap-4 px-4 sm:h-20 sm:px-6 lg:px-8">
        <a href="<?= url('/') ?>" class="group flex min-w-0 items-center gap-3" aria-label="<?= e($site['name'] . ' — ' . $site['full_name']) ?>">
            <?php if ($logo !== null): ?>
                <img
                    src="<?= e($logo) ?>"
                    alt="Logo <?= e($site['name']) ?> IIB Darmajaya"
                    width="48"
                    height="48"
                    class="h-10 w-10 shrink-0 object-contain sm:h-12 sm:w-12"
                >
            <?php else: ?>
                <span class="grid h-10 w-10 shrink-0 place-items-center bg-gold font-display text-xl font-black text-ink sm:h-12 sm:w-12">
                    S
                </span>
            <?php endif; ?>

            <span class="flex min-w-0 flex-col">
                <span class="truncate font-display text-xl font-black leading-none tracking-[-0.03em] sm:text-2xl">
                    <?= e($site['name']) ?>
                </span>
                <span class="mt-1 truncate text-[13px] font-medium leading-none text-bone/85">
                    IIB Darmajaya
                </span>
            </span>
        </a>

        <nav class="hidden items-center gap-6 lg:flex" aria-label="Navigasi utama">
            <?php foreach ($navLinks as $link): ?>
                <a
                    href="<?= e($link['href']) ?>"
                    class="nav-link py-2 text-base font-medium <?= $link['active'] ? 'text-gold' : 'text-bone/90' ?>"
                    <?= $link['active'] ? 'aria-current="page"' : '' ?>
                >
                    <?= e($link['label']) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <a
            href="<?= e($gabungUrl) ?>"
            class="hidden items-center gap-2 bg-gold px-5 py-3 text-base font-bold text-ink transition hover:bg-bone active:translate-y-0.5 lg:inline-flex"
        >
            Gabung
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
        </a>

        <details class="mobile-menu lg:hidden" data-mobile-menu>
            <summary class="flex h-11 cursor-pointer list-none items-center gap-2 bg-gold px-3 text-base font-bold text-ink">
                Menu
                <svg data-menu-open class="h-4 w-4" aria-hidden="true"><use href="#i-menu"/></svg>
                <svg data-menu-close class="h-4 w-4" aria-hidden="true"><use href="#i-close"/></svg>
            </summary>

            <div class="fixed inset-x-0 bottom-0 top-16 z-40 overflow-y-auto bg-cobalt-deep px-4 pb-10 pt-8 text-bone sm:top-20 sm:px-6">
                <nav class="mx-auto flex max-w-[1600px] flex-col" aria-label="Navigasi seluler">
                    <?php foreach ($navLinks as $link): ?>
                        <a
                            href="<?= e($link['href']) ?>"
                            class="mobile-link flex items-center justify-between py-3 font-display text-[clamp(2rem,8vw,3.4rem)] font-black uppercase leading-none tracking-[-0.03em] <?= $link['active'] ? 'text-gold' : 'text-bone' ?>"
                            <?= $link['active'] ? 'aria-current="page"' : '' ?>
                        >
                            <?= e($link['label']) ?>
                            <svg class="h-6 w-6" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                        </a>
                    <?php endforeach; ?>

                    <a href="<?= e($gabungUrl) ?>" class="mt-8 inline-flex items-center justify-between bg-gold px-5 py-4 text-lg font-bold text-ink">
                        Gabung HIMA STEKOM
                        <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                    </a>

                    <p class="mt-8 max-w-sm text-base leading-relaxed text-bone/80">
                        Himpunan Mahasiswa Sistem Komputer dan Teknik Komputer, Kampus IIB Darmajaya, Bandar Lampung.
                    </p>
                </nav>
            </div>
        </details>
    </div>
</header>
