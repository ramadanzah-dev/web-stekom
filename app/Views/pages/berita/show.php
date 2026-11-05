<?php

declare(strict_types=1);

$tanggal = (string) $artikel['diterbitkan_pada'];
$paragraf = paragraphs((string) $artikel['isi']);

$heroMaxWidth = 'max-w-4xl';
require BASE_PATH . '/app/Views/partials/hero-open.php';
?>
        <nav class="flex items-center gap-2 text-xs font-medium uppercase tracking-wider text-bone/70" aria-label="Breadcrumb">
            <a href="<?= url('/') ?>" class="transition hover:text-gold">Beranda</a>
            <span aria-hidden="true">/</span>
            <a href="<?= url('/berita') ?>" class="transition hover:text-gold">Berita</a>
            <span aria-hidden="true">/</span>
            <span class="text-bone" aria-current="page">Artikel</span>
        </nav>

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <span class="bg-red px-3 py-1 text-xs font-bold uppercase text-bone">
                <?= e($artikel['kategori']) ?>
            </span>
            <time datetime="<?= e(date('c', strtotime($tanggal))) ?>" class="text-xs font-medium text-bone/70">
                <?= e(tanggal_id($tanggal)) ?>
            </time>
            <span class="text-xs font-medium text-bone/60">
                <?= e((string) reading_time((string) $artikel['isi'])) ?> menit baca
            </span>
        </div>

        <h1 class="mt-6 font-display text-[clamp(2.2rem,5vw,4.2rem)] font-black leading-tight tracking-[-0.035em]">
            <?= e($artikel['judul']) ?>
        </h1>

        <p class="mt-6 text-lg leading-relaxed text-bone/85 sm:text-xl">
            <?= e($artikel['ringkasan']) ?>
        </p>

        <div class="mt-8 flex items-center gap-4 border-t border-bone/15 pt-6">
            <span class="grid h-12 w-12 shrink-0 place-items-center bg-gold font-display text-lg font-black text-ink">
                <?= e(initials((string) $artikel['penulis'])) ?>
            </span>
            <div>
                <p class="text-base font-bold text-bone"><?= e($artikel['penulis']) ?></p>
                <p class="text-xs font-medium uppercase tracking-wider text-bone/70">Penulis</p>
            </div>
        </div>
<?php require BASE_PATH . '/app/Views/partials/hero-close.php'; ?>

<article class="bg-bone py-16 text-ink sm:py-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <?php $gambar = gambar_url($artikel['gambar'] ?? null); ?>
        <?php if ($gambar !== null): ?>
            <figure class="mb-10 overflow-hidden border border-ink/15 bg-cobalt">
                <img
                    src="<?= e($gambar) ?>"
                    alt="Ilustrasi berita: <?= e($artikel['judul']) ?>"
                    class="aspect-[16/9] w-full object-cover"
                >
                <figcaption class="bg-ink/5 px-5 py-3 text-xs font-medium text-muted">
                    Ilustrasi · <?= e($artikel['kategori']) ?>
                </figcaption>
            </figure>
        <?php endif; ?>

        <div class="prose-hima text-ink">
            <?php foreach ($paragraf as $isi): ?>
                <p><?= e($isi) ?></p>
            <?php endforeach; ?>
        </div>

        <div class="mt-12 flex flex-wrap items-center justify-between gap-4 border-t border-ink/15 pt-6">
            <span class="bg-ink px-3 py-1.5 text-xs font-bold uppercase text-bone">
                <?= e($artikel['kategori']) ?>
            </span>
            <a href="<?= url('/berita') ?>" class="press inline-flex items-center gap-2 text-base font-bold text-cobalt hover:text-ink">
                <span aria-hidden="true">←</span>
                Semua berita
            </a>
        </div>
    </div>
</article>

<?php if ($lainnya !== []): ?>
    <section class="bg-bone pb-20 text-ink sm:pb-28">
        <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 border-t border-ink/15 pt-10 sm:flex-row sm:items-end">
                <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-black uppercase tracking-[-0.03em]">
                    Kabar Lainnya<span class="text-cobalt">.</span>
                </h2>
                <a href="<?= url('/berita') ?>" class="press inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-cobalt hover:text-ink">
                    Lihat semua
                    <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                </a>
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($lainnya as $item): ?>
                    <?php require BASE_PATH . '/app/Views/partials/berita-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
