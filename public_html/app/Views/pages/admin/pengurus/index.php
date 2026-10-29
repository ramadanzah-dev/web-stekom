<?php

declare(strict_types=1);

$jumlahAktif = count(array_filter($items, static fn (array $item): bool => (int) $item['aktif'] === 1));
?>
<form method="post" action="<?= url('/admin/pengurus/bulk-delete') ?>" id="bulk-delete-form" data-confirm-title="Hapus pengurus terpilih?" data-confirm="Semua pengurus yang dipilih akan dihapus dari daftar. Tindakan ini tidak bisa dibatalkan." data-confirm-label="Hapus terpilih">
    <?= csrf_field() ?>
</form>

<div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-xs font-medium text-muted">Struktur · <?= e((string) count($items)) ?> orang</p>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            Kelola pengurus<span class="text-cobalt">.</span>
        </h1>
        <p class="mt-3 max-w-lg text-sm leading-relaxed text-muted">
            Atur pengurus inti dan koordinator divisi yang tampil di halaman organisasi.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3 self-start sm:self-auto">
        <button
            type="submit"
            form="bulk-delete-form"
            id="bulk-delete-btn"
            disabled
            class="press inline-flex items-center gap-2 border border-red/30 bg-white px-4 py-3 text-sm font-bold text-red transition hover:bg-red hover:text-bone disabled:cursor-not-allowed disabled:opacity-40"
        >
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg>
            Hapus Terpilih <span data-bulk-count></span>
        </button>
        <a href="<?= url('/admin/pengurus/create') ?>" class="press inline-flex shrink-0 items-center justify-between gap-5 bg-cobalt px-5 py-3 text-sm font-bold text-bone transition hover:bg-ink">
            Tambah pengurus
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
        </a>
    </div>
</div>

<div class="mt-6 flex flex-wrap items-center gap-2 text-xs font-medium">
    <span class="border border-cobalt/25 bg-cobalt/5 px-3 py-1.5 text-cobalt"><?= e((string) $jumlahAktif) ?> aktif</span>
    <span class="border border-ink/15 bg-bone px-3 py-1.5 text-muted"><?= e((string) (count($items) - $jumlahAktif)) ?> nonaktif</span>
</div>

<?php if ($items === []): ?>
    <div class="mt-6 border border-dashed border-ink/20 bg-white p-10 text-center sm:p-14">
        <span class="mx-auto grid h-11 w-11 place-items-center bg-bone text-cobalt">
            <svg class="h-5 w-5" aria-hidden="true"><use href="#i-users"/></svg>
        </span>
        <p class="mt-5 font-display text-lg font-bold">Belum ada pengurus.</p>
        <p class="mt-2 text-sm text-muted">Tambahkan pengurus inti atau koordinator divisi pertama.</p>
        <a href="<?= url('/admin/pengurus/create') ?>" class="press mt-5 inline-flex items-center gap-2 bg-cobalt px-5 py-2.5 text-sm font-bold text-bone transition hover:bg-ink">
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
            Tambah pengurus
        </a>
    </div>
<?php else: ?>
    <div class="mt-6 overflow-hidden border border-ink/10 bg-white" data-bulk-table>
        <div class="divide-y divide-ink/10 md:hidden">
            <?php foreach ($items as $person): ?>
                <?php $foto = gambar_url($person['foto'] ?? null); ?>
                <article class="flex items-start gap-3 px-4 py-4">
                    <input
                        type="checkbox"
                        name="ids[]"
                        value="<?= $person['id'] ?>"
                        aria-label="Pilih: <?= e($person['nama']) ?>"
                        class="item-checkbox mt-1 h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                    >
                    <span class="relative grid h-11 w-11 shrink-0 place-items-center overflow-hidden bg-gold font-display text-xs font-black text-ink">
                        <?php if ($foto !== null): ?>
                            <img src="<?= e($foto) ?>" alt="" loading="lazy" class="h-full w-full object-cover">
                        <?php else: ?>
                            <?= e(initials((string) $person['nama'])) ?>
                        <?php endif; ?>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold"><?= e($person['nama']) ?></p>
                        <p class="mt-0.5 truncate text-[11px] text-muted"><?= e($person['jabatan']) ?> · <?= e($person['periode']) ?></p>
                        <div class="mt-2 flex items-center justify-between gap-2">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="inline-flex items-center gap-1 border px-1.5 py-0.5 text-[10px] font-semibold <?= (int) $person['aktif'] === 1 ? 'border-cobalt/25 bg-cobalt/5 text-cobalt' : 'border-ink/15 bg-bone text-muted' ?>">
                                    <?= (int) $person['aktif'] === 1 ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                                <?php if (!empty($person['divisi_nama'])): ?>
                                    <span class="inline-flex shrink-0 border border-ink/15 bg-bone px-1.5 py-0.5 text-[10px] font-medium text-ink"><?= e($person['divisi_nama']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="flex shrink-0 items-center gap-1.5">
                                <a href="<?= url('/admin/pengurus/' . $person['id'] . '/edit') ?>" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Edit pengurus: <?= e($person['nama']) ?>">
                                    <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-edit"/></svg>
                                </a>
                                <form method="post" action="<?= url('/admin/pengurus/' . $person['id'] . '/delete') ?>" data-confirm-title="Hapus pengurus ini?" data-confirm="Data pengurus “<?= e($person['nama']) ?>” akan dihapus dari daftar." data-confirm-label="Hapus pengurus">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-red/40 hover:bg-red/5 hover:text-red" aria-label="Hapus pengurus: <?= e($person['nama']) ?>">
                                        <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-trash"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-ink/10">
                        <th scope="col" class="w-12 px-5 py-3">
                            <input
                                type="checkbox"
                                data-select-all
                                aria-label="Pilih semua pengurus"
                                class="h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                            >
                        </th>
                        <th scope="col" class="px-5 py-3 text-xs font-semibold text-muted">Pengurus</th>
                        <th scope="col" class="hidden px-4 py-3 text-xs font-semibold text-muted md:table-cell">Jabatan</th>
                        <th scope="col" class="hidden px-4 py-3 text-xs font-semibold text-muted xl:table-cell">Divisi</th>
                        <th scope="col" class="hidden px-4 py-3 text-right text-xs font-semibold text-muted xl:table-cell">Urutan</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-muted">Status</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-muted">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink/10">
                    <?php foreach ($items as $person): ?>
                        <?php $foto = gambar_url($person['foto'] ?? null); ?>
                        <tr class="transition hover:bg-bone">
                            <td class="w-12 px-5 py-4">
                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="<?= $person['id'] ?>"
                                    aria-label="Pilih: <?= e($person['nama']) ?>"
                                    class="item-checkbox h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                                >
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="relative grid h-11 w-11 shrink-0 place-items-center overflow-hidden bg-gold font-display text-xs font-black text-ink">
                                        <?php if ($foto !== null): ?>
                                            <img src="<?= e($foto) ?>" alt="" loading="lazy" class="h-full w-full object-cover">
                                        <?php else: ?>
                                            <?= e(initials((string) $person['nama'])) ?>
                                        <?php endif; ?>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="max-w-[16rem] truncate text-sm font-semibold"><?= e($person['nama']) ?></p>
                                        <p class="mt-0.5 truncate text-xs text-muted"><?= e($person['periode']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden px-4 py-4 text-sm text-ink md:table-cell"><?= e($person['jabatan']) ?></td>
                            <td class="hidden px-4 py-4 xl:table-cell">
                                <?php if (!empty($person['divisi_nama'])): ?>
                                    <span class="inline-flex border border-ink/15 bg-bone px-2.5 py-1 text-[11px] font-medium text-ink"><?= e($person['divisi_nama']) ?></span>
                                <?php else: ?>
                                    <span class="text-xs text-muted">Pengurus inti</span>
                                <?php endif; ?>
                            </td>
                            <td class="hidden px-4 py-4 text-right text-xs tabular-nums text-muted xl:table-cell"><?= e(str_pad((string) $person['urutan'], 2, '0', STR_PAD_LEFT)) ?></td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap border px-2.5 py-1 text-[11px] font-semibold <?= (int) $person['aktif'] === 1 ? 'border-cobalt/25 bg-cobalt/5 text-cobalt' : 'border-ink/15 bg-bone text-muted' ?>">
                                    <span class="h-1.5 w-1.5 <?= (int) $person['aktif'] === 1 ? 'bg-cobalt' : 'bg-muted/50' ?>" aria-hidden="true"></span>
                                    <?= (int) $person['aktif'] === 1 ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="<?= url('/admin/pengurus/' . $person['id'] . '/edit') ?>" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Edit pengurus: <?= e($person['nama']) ?>">
                                        <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-edit"/></svg>
                                    </a>
                                    <form method="post" action="<?= url('/admin/pengurus/' . $person['id'] . '/delete') ?>" data-confirm-title="Hapus pengurus ini?" data-confirm="Data pengurus “<?= e($person['nama']) ?>” akan dihapus dari daftar." data-confirm-label="Hapus pengurus">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-red/40 hover:bg-red/5 hover:text-red" aria-label="Hapus pengurus: <?= e($person['nama']) ?>">
                                            <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-trash"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
