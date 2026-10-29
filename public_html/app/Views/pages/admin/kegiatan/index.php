<?php

declare(strict_types=1);

?>
<form method="post" action="<?= url('/admin/kegiatan/bulk-delete') ?>" id="bulk-delete-form" data-confirm-title="Hapus kegiatan terpilih?" data-confirm="Semua kegiatan yang dipilih akan dihapus permanen. Tindakan ini tidak bisa dibatalkan." data-confirm-label="Hapus terpilih">
    <?= csrf_field() ?>
</form>

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="font-display text-[clamp(1.8rem,3.4vw,2.2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            Kelola Kegiatan<span class="text-cobalt">.</span>
        </h1>
        <p class="mt-1 text-sm text-muted">Daftar agenda dan kegiatan yang tampil di halaman Beranda.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3">
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
        <a
            href="<?= url('/admin/kegiatan/tambah') ?>"
            class="press inline-flex items-center gap-2 bg-cobalt px-5 py-3 text-sm font-bold text-bone transition hover:bg-ink"
        >
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
            Tambah Kegiatan
        </a>
    </div>
</div>

<?php if (empty($items)): ?>
    <div class="mt-8 border border-ink/10 bg-white p-12 text-center">
        <p class="text-base text-muted">Belum ada kegiatan yang ditambahkan.</p>
        <a href="<?= url('/admin/kegiatan/tambah') ?>" class="press mt-4 inline-flex items-center gap-2 bg-cobalt px-4 py-2 text-xs font-bold text-bone">
            Tambah Kegiatan Pertama
        </a>
    </div>
<?php else: ?>
    <div class="mt-8 overflow-x-auto border border-ink/10 bg-white" data-bulk-table>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-ink/10 bg-bone/60 text-[11px] font-bold uppercase tracking-wider text-muted">
                    <th class="p-4 w-10">
                        <input
                            type="checkbox"
                            data-select-all
                            aria-label="Pilih semua kegiatan"
                            class="h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                        >
                    </th>
                    <th class="p-4">Tanggal &amp; Waktu</th>
                    <th class="p-4">Kegiatan</th>
                    <th class="p-4">Kategori &amp; Lokasi</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ink/10 text-sm">
                <?php foreach ($items as $item): ?>
                    <tr class="transition hover:bg-bone/30">
                        <td class="p-4">
                            <input
                                type="checkbox"
                                name="ids[]"
                                value="<?= $item['id'] ?>"
                                aria-label="Pilih: <?= e($item['judul']) ?>"
                                class="item-checkbox h-4 w-4 rounded border-ink/30 text-cobalt focus:ring-cobalt/20"
                            >
                        </td>
                        <td class="p-4 whitespace-nowrap font-mono text-xs tabular-nums text-muted">
                            <?= e($item['tanggal_mulai']) ?>
                        </td>
                        <td class="p-4 font-semibold text-ink">
                            <?= e($item['judul']) ?>
                            <?php if (!empty($item['deskripsi'])): ?>
                                <p class="mt-0.5 text-xs font-normal text-muted line-clamp-1"><?= e($item['deskripsi']) ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-muted">
                            <span class="inline-block bg-bone px-2 py-0.5 text-xs font-semibold text-ink"><?= e($item['kategori']) ?></span>
                            <?php if (!empty($item['lokasi'])): ?>
                                <span class="block mt-1 text-xs text-muted">📍 <?= e($item['lokasi']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <?php if ((int) $item['aktif'] === 1): ?>
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 bg-bone px-2.5 py-1 text-xs font-semibold text-muted">
                                    <span class="h-1.5 w-1.5 rounded-full bg-muted"></span>
                                    Nonaktif
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                <a
                                    href="<?= url('/admin/kegiatan/' . $item['id'] . '/edit') ?>"
                                    class="press inline-flex items-center gap-1 border border-ink/20 bg-white px-3 py-1.5 text-xs font-bold text-ink hover:border-cobalt hover:text-cobalt"
                                >
                                    Edit
                                </a>
                                <button
                                    type="button"
                                    data-confirm-delete="<?= url('/admin/kegiatan/' . $item['id'] . '/hapus') ?>"
                                    data-confirm-title="Hapus Kegiatan"
                                    data-confirm-message="Yakin ingin menghapus kegiatan “<?= e($item['judul']) ?>”? Tindakan ini tidak dapat dibatalkan."
                                    class="press inline-flex items-center gap-1 border border-red/30 bg-white px-3 py-1.5 text-xs font-bold text-red hover:bg-red hover:text-bone"
                                >
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
