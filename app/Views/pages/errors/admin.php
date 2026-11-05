<?php

declare(strict_types=1);

$status = (int) ($status ?? 403);
$message = (string) ($message ?? 'Kamu tidak punya akses ke halaman ini.');
$backUrl = $admin !== null ? url('/admin') : url('/admin/login');
$backLabel = $admin !== null ? 'Kembali ke dashboard' : 'Kembali ke halaman masuk';
?>
<div class="mx-auto flex max-w-lg flex-col items-start py-12 sm:py-20">
    <span class="grid h-12 w-12 place-items-center bg-red/10 text-red" aria-hidden="true">
        <svg class="h-5 w-5"><use href="#i-alert"/></svg>
    </span>
    <p class="mt-6 text-xs font-semibold text-muted">Error <?= e((string) $status) ?></p>
    <h1 class="mt-3 font-display text-[clamp(2rem,4vw,2.6rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
        Akses<br>
        ditolak<span class="text-cobalt">.</span>
    </h1>
    <p class="mt-5 max-w-sm text-sm leading-relaxed text-muted"><?= e($message) ?></p>
    <a href="<?= e($backUrl) ?>" class="press mt-8 inline-flex items-center gap-3 bg-cobalt px-6 py-3.5 text-sm font-bold text-bone transition hover:bg-ink">
        <?= e($backLabel) ?>
        <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
    </a>
</div>
