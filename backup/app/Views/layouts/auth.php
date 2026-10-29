<?php

declare(strict_types=1);

$pageTitle = !empty($title) ? $title . ' — ' . $site['name'] : 'Masuk Admin — ' . $site['name'];
$logo = gambar_url($site['logo'] ?? null);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0B4B9E">

    <link rel="icon" href="<?= asset('img/favicon.svg') ?>" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@700;800;900&family=Red+Hat+Text:wght@400;500;700&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#08172F',
                        'ink-soft': '#10233F',
                        cobalt: '#0B4B9E',
                        'cobalt-deep': '#073577',
                        gold: '#FFD200',
                        red: '#C8102E',
                        bone: '#F2F1EB',
                        muted: '#46536A',
                    },
                    fontFamily: {
                        display: ['"Red Hat Display"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        sans: ['"Red Hat Text"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="min-h-dvh bg-bone font-sans text-ink antialiased">
    <?php require BASE_PATH . '/app/Views/partials/icons.php'; ?>

    <div class="grid min-h-dvh lg:grid-cols-2">
        <aside class="relative hidden bg-cobalt p-10 text-bone lg:flex lg:flex-col lg:justify-between xl:p-14">
            <a href="<?= url('/') ?>" class="inline-flex items-center gap-3" aria-label="<?= e($site['name']) ?>">
                <?php if ($logo !== null): ?>
                    <img src="<?= e($logo) ?>" alt="Logo <?= e($site['name']) ?>" class="h-12 w-auto max-w-[9rem] shrink-0 object-contain">
                <?php else: ?>
                    <span class="grid h-11 w-11 shrink-0 place-items-center bg-gold font-display text-xl font-black text-ink">
                        S
                    </span>
                <?php endif; ?>
                <span class="flex flex-col">
                    <span class="font-display text-xl font-black leading-none tracking-[-0.03em]"><?= e($site['name']) ?></span>
                    <span class="mt-1 text-[13px] font-medium leading-none text-bone/85"><?= e($site['full_name']) ?></span>
                </span>
            </a>

            <div class="max-w-lg">
                <p class="font-display text-[clamp(2.6rem,4.6vw,4.4rem)] font-black uppercase leading-[0.88] tracking-[-0.045em]">
                    Kelola<br>
                    cerita<br>
                    himpunan<span class="text-gold">.</span>
                </p>
                <p class="mt-7 max-w-md text-base leading-relaxed text-bone/85">
                    Satu tempat untuk menulis berita, merawat struktur pengurus, dan menjaga
                    informasi divisi tetap aktual.
                </p>
            </div>

            <figure>
                <div class="overflow-hidden bg-cobalt-deep">
                    <img
                        src="<?= e(asset('img/found/macro-circuit-board.jpg')) ?>"
                        alt="Makro papan sirkuit dengan jalur tembaga dan komponen elektronika"
                        width="1920"
                        height="1280"
                        class="aspect-[16/9] w-full object-cover"
                    >
                </div>
                <figcaption class="mt-3 text-xs leading-relaxed text-bone/75">
                    Ilustrasi papan sirkuit. Foto: Ingo Dierking, CC BY-SA 4.0.
                </figcaption>
            </figure>
        </aside>

        <main class="flex items-center justify-center px-5 py-12 sm:px-8">
            <div class="w-full max-w-md">
                <a href="<?= url('/') ?>" class="mb-8 inline-flex items-center gap-3 lg:hidden" aria-label="<?= e($site['name']) ?>">
                    <?php if ($logo !== null): ?>
                        <img src="<?= e($logo) ?>" alt="Logo <?= e($site['name']) ?>" class="h-11 w-auto max-w-[7rem] object-contain">
                    <?php else: ?>
                        <span class="grid h-11 w-11 shrink-0 place-items-center bg-gold font-display text-lg font-black text-ink">S</span>
                    <?php endif; ?>
                    <span class="flex flex-col">
                        <span class="font-display text-lg font-black leading-none tracking-[-0.03em]"><?= e($site['name']) ?></span>
                        <span class="mt-1 text-xs font-medium leading-none text-muted">Panel admin</span>
                    </span>
                </a>

                <?php require BASE_PATH . '/app/Views/partials/admin/flash.php'; ?>
                <?= $content ?>
            </div>
        </main>
    </div>
</body>
</html>
