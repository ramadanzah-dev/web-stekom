<?php

declare(strict_types=1);

$heroMaxWidth = 'max-w-3xl';
$heroCentered = true;
$heroMinH     = true;

require BASE_PATH . '/app/Views/partials/hero-open.php';
?>
        <span class="inline-block bg-gold px-3 py-1 text-xs font-bold uppercase tracking-wider text-ink">Error 404</span>
        <h1 class="mt-6 font-display text-[clamp(3.5rem,14vw,8rem)] font-black uppercase leading-[0.85] tracking-[-0.045em]">
            Halaman<br>
            <span>Hilang<span class="text-gold">.</span></span>
        </h1>
        <p class="mx-auto mt-6 max-w-md text-base leading-relaxed text-bone/85 sm:text-lg">
            Sepertinya tautan yang kamu buka sudah dipindahkan atau tidak pernah ada.
            Yuk kembali ke beranda dan lanjut menjelajah.
        </p>
        <a href="<?= url('/') ?>" class="press mt-8 inline-flex items-center gap-3 bg-gold px-7 py-4 text-base font-bold text-ink hover:bg-bone">
            Kembali ke beranda
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
        </a>
<?php require BASE_PATH . '/app/Views/partials/hero-close.php'; ?>
