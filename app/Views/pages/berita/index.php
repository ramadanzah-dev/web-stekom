<?php

declare(strict_types=1);

$featuredDate = $featured !== null ? strtotime((string) $featured['diterbitkan_pada']) : false;
$featuredUrl = $featured !== null ? url('/berita/' . rawurlencode((string) $featured['slug'])) : url('/berita');
$items = $pagination['items'];
?>
<?php require BASE_PATH . '/app/Views/partials/hero-open.php'; ?>
        <nav class="flex items-center gap-2 text-xs font-medium uppercase tracking-wider text-bone/70" aria-label="Breadcrumb">
            <a href="<?= url('/') ?>" class="transition hover:text-gold">Beranda</a>
            <span aria-hidden="true">/</span>
            <span class="text-bone" aria-current="page">Berita</span>
        </nav>

        <div class="mt-8 flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
            <div>
                <span class="bg-gold px-3 py-1 text-xs font-bold uppercase tracking-wider text-ink">
                    Berita &amp; Kabar
                </span>
                <h1 class="mt-4 font-display text-[clamp(2.8rem,7vw,6.5rem)] font-black uppercase leading-[0.88] tracking-[-0.045em]">
                    Kabar dari<br>
                    <span>STEKOM<span class="text-gold">.</span></span>
                </h1>
            </div>
            <p class="max-w-md text-base leading-relaxed text-bone/85 sm:text-lg">
                Catatan kegiatan, prestasi, dan gagasan dari Himpunan Mahasiswa Sistem Komputer.
                Sesuatu selalu terjadi di sini.
            </p>
        </div>
<?php require BASE_PATH . '/app/Views/partials/hero-close.php'; ?>

<section class="bg-bone py-16 text-ink sm:py-24">
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
        <?php if ($featured !== null): ?>
            <article class="grid border border-ink/15 bg-ink text-bone lg:grid-cols-12">
                <div class="flex flex-col justify-between p-6 sm:p-10 lg:col-span-7">
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="bg-red px-3 py-1 text-xs font-bold uppercase text-bone">
                                <?= e($featured['kategori']) ?>
                            </span>
                            <time datetime="<?= e(date('c', (int) $featuredDate)) ?>" class="text-xs font-medium text-bone/70">
                                <?= e(tanggal_id((string) $featured['diterbitkan_pada'])) ?>
                            </time>
                            <span class="text-xs font-bold uppercase tracking-wider text-gold">Sorotan utama</span>
                        </div>

                        <h2 class="mt-6 font-display text-[clamp(1.8rem,3.2vw,3rem)] font-black leading-tight tracking-[-0.03em]">
                            <a href="<?= e($featuredUrl) ?>" class="transition hover:text-gold">
                                <?= e($featured['judul']) ?>
                            </a>
                        </h2>

                        <p class="mt-4 max-w-2xl text-base leading-relaxed text-bone/80 sm:text-lg">
                            <?= e($featured['ringkasan']) ?>
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-bone/15 pt-6">
                        <a href="<?= e($featuredUrl) ?>" class="press inline-flex items-center gap-3 bg-gold px-6 py-3.5 text-base font-bold text-ink hover:bg-bone">
                            Baca selengkapnya
                            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                        </a>
                        <span class="text-xs font-medium text-bone/60">
                            <?= e((string) reading_time((string) $featured['ringkasan'] . ' ' . (string) $featured['isi'])) ?> menit baca
                        </span>
                    </div>
                </div>

                <div class="relative min-h-[16rem] overflow-hidden bg-cobalt-deep lg:col-span-5">
                    <?php $featuredGambar = gambar_url($featured['gambar'] ?? null); ?>
                    <?php if ($featuredGambar !== null): ?>
                        <img
                            src="<?= e($featuredGambar) ?>"
                            alt="Ilustrasi berita: <?= e($featured['judul']) ?>"
                            class="h-full w-full object-cover"
                        >
                    <?php else: ?>
                        <div class="flex h-full min-h-[18rem] flex-col justify-end p-8 text-bone">
                            <p class="font-display text-5xl font-black uppercase text-gold">HIMA STEKOM</p>
                            <p class="mt-2 text-base text-bone/80">Dokumentasi &amp; publikasi resmi</p>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        <?php endif; ?>

        <div class="mt-16 flex flex-col justify-between gap-4 border-t border-ink/10 pt-8 sm:flex-row sm:items-end">
            <div>
                <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-black uppercase leading-tight tracking-[-0.03em]">
                    Semua Berita<span class="text-cobalt">.</span>
                </h2>
                <p class="mt-1 text-base text-muted">Arsip kabar dan kegiatan HIMA STEKOM</p>
            </div>
            <p class="text-sm font-bold uppercase tracking-wider text-muted">
                <?= e((string) $pagination['total']) ?> tulisan
            </p>
        </div>

        <?php if ($items === []): ?>
            <div class="mt-10 border border-dashed border-ink/20 p-12 text-center bg-white">
                <p class="font-display text-xl font-bold">Belum ada berita lain.</p>
                <p class="mt-2 text-base text-muted">Kabar terbaru akan segera ditampilkan di sini.</p>
            </div>
        <?php else: ?>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($items as $item): ?>
                    <?php require BASE_PATH . '/app/Views/partials/berita-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($pagination['pages'] > 1): ?>
            <nav class="mt-12 flex items-center justify-center gap-2" aria-label="Navigasi halaman berita">
                <?php if ($pagination['page'] > 1): ?>
                    <a href="<?= e(url('/berita') . '?page=' . ($pagination['page'] - 1)) ?>" class="press inline-flex h-11 w-11 items-center justify-center border border-ink/20 bg-white font-bold text-ink hover:bg-gold hover:border-gold" aria-label="Halaman sebelumnya">
                        <span aria-hidden="true">←</span>
                    </a>
                <?php endif; ?>

                <?php for ($nomor = 1; $nomor <= $pagination['pages']; $nomor++): ?>
                    <a
                        href="<?= e(url('/berita') . '?page=' . $nomor) ?>"
                        class="press inline-flex h-11 w-11 items-center justify-center font-display text-sm font-bold <?= $nomor === $pagination['page'] ? 'bg-ink text-gold' : 'border border-ink/20 bg-white text-ink hover:bg-gold hover:border-gold' ?>"
                        <?= $nomor === $pagination['page'] ? 'aria-current="page"' : '' ?>
                    >
                        <?= e((string) $nomor) ?>
                    </a>
                <?php endfor; ?>

                <?php if ($pagination['page'] < $pagination['pages']): ?>
                    <a href="<?= e(url('/berita') . '?page=' . ($pagination['page'] + 1)) ?>" class="press inline-flex h-11 w-11 items-center justify-center border border-ink/20 bg-white font-bold text-ink hover:bg-gold hover:border-gold" aria-label="Halaman berikutnya">
                        <span aria-hidden="true">→</span>
                    </a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    </div>
</section>
