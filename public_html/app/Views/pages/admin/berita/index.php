<?php

declare(strict_types=1);
?>
<form method="post" action="<?= url('/admin/berita/bulk-delete') ?>" id="bulk-delete-form" data-confirm-title="Hapus berita terpilih?" data-confirm="Semua berita yang dipilih akan dihapus permanen. Tindakan ini tidak bisa dibatalkan." data-confirm-label="Hapus terpilih">
    <?= csrf_field() ?>
</form>

<div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-xs font-medium text-muted">Konten · <?= e((string) $total) ?> tulisan</p>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            Kelola berita<span class="text-cobalt">.</span>
        </h1>
        <p class="mt-3 max-w-lg text-sm leading-relaxed text-muted">
            Tulis, sunting, dan atur kabar yang tampil di halaman berita serta beranda.
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
        <a href="<?= url('/admin/berita/create') ?>" class="press inline-flex shrink-0 items-center justify-between gap-5 bg-cobalt px-5 py-3 text-sm font-bold text-bone transition hover:bg-ink">
            Tambah berita
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
        </a>
    </div>
</div>

<form method="get" action="<?= url('/admin/berita') ?>" class="mt-7 flex gap-2">
    <div class="relative min-w-0 flex-1">
        <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-muted" aria-hidden="true"><use href="#i-search"/></svg>
        <label for="q" class="sr-only">Cari berita</label>
        <input
            type="search"
            id="q"
            name="q"
            value="<?= e($q) ?>"
            placeholder="Cari judul, ringkasan, atau penulis…"
            class="w-full border border-ink/20 bg-white py-3 pl-11 pr-4 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:ring-2 focus:ring-cobalt/20"
        >
    </div>
    <div class="flex gap-2">
        <button type="submit" class="press bg-ink px-5 py-3 text-sm font-bold text-bone transition hover:bg-cobalt">Cari</button>
        <?php if ($q !== ''): ?>
            <a href="<?= url('/admin/berita') ?>" class="border border-ink/20 px-4 py-3 text-sm font-medium text-muted transition hover:border-ink/40 hover:text-ink">Reset</a>
        <?php endif; ?>
    </div>
</form>

<?php if ($items === []): ?>
    <div class="mt-6 border border-dashed border-ink/20 bg-white p-10 text-center sm:p-14">
        <span class="mx-auto grid h-11 w-11 place-items-center bg-bone text-cobalt">
            <svg class="h-5 w-5" aria-hidden="true"><use href="#i-news"/></svg>
        </span>
        <p class="mt-5 font-display text-lg font-bold"><?= $q !== '' ? 'Tidak ada hasil.' : 'Belum ada berita.' ?></p>
        <p class="mt-2 text-sm text-muted">
            <?= $q !== '' ? 'Coba kata kunci lain atau reset pencarian.' : 'Mulai dengan menulis kabar pertama himpunan.' ?>
        </p>
        <a href="<?= url('/admin/berita/create') ?>" class="press mt-5 inline-flex items-center gap-2 bg-cobalt px-5 py-2.5 text-sm font-bold text-bone transition hover:bg-ink">
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
            Tambah berita
        </a>
    </div>
<?php else: ?>
    <div class="mt-6 overflow-hidden border border-ink/10 bg-white" data-bulk-table>
        <div class="divide-y divide-ink/10 md:hidden">
            <?php foreach ($items as $item): ?>
                <?php $gambar = gambar_url($item['gambar'] ?? null); ?>
                <article class="flex items-start gap-3 px-4 py-4">
                    <input
                        type="checkbox"
                        name="ids[]"
                        value="<?= $item['id'] ?>"
                        aria-label="Pilih: <?= e($item['judul']) ?>"
                        class="item-checkbox mt-1 h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                    >
                    <span class="relative h-12 w-16 shrink-0 overflow-hidden bg-bone">
                        <?php if ($gambar !== null): ?>
                            <img src="<?= e($gambar) ?>" alt="" loading="lazy" class="h-full w-full object-cover">
                        <?php endif; ?>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="line-clamp-2 text-sm font-semibold leading-snug"><?= e($item['judul']) ?></p>
                        <div class="mt-2 flex items-center justify-between gap-2">
                            <p class="min-w-0 whitespace-nowrap text-[10px] leading-relaxed">
                                <span class="font-semibold text-cobalt"><?= e($item['kategori']) ?></span>
                                <span class="text-muted"> · <?= e(tanggal_id((string) $item['diterbitkan_pada'])) ?></span>
                            </p>
                            <div class="flex shrink-0 items-center gap-1.5">
                                <a href="<?= url('/berita/' . rawurlencode((string) $item['slug'])) ?>" target="_blank" rel="noopener noreferrer" class="hidden h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-ink hover:text-ink sm:grid" aria-label="Lihat berita: <?= e($item['judul']) ?>">
                                    <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-eye"/></svg>
                                </a>
                                <a href="<?= url('/admin/berita/' . $item['id'] . '/edit') ?>" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Edit berita: <?= e($item['judul']) ?>">
                                    <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-edit"/></svg>
                                </a>
                                <form method="post" action="<?= url('/admin/berita/' . $item['id'] . '/delete') ?>" data-confirm-title="Hapus berita ini?" data-confirm="Berita “<?= e($item['judul']) ?>” akan dihapus permanen. Tindakan ini tidak bisa dibatalkan." data-confirm-label="Hapus berita">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-red/40 hover:bg-red/5 hover:text-red" aria-label="Hapus berita: <?= e($item['judul']) ?>">
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
                                aria-label="Pilih semua berita"
                                class="h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                            >
                        </th>
                        <th scope="col" class="px-5 py-3 text-xs font-semibold text-muted">Berita</th>
                        <th scope="col" class="hidden px-4 py-3 text-xs font-semibold text-muted md:table-cell">Kategori</th>
                        <th scope="col" class="hidden px-4 py-3 text-xs font-semibold text-muted xl:table-cell">Terbit</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-muted">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink/10">
                    <?php foreach ($items as $item): ?>
                        <?php $gambar = gambar_url($item['gambar'] ?? null); ?>
                        <tr class="transition hover:bg-bone">
                            <td class="w-12 px-5 py-4">
                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="<?= $item['id'] ?>"
                                    aria-label="Pilih: <?= e($item['judul']) ?>"
                                    class="item-checkbox h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                                >
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="relative h-12 w-16 shrink-0 overflow-hidden bg-bone">
                                        <?php if ($gambar !== null): ?>
                                            <img src="<?= e($gambar) ?>" alt="" loading="lazy" class="h-full w-full object-cover">
                                        <?php endif; ?>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="max-w-[12rem] truncate text-sm font-semibold lg:max-w-[14rem] xl:max-w-[22rem]"><?= e($item['judul']) ?></p>
                                        <p class="mt-0.5 max-w-[12rem] truncate text-xs text-muted lg:max-w-[14rem] xl:max-w-[22rem]">/berita/<?= e($item['slug']) ?></p>
                                        <p class="mt-0.5 text-[11px] text-muted xl:hidden"><?= e(tanggal_id((string) $item['diterbitkan_pada'])) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden px-4 py-4 md:table-cell">
                                <span class="inline-flex border border-cobalt/25 bg-cobalt/5 px-2.5 py-1 text-[11px] font-semibold text-cobalt"><?= e($item['kategori']) ?></span>
                            </td>
                            <td class="hidden whitespace-nowrap px-4 py-4 text-xs tabular-nums text-muted xl:table-cell"><?= e(tanggal_id((string) $item['diterbitkan_pada'])) ?></td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="<?= url('/berita/' . rawurlencode((string) $item['slug'])) ?>" target="_blank" rel="noopener noreferrer" class="hidden h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-ink hover:text-ink sm:grid" aria-label="Lihat berita: <?= e($item['judul']) ?>">
                                        <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-eye"/></svg>
                                    </a>
                                    <a href="<?= url('/admin/berita/' . $item['id'] . '/edit') ?>" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Edit berita: <?= e($item['judul']) ?>">
                                        <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-edit"/></svg>
                                    </a>
                                    <form method="post" action="<?= url('/admin/berita/' . $item['id'] . '/delete') ?>" data-confirm-title="Hapus berita ini?" data-confirm="Berita “<?= e($item['judul']) ?>” akan dihapus permanen. Tindakan ini tidak bisa dibatalkan." data-confirm-label="Hapus berita">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-red/40 hover:bg-red/5 hover:text-red" aria-label="Hapus berita: <?= e($item['judul']) ?>">
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
