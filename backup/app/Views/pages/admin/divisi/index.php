<?php

declare(strict_types=1);
?>
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

    <a href="<?= url('/admin/divisi/create') ?>" class="press inline-flex shrink-0 items-center justify-between gap-5 self-start bg-cobalt px-5 py-3 text-sm font-bold text-bone transition hover:bg-ink sm:self-auto">
        Tambah divisi
        <svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>
    </a>
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
    <div class="mt-6 border border-ink/10 bg-white">
        <div class="divide-y divide-ink/10">
            <?php foreach ($items as $item): ?>
                <article class="grid grid-cols-[1fr_auto] items-start gap-x-4 gap-y-3 px-5 py-5 transition hover:bg-bone sm:grid-cols-12 sm:items-center sm:px-6">
                    <div class="col-span-2 sm:col-span-4">
                        <h2 class="font-display text-lg font-bold leading-tight tracking-[-0.02em]"><?= e($item['nama']) ?></h2>
                        <p class="mt-1 text-xs tabular-nums text-muted">/<?= e($item['slug']) ?></p>
                    </div>

                    <p class="col-span-2 text-sm leading-relaxed text-muted line-clamp-2 sm:col-span-4"><?= e($item['deskripsi'] ?? '') ?></p>

                    <p class="text-xs font-medium text-muted sm:col-span-2">
                        <?= e((string) $item['jumlah_pengurus']) ?> pengurus
                    </p>

                    <div class="flex items-center justify-end gap-1.5 sm:col-span-2">
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
                </article>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
