<?php

declare(strict_types=1);

$cardUrl = url('/berita/' . rawurlencode((string) $item['slug']));
$cardDate = (string) $item['diterbitkan_pada'];
$gambar = gambar_url($item['gambar'] ?? null);
?>
<article class="news-shot group flex flex-col justify-between border border-ink/15 bg-white p-5 transition duration-200 hover:border-cobalt">
    <div>
        <?php if ($gambar !== null): ?>
            <a href="<?= e($cardUrl) ?>" class="block overflow-hidden bg-cobalt" tabindex="-1" aria-hidden="true">
                <img
                    src="<?= e($gambar) ?>"
                    alt="Ilustrasi berita: <?= e($item['judul']) ?>"
                    loading="lazy"
                    class="aspect-[16/10] w-full object-cover"
                >
            </a>
        <?php endif; ?>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <span class="bg-red px-2.5 py-0.5 text-xs font-bold uppercase text-bone">
                <?= e($item['kategori']) ?>
            </span>
            <time datetime="<?= e(date('c', strtotime($cardDate))) ?>" class="text-xs font-medium text-muted">
                <?= e(tanggal_id($cardDate)) ?>
            </time>
        </div>

        <h3 class="mt-3 font-display text-xl font-bold leading-snug tracking-[-0.02em]">
            <a href="<?= e($cardUrl) ?>" class="hover:text-cobalt">
                <?= e($item['judul']) ?>
            </a>
        </h3>

        <p class="mt-2 text-sm leading-relaxed text-muted line-clamp-3">
            <?= e($item['ringkasan']) ?>
        </p>
    </div>

    <div class="mt-6 flex items-center justify-between border-t border-ink/10 pt-4">
        <span class="text-xs font-medium text-muted">
            <?= e((string) reading_time((string) $item['ringkasan'] . ' ' . (string) $item['isi'])) ?> menit baca
        </span>
        <a href="<?= e($cardUrl) ?>" class="press inline-flex items-center gap-2 text-sm font-bold text-cobalt hover:text-ink">
            Baca
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
        </a>
    </div>
</article>
