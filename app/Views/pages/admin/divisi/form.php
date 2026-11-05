<?php

declare(strict_types=1);

$inputClass = 'mt-2 w-full border bg-white px-4 py-3 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:ring-2 focus:ring-cobalt/20';
$fieldError = static fn (string $key): bool => isset($errors[$key]);
$borderClass = static fn (string $key): string => $fieldError($key) ? 'border-red/50 focus:border-red' : 'border-ink/20 focus:border-cobalt';
?>
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <a href="<?= url('/admin/divisi') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted transition hover:text-ink">
            <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-chevron-left"/></svg>
            Semua divisi
        </a>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            <?= $isEdit ? 'Edit divisi' : 'Tambah divisi' ?><span class="text-cobalt">.</span>
        </h1>
    </div>
    <p class="hidden text-xs text-muted sm:block">
        <?= $isEdit ? 'Perbarui data divisi' : 'Bidang baru di struktur' ?>
    </p>
</div>

<form method="post" action="<?= e($action) ?>" class="mt-7 grid gap-4 lg:grid-cols-12">
    <?= csrf_field() ?>

    <div class="space-y-4 lg:col-span-8">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Informasi divisi</h2>

            <div class="mt-5">
                <label for="nama" class="block text-[13px] font-semibold text-ink">Nama divisi <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="<?= e((string) ($divisi['nama'] ?? '')) ?>"
                    required
                    maxlength="100"
                    data-slug-source
                    class="<?= e($inputClass . ' ' . $borderClass('nama')) ?> text-lg font-semibold"
                    placeholder="Web & Product"
                >
                <?php if ($fieldError('nama')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['nama']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <label for="slug" class="block text-[13px] font-semibold text-ink">Slug</label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="<?= e((string) ($divisi['slug'] ?? '')) ?>"
                    maxlength="100"
                    data-slug-target
                    class="<?= e($inputClass . ' ' . $borderClass('slug')) ?> text-xs tabular-nums"
                    placeholder="web-product"
                >
                <p class="mt-1.5 text-xs text-muted">Kosongkan untuk dibuat otomatis dari nama.</p>
                <?php if ($fieldError('slug')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['slug']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <label for="deskripsi" class="block text-[13px] font-semibold text-ink">Deskripsi <span class="text-red">*</span></label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    required
                    rows="6"
                    class="<?= e($inputClass . ' ' . $borderClass('deskripsi')) ?> resize-y leading-relaxed"
                    placeholder="Ceritakan fokus dan kegiatan divisi ini…"
                ><?= e((string) ($divisi['deskripsi'] ?? '')) ?></textarea>
                <?php if ($fieldError('deskripsi')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['deskripsi']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="space-y-4 lg:col-span-4">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Catatan</h2>
            <p class="mt-4 text-sm leading-relaxed text-muted">
                Divisi yang dihapus tidak menghapus pengurus. Pengurus terkait otomatis menjadi
                tanpa divisi dan tetap bisa diatur ulang.
            </p>
            <div class="mt-5 border-l-2 border-cobalt bg-bone p-4">
                <p class="text-xs leading-relaxed text-muted">
                    Koordinator divisi diambil dari pengurus dengan jabatan
                    “Koordinator Divisi” pada periode aktif.
                </p>
            </div>
        </div>

        <div class="border border-ink/10 bg-white p-4">
            <button type="submit" class="press flex w-full items-center justify-center gap-2 bg-cobalt px-5 py-3.5 text-sm font-bold text-bone transition hover:bg-ink">
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg>
                <?= $isEdit ? 'Simpan perubahan' : 'Tambah divisi' ?>
            </button>
            <a href="<?= url('/admin/divisi') ?>" class="mt-2 flex w-full items-center justify-center border border-ink/20 px-5 py-3 text-sm font-semibold text-muted transition hover:border-ink/40 hover:text-ink">
                Batal
            </a>
        </div>
    </div>
</form>
