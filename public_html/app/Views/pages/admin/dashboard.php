<?php

declare(strict_types=1);

$namaDepan = explode(' ', trim((string) $admin['nama']))[0] ?? 'Pengurus';
?>
<div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
    <div>
        <p class="text-xs font-medium text-muted"><?= e(tanggal_id(date('Y-m-d'))) ?></p>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            Halo, <?= e($namaDepan) ?><span class="text-cobalt">.</span>
        </h1>
        <p class="mt-3 max-w-xl text-sm leading-relaxed text-muted">
            Ringkasan konten situs hari ini. Tambah berita baru atau rapikan data pengurus dan divisi.
        </p>
    </div>

    <a href="<?= url('/admin/berita/create') ?>" class="press inline-flex shrink-0 items-center justify-between gap-5 self-start bg-cobalt px-5 py-3 text-sm font-bold text-bone transition hover:bg-ink sm:self-auto">
        Tulis berita
        <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
    </a>
</div>

<div class="mt-8 border border-ink/10 bg-white">
    <div class="grid grid-cols-1 divide-y divide-ink/10 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
        <?php foreach ($stats as $stat): ?>
            <a href="<?= e($stat['href']) ?>" class="group p-5 transition hover:bg-bone sm:p-6">
                <p class="text-[13px] font-medium text-muted"><?= e($stat['label']) ?></p>
                <p class="mt-3 font-display text-[clamp(2rem,3vw,2.6rem)] font-black leading-none tracking-[-0.04em] tabular-nums">
                    <?= e((string) $stat['value']) ?>
                </p>
                <div class="mt-4 flex items-center justify-between gap-4">
                    <p class="text-xs text-muted"><?= e($stat['description']) ?></p>
                    <svg class="h-4 w-4 shrink-0 text-cobalt transition-transform duration-200 group-hover:-translate-y-0.5 group-hover:translate-x-0.5" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-stretch">
    <section class="flex flex-col border border-ink/10 bg-white lg:col-span-7">
        <div class="flex items-end justify-between gap-4 p-5 sm:p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Berita terbaru</h2>
            <a href="<?= url('/admin/berita') ?>" class="text-[13px] font-semibold text-cobalt transition hover:text-ink">Kelola semua</a>
        </div>

        <?php if ($beritaTerbaru === []): ?>
            <div class="mx-5 mb-5 border border-dashed border-ink/20 p-6 text-center text-sm text-muted sm:mx-6 sm:mb-6">
                Belum ada berita. <a href="<?= url('/admin/berita/create') ?>" class="font-semibold text-cobalt hover:underline">Tulis yang pertama</a>.
            </div>
        <?php else: ?>
            <ul class="flex-1 divide-y divide-ink/10 border-t border-ink/10">
                <?php foreach ($beritaTerbaru as $item): ?>
                    <li class="flex items-center gap-3 px-5 py-3.5 sm:px-6">
                        <span class="grid h-10 w-10 shrink-0 place-items-center bg-bone font-display text-sm font-bold tabular-nums">
                            <?= e(date('d', strtotime((string) $item['diterbitkan_pada']))) ?>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold leading-snug"><?= e($item['judul']) ?></p>
                            <p class="mt-0.5 text-xs text-muted">
                                <?= e($item['kategori']) ?> · <?= e(tanggal_id((string) $item['diterbitkan_pada'], false)) ?>
                            </p>
                        </div>
                        <a href="<?= url('/admin/berita/' . $item['id'] . '/edit') ?>" class="grid h-8 w-8 shrink-0 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Edit berita: <?= e($item['judul']) ?>">
                            <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-edit"/></svg>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="<?= url('/admin/berita') ?>" class="mt-auto flex items-center justify-between border-t border-ink/10 px-5 py-3.5 text-[13px] font-semibold text-muted transition hover:bg-bone hover:text-ink sm:px-6">
            Semua berita
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
        </a>
    </section>

    <section class="flex flex-col border border-ink/10 bg-white lg:col-span-5">
        <div class="flex items-end justify-between gap-4 p-5 sm:p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Pengurus terbaru</h2>
            <a href="<?= url('/admin/pengurus/create') ?>" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Tambah pengurus">
                <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-plus"/></svg>
            </a>
        </div>

        <?php if ($pengurusTerbaru === []): ?>
            <div class="mx-5 mb-5 border border-dashed border-ink/20 p-6 text-center text-sm text-muted sm:mx-6 sm:mb-6">
                Belum ada data pengurus.
            </div>
        <?php else: ?>
            <ul class="flex-1 divide-y divide-ink/10 border-t border-ink/10">
                <?php foreach ($pengurusTerbaru as $person): ?>
                    <?php $foto = gambar_url($person['foto'] ?? null); ?>
                    <li class="flex items-center gap-3 px-5 py-3.5 sm:px-6">
                        <span class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden bg-gold font-display text-xs font-black text-ink">
                            <?php if ($foto !== null): ?>
                                <img src="<?= e($foto) ?>" alt="Foto <?= e($person['nama']) ?>" loading="lazy" class="h-full w-full object-cover">
                            <?php else: ?>
                                <?= e(initials((string) $person['nama'])) ?>
                            <?php endif; ?>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold"><?= e($person['nama']) ?></p>
                            <p class="truncate text-xs text-muted"><?= e($person['jabatan']) ?> · <?= e($person['periode']) ?></p>
                        </div>
                        <span class="shrink-0 border px-2 py-1 text-[11px] font-semibold <?= (int) $person['aktif'] === 1 ? 'border-cobalt/25 bg-cobalt/5 text-cobalt' : 'border-ink/15 bg-bone text-muted' ?>">
                            <?= (int) $person['aktif'] === 1 ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="<?= url('/admin/pengurus') ?>" class="mt-auto flex items-center justify-between border-t border-ink/10 px-5 py-3.5 text-[13px] font-semibold text-muted transition hover:bg-bone hover:text-ink sm:px-6">
            Kelola pengurus
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
        </a>
    </section>
</div>
