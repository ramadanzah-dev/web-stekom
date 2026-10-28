<?php

declare(strict_types=1);

/* Shared hero section opener — selaras dengan poster style beranda.
 * Digunakan oleh organisasi, berita/index, berita/show, 404.
 * Variabel opsional:
 *   $heroMaxWidth — string kelas Tailwind, misal 'max-w-[1600px]', 'max-w-4xl' (default max-w-[1600px])
 *   $heroCentered — bool, konten rata tengah (default false)
 *   $heroMinH     — bool, tinggi minimal viewport (default false)
 *   $heroBg       — string kelas background, misal 'bg-cobalt' (default) atau 'bg-ink'
 */
$heroMaxWidth = $heroMaxWidth ?? 'max-w-[1600px]';
$heroCentered = $heroCentered ?? false;
$heroMinH     = $heroMinH ?? false;
$heroBg       = $heroBg ?? 'bg-cobalt';
?>
<section class="hero relative overflow-hidden <?= e($heroBg) ?> text-bone pb-12 sm:pb-16 pt-10 sm:pt-14<?= $heroMinH ? ' flex min-h-[70vh] items-center' : '' ?>">
    <div class="relative mx-auto w-full <?= e($heroMaxWidth) ?> px-4 sm:px-6 lg:px-8<?= $heroCentered ? ' text-center' : '' ?>">
