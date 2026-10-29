<?php

declare(strict_types=1);

$logo = gambar_url($site['logo'] ?? null);
$oprecAktif = (bool) config('oprec_aktif', false);
$gabungUrl = $oprecAktif ? url((string) config('oprec_link', '/berita')) : null;

$footerLinks = [
    'Beranda' => url('/'),
    'Divisi' => url('/#divisi'),
    'Agenda' => url('/#agenda'),
    'Kabar' => url('/berita'),
    'Organisasi' => url('/organisasi'),
];

$photoCredits = [
    [
        'title' => 'Portrait view of Bandar Lampung, Lampung (29 December 2019)',
        'creator' => 'Firzafp',
        'license' => 'CC BY-SA 4.0',
        'licenseUrl' => 'https://creativecommons.org/licenses/by-sa/4.0',
        'source' => 'Wikimedia Commons',
        'sourceUrl' => 'https://commons.wikimedia.org/wiki/File:Portrait_view_of_Bandar_Lampung,_Lampung_(29_December_2019).jpg',
    ],
    [
        'title' => 'Bandar Lampung',
        'creator' => '22Kartika',
        'license' => 'CC BY-SA 3.0',
        'licenseUrl' => 'https://creativecommons.org/licenses/by-sa/3.0',
        'source' => 'Wikimedia Commons',
        'sourceUrl' => 'https://commons.wikimedia.org/wiki/File:Bandar_Lampung.JPG',
    ],
    [
        'title' => 'Macro circuit board',
        'creator' => 'Ingo Dierking',
        'license' => 'CC BY-SA 4.0',
        'licenseUrl' => 'https://creativecommons.org/licenses/by-sa/4.0',
        'source' => 'Wikimedia Commons',
        'sourceUrl' => 'https://commons.wikimedia.org/wiki/File:Macro_circuit_board.JPG',
    ],
    [
        'title' => 'A messy network server room showing wires, patch panels in a room',
        'creator' => 'Moses Cursor Ssebunya',
        'license' => 'CC0',
        'licenseUrl' => 'https://creativecommons.org/publicdomain/zero/1.0/',
        'source' => 'WordPress Photo Directory',
        'sourceUrl' => 'https://wordpress.org/photos/photo/64767dd6fa/',
    ],
    [
        'title' => 'Arduino Micro',
        'creator' => 'Xosema',
        'license' => 'CC BY-SA 4.0',
        'licenseUrl' => 'https://creativecommons.org/licenses/by-sa/4.0',
        'source' => 'Wikimedia Commons',
        'sourceUrl' => 'https://commons.wikimedia.org/wiki/File:Arduino_Micro.jpg',
    ],
];
?>
<footer class="bg-ink text-bone" id="kontak">
    <div class="mx-auto max-w-[1600px] px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <a href="<?= url('/') ?>" class="group flex items-center gap-3">
                    <?php if ($logo !== null): ?>
                        <img
                            src="<?= e($logo) ?>"
                            alt="Logo <?= e($site['name']) ?>"
                            width="48"
                            height="48"
                            class="h-12 w-12 shrink-0 transition group-hover:scale-105"
                        >
                    <?php endif; ?>
                    <span class="font-display text-2xl font-black uppercase tracking-[-0.03em]"><?= e($site['name']) ?></span>
                </a>
                <p class="mt-6 max-w-md text-base leading-relaxed text-bone/85">
                    <?= e($site['description']) ?>
                </p>
            </div>

            <nav class="grid gap-8 sm:grid-cols-2 lg:col-span-4">
                <div>
                    <h2 class="font-display text-lg font-bold">Menu</h2>
                    <ul class="mt-4 space-y-3 text-base text-bone/85">
                        <?php foreach ($footerLinks as $label => $url): ?>
                            <li><a href="<?= e($url) ?>" class="footer-link"><?= e($label) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>

            <div class="lg:col-span-3">
                <h2 class="font-display text-lg font-bold">Kontak</h2>
                <ul class="mt-4 space-y-4 text-base text-bone/85">
                    <li>
                        <a href="mailto:<?= e($site['email']) ?>" class="footer-link inline-flex items-start gap-2.5">
                            <svg class="mt-0.5 h-4 w-4 shrink-0" aria-hidden="true"><use href="#i-mail"/></svg>
                            <span><?= e($site['email']) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= e($site['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="footer-link inline-flex items-start gap-2.5">
                            <svg class="mt-0.5 h-4 w-4 shrink-0" aria-hidden="true"><use href="#i-instagram"/></svg>
                            <span>Instagram HIMA STEKOM</span>
                        </a>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" aria-hidden="true"><use href="#i-map-pin"/></svg>
                        <span><?= e($site['location']) ?></span>
                    </li>
                </ul>

                <?php if ($gabungUrl !== null): ?>
                    <a href="<?= e($gabungUrl) ?>" class="mt-7 inline-flex items-center gap-2 bg-gold px-4 py-3 text-base font-bold text-ink transition hover:bg-bone active:translate-y-0.5">
                        Gabung angkatan ini
                        <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-14 max-w-4xl text-[13px] leading-relaxed text-bone/75">
            <h2 class="font-display text-base font-bold text-bone">Kredit foto</h2>
            <ul class="mt-3 grid gap-x-8 gap-y-2 sm:grid-cols-2">
                <?php foreach ($photoCredits as $credit): ?>
                    <li>
                        “<?= e($credit['title']) ?>” oleh <?= e($credit['creator']) ?>,
                        <a href="<?= e($credit['licenseUrl']) ?>" target="_blank" rel="noopener noreferrer" class="footer-link underline decoration-gold/70 underline-offset-2"><?= e($credit['license']) ?></a>,
                        via
                        <a href="<?= e($credit['sourceUrl']) ?>" target="_blank" rel="noopener noreferrer" class="footer-link underline decoration-gold/70 underline-offset-2"><?= e($credit['source']) ?></a>.
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mt-10 flex flex-col gap-4 text-sm text-bone/75 sm:flex-row sm:items-center sm:justify-between">
            <p>© <?= date('Y') ?> <?= e($site['name']) ?>. <?= e($site['footer_note'] ?? 'Dikelola mahasiswa, untuk mahasiswa.') ?></p>
            <div class="flex flex-wrap items-center gap-6">
                <a href="<?= url('/admin') ?>" class="footer-link text-bone/75">Admin</a>
                <a href="#atas" class="footer-link inline-flex items-center gap-2 text-bone/85">
                    Kembali ke atas
                    <svg class="h-3 w-3" aria-hidden="true"><use href="#i-chevron-up"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>
