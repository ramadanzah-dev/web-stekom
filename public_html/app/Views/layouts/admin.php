<?php

declare(strict_types=1);

$pageTitle = !empty($title) ? $title . ' · Admin ' . $site['name'] : 'Admin ' . $site['name'];

$navItems = [
    ['label' => 'Dashboard', 'href' => url('/admin'), 'icon' => 'i-grid', 'active' => $currentPath === '/admin'],
    ['label' => 'Berita', 'href' => url('/admin/berita'), 'icon' => 'i-news', 'active' => str_starts_with($currentPath, '/admin/berita')],
    ['label' => 'Pengurus', 'href' => url('/admin/pengurus'), 'icon' => 'i-users', 'active' => str_starts_with($currentPath, '/admin/pengurus')],
    ['label' => 'Divisi', 'href' => url('/admin/divisi'), 'icon' => 'i-layers', 'active' => str_starts_with($currentPath, '/admin/divisi')],
    ['label' => 'Kegiatan', 'href' => url('/admin/kegiatan'), 'icon' => 'i-calendar', 'active' => str_starts_with($currentPath, '/admin/kegiatan')],
    ['label' => 'Pengaturan', 'href' => url('/admin/pengaturan'), 'icon' => 'i-settings', 'active' => str_starts_with($currentPath, '/admin/pengaturan')],
];

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
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>?v=<?= filemtime(BASE_PATH . '/public_html/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>?v=<?= filemtime(BASE_PATH . '/public_html/css/admin.css') ?>">
</head>
<body class="min-h-dvh bg-bone font-sans text-ink antialiased">
    <?php require BASE_PATH . '/app/Views/partials/icons.php'; ?>

    <div
        id="admin-overlay"
        class="fixed inset-0 z-40 hidden bg-ink/70 lg:hidden"
        aria-hidden="true"
        data-sidebar-close
    ></div>

    <div class="lg:flex">
        <aside
            id="admin-sidebar"
            class="fixed top-0 left-0 z-50 flex h-screen w-72 -translate-x-full flex-col bg-ink text-bone transition-transform duration-300 lg:sticky lg:top-0 lg:h-screen lg:self-start lg:translate-x-0"
            aria-label="Navigasi admin"
        >
            <div class="flex h-20 items-center justify-between border-b border-white/10 px-5">
                <a href="<?= url('/admin') ?>" class="group flex min-w-0 items-center gap-3" aria-label="Dashboard admin">
                    <?php if ($logo !== null): ?>
                        <img src="<?= e($logo) ?>" alt="Logo <?= e($site['name']) ?>" class="h-11 w-auto max-w-[6.5rem] shrink-0 object-contain">
                    <?php else: ?>
                        <span class="grid h-11 w-11 shrink-0 place-items-center bg-gold font-display text-lg font-black text-ink">
                            S
                        </span>
                    <?php endif; ?>
                    <span class="flex min-w-0 flex-col">
                        <span class="truncate font-display text-lg font-black leading-none tracking-[-0.03em]"><?= e($site['name']) ?></span>
                        <span class="mt-1 truncate text-xs font-medium leading-none text-bone/60">Panel admin</span>
                    </span>
                </a>
                <button type="button" class="grid h-9 w-9 shrink-0 place-items-center border border-white/15 text-bone/70 transition hover:border-white/40 hover:text-bone lg:hidden" data-sidebar-close aria-label="Tutup menu">
                    <svg class="h-4 w-4" aria-hidden="true"><use href="#i-x"/></svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-6 overscroll-contain">
                <p class="px-3 pb-2 text-xs font-semibold text-bone/55">Konten</p>
                <div class="space-y-0.5">
                    <?php foreach ($navItems as $item): ?>
                        <a
                            href="<?= e($item['href']) ?>"
                            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition <?= $item['active'] ? 'bg-bone text-ink' : 'text-bone/75 hover:bg-white/5 hover:text-bone' ?>"
                            <?= $item['active'] ? 'aria-current="page"' : '' ?>
                        >
                            <svg class="h-[18px] w-[18px] shrink-0 <?= $item['active'] ? 'text-cobalt' : 'text-bone/50' ?>" aria-hidden="true"><use href="#<?= e($item['icon']) ?>"/></svg>
                            <?= e($item['label']) ?>
                            <?php if ($item['active']): ?>
                                <span class="ml-auto h-1.5 w-1.5 bg-gold" aria-hidden="true"></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <p class="px-3 pb-2 pt-7 text-xs font-semibold text-bone/55">Situs</p>
                <a href="<?= url('/') ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-bone/75 transition hover:bg-white/5 hover:text-bone">
                    <svg class="h-[18px] w-[18px] shrink-0 text-bone/50" aria-hidden="true"><use href="#i-eye"/></svg>
                    Lihat situs
                </a>
            </nav>

            <div class="border-t border-white/10 p-4">
                <div class="flex items-center gap-3 bg-white/[0.04] p-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center bg-gold font-display text-sm font-black text-ink">
                        <?= e(initials((string) $admin['nama'])) ?>
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold"><?= e($admin['nama']) ?></p>
                        <p class="truncate text-xs text-bone/60"><?= e($admin['email']) ?></p>
                    </div>
                </div>

                <form method="post" action="<?= url('/admin/logout') ?>" class="mt-3">
                    <?= csrf_field() ?>
                    <button type="submit" class="flex w-full items-center justify-center gap-2 border border-white/15 px-3 py-2.5 text-sm font-medium text-bone/70 transition hover:border-white/40 hover:text-bone">
                        <svg class="h-4 w-4" aria-hidden="true"><use href="#i-logout"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-dvh min-w-0 flex-1 flex-col overflow-x-clip">
            <header class="sticky top-0 z-30 border-b border-ink/10 bg-bone">
                <div class="mx-auto flex h-16 w-full max-w-[1500px] items-center justify-between gap-4 px-4 sm:px-6 lg:h-[72px] lg:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        <button type="button" class="grid h-10 w-10 shrink-0 place-items-center border border-ink/15 text-ink transition hover:border-ink/40 lg:hidden" data-sidebar-toggle aria-label="Buka menu" aria-controls="admin-sidebar" aria-expanded="false">
                            <svg class="h-5 w-5" aria-hidden="true"><use href="#i-menu"/></svg>
                        </button>
                        <div class="min-w-0">
                            <p class="text-xs font-medium text-muted">Panel admin</p>
                            <p class="truncate font-display text-sm font-bold tracking-[-0.02em] sm:text-base"><?= e($title ?? 'Dashboard') ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="<?= url('/') ?>" target="_blank" rel="noopener noreferrer" class="hidden items-center gap-2 text-sm font-semibold text-ink transition hover:text-cobalt sm:inline-flex">
                            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-eye"/></svg>
                            Lihat situs
                        </a>
                        <span class="grid h-10 w-10 place-items-center bg-gold font-display text-xs font-black text-ink" aria-hidden="true">
                            <?= e(initials((string) $admin['nama'])) ?>
                        </span>
                    </div>
                </div>
            </header>

            <main class="mx-auto w-full max-w-[1500px] flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
                <?php require BASE_PATH . '/app/Views/partials/admin/flash.php'; ?>
                <?= $content ?>
            </main>

            <footer class="mx-auto w-full max-w-[1500px] px-4 pb-6 sm:px-6 lg:px-8">
                <p class="text-xs text-muted">
                    <?= e($site['name']) ?> · Panel admin · <?= date('Y') ?>
                </p>
            </footer>
        </div>
    </div>

    <?php require BASE_PATH . '/app/Views/partials/admin/confirm-modal.php'; ?>

    <script src="<?= asset('js/admin.js') ?>" defer></script>
</body>
</html>
