<?php

declare(strict_types=1);
?>
<?php require BASE_PATH . '/app/Views/partials/hero-open.php'; ?>
        <nav class="flex items-center gap-2 text-xs font-medium uppercase tracking-wider text-bone/70" aria-label="Breadcrumb">
            <a href="<?= url('/') ?>" class="transition hover:text-gold">Beranda</a>
            <span aria-hidden="true">/</span>
            <span class="text-bone" aria-current="page">Organisasi</span>
        </nav>

        <div class="mt-8 grid items-end gap-12 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <span class="bg-gold px-3 py-1 text-xs font-bold uppercase tracking-wider text-ink">
                    Organisasi HIMA
                </span>
                <h1 class="mt-4 font-display text-[clamp(3.2rem,9vw,7.5rem)] font-black uppercase leading-[0.84] tracking-[-0.045em]">
                    HIMA<br>
                    <span>STEKOM<span class="text-gold">.</span></span>
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-bone/85 sm:text-xl">
                    Himpunan Mahasiswa Sistem Komputer—rumah bersama untuk belajar, berkarya,
                    dan bertumbuh. Dikelola oleh mahasiswa, untuk mahasiswa.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 lg:col-span-4">
                <?php foreach ($stats as $stat): ?>
                    <div class="border border-bone/20 bg-cobalt-deep p-5">
                        <p class="text-xs font-medium uppercase tracking-wider text-bone/70"><?= e($stat['label']) ?></p>
                        <p class="mt-2 font-display text-3xl font-black tracking-[-0.03em] text-gold sm:text-4xl"><?= e($stat['value']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php require BASE_PATH . '/app/Views/partials/hero-close.php'; ?>

<section class="bg-bone py-16 text-ink sm:py-24">
    <div class="mx-auto grid max-w-[1600px] gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-8 lg:px-8">
        <div class="reveal lg:col-span-5">
            <h2 class="font-display text-[clamp(2.5rem,6vw,5rem)] font-black uppercase leading-[0.9] tracking-[-0.04em]">
                Satu himpunan,<br>
                satu arah<br>
                <span class="text-cobalt">gerak.</span>
            </h2>
        </div>

        <div class="reveal lg:col-span-6 lg:col-start-7">
            <p class="text-xl leading-relaxed text-ink sm:text-2xl">
                HIMA STEKOM adalah organisasi mahasiswa program studi Sistem Komputer yang
                menjadi wadah resmi untuk pengembangan minat, bakat, dan keilmuan.
            </p>
            <p class="mt-5 text-lg leading-relaxed text-muted">
                Kami menjalankan program belajar, proyek kolaboratif, kompetisi, dan kegiatan
                sosial yang menghubungkan mahasiswa dengan alumni serta industri. Semua dikelola
                oleh pengurus yang dipilih dan bekerja untuk kepentingan anggota.
            </p>

            <dl class="mt-10 grid gap-6 border-t border-ink/15 pt-8 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-muted">Nama resmi</dt>
                    <dd class="mt-2 font-display text-base font-bold text-ink">Himpunan Mahasiswa Sistem Komputer</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-muted">Periode kepengurusan</dt>
                    <dd class="mt-2 font-display text-base font-bold text-ink"><?= e($site['periode']) ?></dd>
                </div>
            </dl>
        </div>
    </div>
</section>

<section class="bg-bone pb-16 text-ink sm:pb-24">
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
        <div class="reveal grid gap-6 lg:grid-cols-12">
            <div class="border border-ink bg-ink p-8 text-bone sm:p-12 lg:col-span-5 flex flex-col justify-between">
                <div>
                    <span class="bg-gold px-3 py-1 text-xs font-bold uppercase text-ink">Visi</span>
                    <p class="mt-8 font-display text-[clamp(1.6rem,2.5vw,2.4rem)] font-black leading-snug tracking-[-0.02em] text-bone">
                        “<?= e($visi) ?>”
                    </p>
                </div>
                <p class="mt-10 text-xs font-bold uppercase tracking-wider text-bone/60">
                    HIMA STEKOM · Periode <?= e($site['periode']) ?>
                </p>
            </div>

            <div class="border border-ink/15 bg-white p-8 sm:p-12 lg:col-span-7">
                <span class="bg-cobalt px-3 py-1 text-xs font-bold uppercase text-bone">Misi</span>
                <ol class="mt-8 divide-y divide-ink/10">
                    <?php foreach ($misi as $index => $butir): ?>
                        <li class="flex gap-6 py-5 first:pt-0 last:pb-0">
                            <span class="font-display text-2xl font-black text-cobalt"><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                            <p class="text-base leading-relaxed text-ink/80 sm:text-lg"><?= e($butir) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="bg-ink py-16 text-bone sm:py-24">
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
        <div class="reveal flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
            <div>
                <h2 class="font-display text-[clamp(2.5rem,6vw,5rem)] font-black uppercase leading-[0.9] tracking-[-0.04em]">
                    Orang-orang di<br>
                    <span class="text-gold">balik layar.</span>
                </h2>
            </div>
            <p class="max-w-md text-base leading-relaxed text-bone/75">
                Pengurus inti dan koordinator divisi yang menjalankan arah gerak HIMA STEKOM.
            </p>
        </div>

        <div class="reveal mt-12">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gold">Pengurus Inti</h3>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php foreach ($core as $person): ?>
                    <?php $foto = trim((string) ($person['foto'] ?? '')); ?>
                    <article class="group border border-bone/15 bg-ink-soft transition hover:border-gold">
                        <div class="aspect-[4/5] overflow-hidden bg-cobalt-deep">
                            <?php if ($foto !== ''): ?>
                                <img
                                    src="<?= e(asset($foto)) ?>"
                                    alt="Foto <?= e($person['nama']) ?>"
                                    loading="lazy"
                                    class="h-full w-full object-cover"
                                >
                            <?php else: ?>
                                <span class="grid h-full w-full place-items-center bg-gold font-display text-4xl font-black text-ink">
                                    <?= e(initials((string) $person['nama'])) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-gold"><?= e($person['jabatan']) ?></p>
                            <h4 class="mt-2 font-display text-lg font-bold text-bone"><?= e($person['nama']) ?></h4>
                            <p class="mt-1 text-xs text-bone/60"><?= e($person['periode']) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($divisi !== []): ?>
            <div class="reveal mt-16">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gold">Koordinator Divisi</h3>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($divisi as $item): ?>
                        <?php $foto = trim((string) ($item['koordinator_foto'] ?? '')); ?>
                        <article class="flex items-center gap-4 border border-bone/15 bg-ink-soft p-5 transition hover:border-gold">
                            <span class="grid h-14 w-14 shrink-0 place-items-center overflow-hidden bg-cobalt font-display text-base font-black text-gold">
                                <?php if ($foto !== ''): ?>
                                    <img
                                        src="<?= e(asset($foto)) ?>"
                                        alt="Foto <?= e((string) ($item['koordinator'] ?? 'koordinator divisi')) ?>"
                                        loading="lazy"
                                        class="h-full w-full object-cover"
                                    >
                                <?php else: ?>
                                    <?= e(initials((string) ($item['koordinator'] ?? '?'))) ?>
                                <?php endif; ?>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-wider text-gold"><?= e($item['nama']) ?></p>
                                <h4 class="mt-1 font-display text-base font-bold text-bone truncate"><?= e($item['koordinator'] ?? 'Belum ditetapkan') ?></h4>
                                <p class="mt-0.5 text-xs text-bone/60">Koordinator Divisi</p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-bone py-16 text-ink sm:py-24">
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
        <div class="reveal flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
            <div>
                <h2 class="font-display text-[clamp(2.5rem,6vw,5rem)] font-black uppercase leading-[0.9] tracking-[-0.04em]">
                    Pegangan <span class="text-cobalt">kami.</span>
                </h2>
            </div>
            <p class="max-w-md text-base leading-relaxed text-muted">
                Tiga nilai yang kami jaga dalam setiap keputusan dan kegiatan.
            </p>
        </div>

        <div class="reveal mt-12 grid gap-6 lg:grid-cols-3">
            <?php foreach ($nilai as $index => $item): ?>
                <article class="border border-ink/15 bg-white p-8 flex flex-col justify-between">
                    <div>
                        <p class="font-display text-5xl font-black text-cobalt"><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></p>
                        <h3 class="mt-6 font-display text-2xl font-bold tracking-tight"><?= e($item['title']) ?></h3>
                        <p class="mt-3 text-base leading-relaxed text-muted"><?= e($item['description']) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="bg-bone pb-16 text-ink sm:pb-24">
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
        <div class="reveal grid gap-10 border-t border-ink/15 pt-16 lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-4">
                <h2 class="font-display text-[clamp(2.2rem,5vw,4rem)] font-black uppercase leading-[0.9] tracking-[-0.04em]">
                    Tumbuh<br>
                    <span class="text-cobalt">bertahap.</span>
                </h2>
                <p class="mt-4 text-base text-muted">Jejak perjalanan HIMA STEKOM dari masa ke masa.</p>
            </div>

            <div class="lg:col-span-7 lg:col-start-6">
                <ol class="divide-y divide-ink/10">
                    <?php foreach ($sejarah as $era): ?>
                        <li class="flex gap-6 py-6 first:pt-0 last:pb-0">
                            <span class="w-16 shrink-0 font-display text-xl font-black text-cobalt"><?= e($era['tahun']) ?></span>
                            <p class="text-base leading-relaxed text-ink/80 sm:text-lg"><?= e($era['teks']) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="bg-gold text-ink py-16 sm:py-20">
    <div class="mx-auto flex max-w-[1600px] flex-col gap-8 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <div>
            <span class="bg-ink px-3 py-1 text-xs font-bold uppercase text-bone">Bergabung</span>
            <h2 class="mt-4 font-display text-[clamp(2.5rem,6vw,5rem)] font-black uppercase leading-[0.88] tracking-[-0.045em]">
                Jadi bagian dari<br>
                <span>cerita ini<span class="text-cobalt">.</span></span>
            </h2>
        </div>
        <a href="mailto:<?= e($site['email']) ?>?subject=Gabung%20HIMA%20STEKOM" class="press inline-flex items-center gap-3 bg-ink px-8 py-5 text-lg font-bold text-bone hover:bg-cobalt">
            Hubungi pengurus
            <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
        </a>
    </div>
</section>
