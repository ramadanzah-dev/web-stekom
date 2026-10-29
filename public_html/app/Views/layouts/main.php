<?php

declare(strict_types=1);

$pageTitle = !empty($title)
    ? $title . ' — ' . $site['name']
    : $site['name'] . ' — ' . $site['full_name'];

$pageDescription = !empty($description) ? $description : $site['description'];
$bodyClass = $bodyClass ?? 'bg-bone font-sans text-ink antialiased';
$ogImage = $ogImage ?? asset('img/found/macro-circuit-board.jpg');
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="theme-color" content="#0B4B9E">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:site_name" content="<?= e($site['name']) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">

    <link rel="icon" href="<?= e(gambar_url($site['logo'] ?? null) ?? asset('img/favicon.svg')) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@700;800;900&family=Red+Hat+Text:wght@400;500;700&display=swap"
        rel="stylesheet"
    >

    <script>
        document.documentElement.classList.add('js');
    </script>
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
</head>
<body class="<?= e($bodyClass) ?>">
    <div id="atas" aria-hidden="true"></div>

    <a
        href="#konten"
        class="skip-link sr-only bg-gold px-5 py-3 text-base font-bold text-ink focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100]"
    >
        Langsung ke konten
    </a>

    <?php require BASE_PATH . '/app/Views/partials/icons.php'; ?>
    <?php require BASE_PATH . '/app/Views/partials/navbar.php'; ?>

    <main id="konten">
        <?= $content ?>
    </main>

    <?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>

    <script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
