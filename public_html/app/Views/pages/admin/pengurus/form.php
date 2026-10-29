<?php

declare(strict_types=1);

$foto = gambar_url($pengurus['foto'] ?? null);
$divisiTerpilih = (string) ($pengurus['divisi_id'] ?? '');
$aktif = (string) ($pengurus['aktif'] ?? '1') === '1';

$inputClass = 'mt-2 w-full border bg-white px-4 py-3 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:ring-2 focus:ring-cobalt/20';
$fieldError = static fn (string $key): bool => isset($errors[$key]);
$borderClass = static fn (string $key): string => $fieldError($key) ? 'border-red/50 focus:border-red' : 'border-ink/20 focus:border-cobalt';
?>
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <a href="<?= url('/admin/pengurus') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted transition hover:text-ink">
            <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-chevron-left"/></svg>
            Semua pengurus
        </a>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            <?= $isEdit ? 'Edit pengurus' : 'Tambah pengurus' ?><span class="text-cobalt">.</span>
        </h1>
    </div>
    <p class="hidden text-xs text-muted sm:block">
        <?= $isEdit ? 'Perbarui data pengurus' : 'Anggota baru di struktur' ?>
    </p>
</div>

<form method="post" action="<?= e($action) ?>" enctype="multipart/form-data" class="mt-7 grid gap-4 lg:grid-cols-12">
    <?= csrf_field() ?>

    <div class="space-y-4 lg:col-span-7">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Identitas</h2>

            <div class="mt-5">
                <label for="nama" class="block text-[13px] font-semibold text-ink">Nama lengkap <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="<?= e((string) ($pengurus['nama'] ?? '')) ?>"
                    required
                    maxlength="100"
                    class="<?= e($inputClass . ' ' . $borderClass('nama')) ?>"
                    placeholder="Nama pengurus"
                >
                <?php if ($fieldError('nama')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['nama']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <label for="jabatan" class="block text-[13px] font-semibold text-ink">Jabatan <span class="text-red">*</span></label>
                <?php $currentJabatan = (string) ($pengurus['jabatan'] ?? ''); ?>
                <select
                    id="jabatan"
                    name="jabatan"
                    required
                    class="<?= e($inputClass . ' ' . $borderClass('jabatan')) ?>"
                >
                    <option value="">— Pilih Jabatan —</option>
                    <option value="Ketua Umum" <?= $currentJabatan === 'Ketua Umum' ? 'selected' : '' ?>>Ketua Umum</option>
                    <option value="Wakil Ketua Umum" <?= $currentJabatan === 'Wakil Ketua Umum' ? 'selected' : '' ?>>Wakil Ketua Umum</option>
                    <option value="Sekretaris Umum" <?= $currentJabatan === 'Sekretaris Umum' ? 'selected' : '' ?>>Sekretaris Umum</option>
                    <option value="Bendahara Umum" <?= $currentJabatan === 'Bendahara Umum' ? 'selected' : '' ?>>Bendahara Umum</option>
                    <option value="Koordinator Divisi" <?= $currentJabatan === 'Koordinator Divisi' ? 'selected' : '' ?>>Koordinator Divisi</option>
                    <option value="Anggota" <?= $currentJabatan === 'Anggota' ? 'selected' : '' ?>>Anggota</option>
                </select>
                <?php if ($fieldError('jabatan')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['jabatan']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="divisi_id" class="block text-[13px] font-semibold text-ink">Divisi</label>
                    <select id="divisi_id" name="divisi_id" class="<?= e($inputClass . ' ' . $borderClass('divisi_id')) ?>">
                        <option value="">— Pengurus inti —</option>
                        <?php foreach ($divisiList as $divisi): ?>
                            <option value="<?= e((string) $divisi['id']) ?>" <?= $divisiTerpilih === (string) $divisi['id'] ? 'selected' : '' ?>>
                                <?= e($divisi['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($fieldError('divisi_id')): ?>
                        <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['divisi_id']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="periode" class="block text-[13px] font-semibold text-ink">Periode <span class="text-red">*</span></label>
                    <input
                        type="text"
                        id="periode"
                        name="periode"
                        value="<?= e((string) ($pengurus['periode'] ?? '')) ?>"
                        required
                        maxlength="20"
                        class="<?= e($inputClass . ' ' . $borderClass('periode')) ?> tabular-nums"
                        placeholder="2026/2027"
                    >
                    <?php if ($fieldError('periode')): ?>
                        <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['periode']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="urutan" class="block text-[13px] font-semibold text-ink">Urutan tampil</label>
                    <input
                        type="number"
                        id="urutan"
                        name="urutan"
                        value="<?= e((string) ($pengurus['urutan'] ?? '0')) ?>"
                        min="0"
                        max="255"
                        class="<?= e($inputClass . ' ' . $borderClass('urutan')) ?> tabular-nums"
                    >
                    <p class="mt-1.5 text-xs text-muted">Angka kecil tampil lebih dulu.</p>
                    <?php if ($fieldError('urutan')): ?>
                        <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['urutan']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <span class="block text-[13px] font-semibold text-ink">Status</span>
                    <label for="aktif" class="mt-2 flex cursor-pointer items-center gap-3 border border-ink/20 bg-white px-4 py-3 transition hover:border-ink/40">
                        <input
                            type="checkbox"
                            id="aktif"
                            name="aktif"
                            value="1"
                            <?= $aktif ? 'checked' : '' ?>
                            class="h-4 w-4 accent-cobalt"
                        >
                        <span class="text-sm text-muted">Tampilkan di situs</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-4 lg:col-span-5">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Foto</h2>

            <div class="mx-auto mt-4 max-w-[14rem] overflow-hidden border border-dashed border-ink/20 bg-bone">
                <img
                    data-image-preview
                    src="<?= e($foto ?? '') ?>"
                    alt="Pratinjau foto pengurus"
                    class="aspect-[4/5] w-full object-cover <?= $foto === null ? 'hidden' : '' ?>"
                >
                <div data-image-empty class="flex aspect-[4/5] flex-col items-center justify-center gap-2 text-muted <?= $foto !== null ? 'hidden' : '' ?>">
                    <svg class="h-7 w-7" aria-hidden="true"><use href="#i-image"/></svg>
                    <span class="text-xs">Belum ada foto</span>
                </div>
            </div>

            <label for="foto" class="mt-4 block text-[13px] font-semibold text-ink">Unggah foto</label>
            <div class="mt-2 flex items-center gap-3 border border-ink/15 bg-white px-2 py-2 transition focus-within:border-cobalt focus-within:ring-2 focus-within:ring-cobalt/20" data-file-field>
                <label for="foto" class="press inline-flex shrink-0 cursor-pointer items-center gap-2 bg-cobalt px-3.5 py-2 text-xs font-semibold text-bone transition hover:bg-ink">
                    <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-upload"/></svg>
                    Pilih foto
                </label>
                <span data-file-name class="min-w-0 truncate text-xs text-muted" aria-live="polite">Belum ada file dipilih</span>
                <input
                    type="file"
                    id="foto"
                    name="foto"
                    accept="image/jpeg,image/png,image/webp"
                    data-image-input
                    class="sr-only"
                >
            </div>
            <p class="mt-2 text-xs leading-relaxed text-muted">JPG, PNG, atau WebP · maks. 2 MB · rasio 4:5 disarankan.</p>
            <?php if ($fieldError('foto')): ?>
                <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['foto']) ?></p>
            <?php endif; ?>
        </div>

        <div class="border border-ink/10 bg-white p-4 lg:sticky lg:top-24">
            <button type="submit" class="press flex w-full items-center justify-center gap-2 bg-cobalt px-5 py-3.5 text-sm font-bold text-bone transition hover:bg-ink">
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg>
                <?= $isEdit ? 'Simpan perubahan' : 'Tambah pengurus' ?>
            </button>
            <a href="<?= url('/admin/pengurus') ?>" class="mt-2 flex w-full items-center justify-center border border-ink/20 px-5 py-3 text-sm font-semibold text-muted transition hover:border-ink/40 hover:text-ink">
                Batal
            </a>
        </div>
    </div>
</form>
