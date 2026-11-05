<?php

declare(strict_types=1);

$logo = gambar_url($site['logo'] ?? null);
$gabungUrl = url('/berita/open-recruitment-anggota-stekom-2026-2027');

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
        'creator' => 'Geek3',
        'license' => 'CC BY-SA 3.0',
        'licenseUrl' => 'https://creativecommons.org/licenses/by-sa/3.0',
        'source' => 'Wikimedia Commons',
        'sourceUrl' => 'https://commons.wikimedia.org/wiki/File:Arduino_Micro.jpg',
    ],
    [
        'title' => 'COMPUTER LABS',
        'creator' => 'Mailane vanesa',
        'license' => 'CC0',
        'licenseUrl' => 'https://creativecommons.org/publicdomain/zero/1.0/deed.en',
        'source' => 'Wikimedia Commons',
        'sourceUrl' => 'https://commons.wikimedia.org/wiki/File:COMPUTER_LABS.jpg',
    ],
];
?>
<footer class="bg-ink text-bone">
    <div class="mx-auto max-w-[1600px] px-4 pt-16 sm:px-6 sm:pt-20 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-5">
                <a href="<?= url('/') ?>" class="inline-flex items-center gap-3" aria-label="<?= e($site['name']) ?>">
                    <?php if ($logo !== null): ?>
                        <img src="<?= e($logo) ?>" alt="Logo <?= e($site['name']) ?> IIB Darmajaya" width="52" height="52" class="h-13 w-13 object-contain" loading="lazy">
                    <?php else: ?>
                        <span class="grid h-12 w-12 place-items-center bg-gold font-display text-xl font-black text-ink">S</span>
                    <?php endif; ?>
                    <span class="flex flex-col">
                        <span class="font-display text-2xl font-black leading-none tracking-[-0.03em]"><?= e($site['name']) ?></span>
                        <span class="mt-1 text-[13px] font-medium leading-none text-bone/80">IIB Darmajaya</span>
                    </span>
                </a>

                <p class="mt-8 max-w-md font-display text-[clamp(1.9rem,3.2vw,3rem)] font-black leading-[0.98] tracking-[-0.03em]">
                    Ngoprek terus, bareng-bareng.
                </p>
                <p class="mt-5 max-w-md text-base leading-relaxed text-bone/80">
                    <?= e($site['tagline']) ?>
                </p>
            </div>

            <nav class="lg:col-span-3 lg:col-start-7" aria-label="Tautan footer">
                <h2 class="font-display text-lg font-bold">Jelajahi</h2>
                <ul class="mt-4 space-y-3">
                    <?php foreach ($footerLinks as $label => $href): ?>
                        <li>
                            <a href="<?= e($href) ?>" class="footer-link text-base text-bone/85"><?= e($label) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
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

                <a href="<?= e($gabungUrl) ?>" class="mt-7 inline-flex items-center gap-2 bg-gold px-4 py-3 text-base font-bold text-ink transition hover:bg-bone active:translate-y-0.5">
                    Gabung angkatan ini
                    <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                </a>
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
                    <span aria-hidden="true">↑</span>
                </a>
            </div>
        </div>

        <div aria-hidden="true" class="select-none overflow-hidden pt-6">
            <p class="translate-y-[18%] whitespace-nowrap text-center font-display text-[23vw] font-black leading-none tracking-[-0.06em] text-bone/10">
                <?= e($site['name']) ?>
            </p>
        </div>
    </div>
</footer>
