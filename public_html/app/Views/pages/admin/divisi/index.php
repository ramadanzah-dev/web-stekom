<?php

declare(strict_types=1);
?>
<form method="post" action="<?= url('/admin/divisi/bulk-delete') ?>" id="bulk-delete-form" data-confirm-title="Hapus divisi terpilih?" data-confirm="Semua divisi yang dipilih akan dihapus. Pengurus terkait akan menjadi tanpa divisi." data-confirm-label="Hapus terpilih">
    <?= csrf_field() ?>
</form>

<div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-xs font-medium text-muted">Organisasi · <?= e((string) count($items)) ?> divisi</p>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            Kelola divisi<span class="text-cobalt">.</span>
        </h1>
        <p class="mt-3 max-w-lg text-sm leading-relaxed text-muted">
            Setiap divisi menjadi rumah belajar anggota dan ditampilkan di halaman organisasi.
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
        <a href="<?= url('/admin/divisi/create') ?>" class="press inline-flex shrink-0 items-center justify-between gap-5 bg-cobalt px-5 py-3 text-sm font-bold text-bone transition hover:bg-ink">
            Tambah divisi
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
        </a>
    </div>
</div>

<?php if ($items === []): ?>
    <div class="mt-6 border border-dashed border-ink/20 bg-white p-10 text-center sm:p-14">
        <span class="mx-auto grid h-11 w-11 place-items-center bg-bone text-cobalt">
            <svg class="h-5 w-5" aria-hidden="true"><use href="#i-layers"/></svg>
        </span>
        <p class="mt-5 font-display text-lg font-bold">Belum ada divisi.</p>
        <p class="mt-2 text-sm text-muted">Tambahkan divisi pertama untuk mulai menata struktur.</p>
        <a href="<?= url('/admin/divisi/create') ?>" class="press mt-5 inline-flex items-center gap-2 bg-cobalt px-5 py-2.5 text-sm font-bold text-bone transition hover:bg-ink">
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
            Tambah divisi
        </a>
    </div>
<?php else: ?>
    <div class="mt-6 overflow-hidden border border-ink/10 bg-white" data-bulk-table>
        <div class="divide-y divide-ink/10 md:hidden">
            <?php foreach ($items as $item): ?>
                <article class="flex items-start gap-3 px-4 py-4">
                    <input
                        type="checkbox"
                        name="ids[]"
                        value="<?= $item['id'] ?>"
                        aria-label="Pilih: <?= e($item['nama']) ?>"
                        class="item-checkbox mt-1 h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                    >
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold leading-snug"><?= e($item['nama']) ?></p>
                        <p class="mt-0.5 text-xs text-muted">/<?= e($item['slug']) ?></p>
                        <p class="mt-2 text-xs leading-relaxed text-muted line-clamp-2"><?= e($item['deskripsi'] ?? '') ?></p>
                        <div class="mt-3 flex items-center justify-between gap-2">
                            <span class="inline-flex border border-cobalt/25 bg-cobalt/5 px-2.5 py-1 text-[11px] font-semibold text-cobalt"><?= e((string) $item['jumlah_pengurus']) ?> pengurus</span>
                            <div class="flex shrink-0 items-center gap-1.5">
                                <a href="<?= url('/admin/divisi/' . $item['id'] . '/edit') ?>" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Edit divisi: <?= e($item['nama']) ?>">
                                    <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-edit"/></svg>
                                </a>
                                <form method="post" action="<?= url('/admin/divisi/' . $item['id'] . '/delete') ?>" data-confirm-title="Hapus divisi ini?" data-confirm="Divisi “<?= e($item['nama']) ?>” akan dihapus. Pengurus terkait akan menjadi tanpa divisi." data-confirm-label="Hapus divisi">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-red/40 hover:bg-red/5 hover:text-red" aria-label="Hapus divisi: <?= e($item['nama']) ?>">
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
                                aria-label="Pilih semua divisi"
                                class="h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                            >
                        </th>
                        <th scope="col" class="px-5 py-3 text-xs font-semibold text-muted">Divisi</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-muted">Deskripsi</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-muted">Pengurus</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-muted">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink/10">
                    <?php foreach ($items as $item): ?>
                        <tr class="transition hover:bg-bone">
                            <td class="w-12 px-5 py-4">
                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="<?= $item['id'] ?>"
                                    aria-label="Pilih: <?= e($item['nama']) ?>"
                                    class="item-checkbox h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                                >
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm font-bold"><?= e($item['nama']) ?></p>
                                <p class="mt-0.5 text-xs text-muted">/<?= e($item['slug']) ?></p>
                            </td>
                            <td class="max-w-md px-4 py-4 text-sm text-muted">
                                <p class="line-clamp-2"><?= e($item['deskripsi'] ?? '-') ?></p>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-xs font-semibold text-cobalt">
                                <?= e((string) $item['jumlah_pengurus']) ?> pengurus
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="<?= url('/admin/divisi/' . $item['id'] . '/edit') ?>" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-cobalt hover:bg-cobalt hover:text-bone" aria-label="Edit divisi: <?= e($item['nama']) ?>">
                                        <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-edit"/></svg>
                                    </a>
                                    <form method="post" action="<?= url('/admin/divisi/' . $item['id'] . '/delete') ?>" data-confirm-title="Hapus divisi ini?" data-confirm="Divisi “<?= e($item['nama']) ?>” akan dihapus. Pengurus terkait akan menjadi tanpa divisi." data-confirm-label="Hapus divisi">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="grid h-8 w-8 place-items-center border border-ink/15 text-muted transition hover:border-red/40 hover:bg-red/5 hover:text-red" aria-label="Hapus divisi: <?= e($item['nama']) ?>">
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
