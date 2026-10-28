<?php

declare(strict_types=1);

$gambar = gambar_url($berita['gambar'] ?? null);

$inputClass = 'mt-2 w-full border bg-white px-4 py-3 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:ring-2 focus:ring-cobalt/20';
$fieldError = static fn (string $key): bool => isset($errors[$key]);
$borderClass = static fn (string $key): string => $fieldError($key) ? 'border-red/50 focus:border-red' : 'border-ink/20 focus:border-cobalt';
?>
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <a href="<?= url('/admin/berita') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted transition hover:text-ink">
            <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-chevron-left"/></svg>
            Semua berita
        </a>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            <?= $isEdit ? 'Edit berita' : 'Tambah berita' ?><span class="text-cobalt">.</span>
        </h1>
    </div>
    <p class="hidden text-xs text-muted sm:block">
        <?= $isEdit ? 'Perbarui konten yang sudah terbit' : 'Tulisan baru untuk situs' ?>
    </p>
</div>

<form method="post" action="<?= e($action) ?>" enctype="multipart/form-data" class="mt-7 grid gap-4 lg:grid-cols-12">
    <?= csrf_field() ?>

    <div class="space-y-4 lg:col-span-8">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Isi tulisan</h2>

            <div class="mt-5">
                <label for="judul" class="block text-[13px] font-semibold text-ink">Judul <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="judul"
                    name="judul"
                    value="<?= e((string) ($berita['judul'] ?? '')) ?>"
                    required
                    maxlength="180"
                    data-slug-source
                    class="<?= e($inputClass . ' ' . $borderClass('judul')) ?> text-lg font-semibold"
                    placeholder="Contoh: Tim STEKOM Juara Kompetisi IoT Nasional"
                >
                <?php if ($fieldError('judul')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['judul']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="slug" class="block text-[13px] font-semibold text-ink">Slug URL</label>
                <div class="mt-2 flex items-center border bg-white pl-4 focus-within:border-cobalt focus-within:ring-2 focus-within:ring-cobalt/20 <?= $fieldError('slug') ? 'border-red/50' : 'border-ink/20 focus-within:border-cobalt' ?>">
                    <span class="shrink-0 text-xs text-muted">/berita/</span>
                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        value="<?= e((string) ($berita['slug'] ?? '')) ?>"
                        maxlength="200"
                        data-slug-target
                        class="w-full bg-transparent py-3 pr-4 pl-1 text-xs tabular-nums text-ink outline-none placeholder:text-muted/60"
                        placeholder="otomatis-dari-judul"
                    >
                </div>
                <p class="mt-1.5 text-xs text-muted">Kosongkan untuk dibuat otomatis dari judul.</p>
            </div>

            <div class="mt-5">
                <label for="ringkasan" class="block text-[13px] font-semibold text-ink">Ringkasan <span class="text-red">*</span></label>
                <textarea
                    id="ringkasan"
                    name="ringkasan"
                    required
                    maxlength="320"
                    rows="3"
                    class="<?= e($inputClass . ' ' . $borderClass('ringkasan')) ?> resize-y"
                    placeholder="Satu sampai dua kalimat yang muncul di kartu berita dan beranda."
                ><?= e((string) ($berita['ringkasan'] ?? '')) ?></textarea>
                <?php if ($fieldError('ringkasan')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['ringkasan']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <div class="flex flex-col justify-between gap-1 sm:flex-row sm:items-center sm:gap-4">
                    <label for="isi" class="block text-[13px] font-semibold text-ink">Isi berita <span class="text-red">*</span></label>
                    <span class="text-xs text-muted">Pisahkan paragraf dengan baris kosong.</span>
                </div>
                <textarea
                    id="isi"
                    name="isi"
                    required
                    rows="16"
                    class="<?= e($inputClass . ' ' . $borderClass('isi')) ?> resize-y leading-relaxed"
                    placeholder="Tulis isi berita di sini…"
                ><?= e((string) ($berita['isi'] ?? '')) ?></textarea>
                <?php if ($fieldError('isi')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['isi']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="space-y-4 lg:col-span-4">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Publikasi</h2>

            <div class="mt-5">
                <label for="kategori" class="block text-[13px] font-semibold text-ink">Kategori <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="kategori"
                    name="kategori"
                    value="<?= e((string) ($berita['kategori'] ?? '')) ?>"
                    required
                    maxlength="50"
                    list="kategori-list"
                    class="<?= e($inputClass . ' ' . $borderClass('kategori')) ?>"
                    placeholder="Prestasi, Kegiatan, Pengumuman…"
                >
                <datalist id="kategori-list">
                    <?php foreach ($kategoriList as $kategori): ?>
                        <option value="<?= e($kategori) ?>"></option>
                    <?php endforeach; ?>
                </datalist>
                <?php if ($fieldError('kategori')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['kategori']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <label for="penulis" class="block text-[13px] font-semibold text-ink">Penulis <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="penulis"
                    name="penulis"
                    value="<?= e((string) ($berita['penulis'] ?? '')) ?>"
                    required
                    maxlength="100"
                    class="<?= e($inputClass . ' ' . $borderClass('penulis')) ?>"
                    placeholder="Humas STEKOM"
                >
                <?php if ($fieldError('penulis')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['penulis']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <label for="diterbitkan_pada" class="block text-[13px] font-semibold text-ink">Tanggal terbit <span class="text-red">*</span></label>
                <input
                    type="datetime-local"
                    id="diterbitkan_pada"
                    name="diterbitkan_pada"
                    value="<?= e((string) ($berita['diterbitkan_pada'] ?? '')) ?>"
                    required
                    class="<?= e($inputClass . ' ' . $borderClass('diterbitkan_pada')) ?>"
                >
                <?php if ($fieldError('diterbitkan_pada')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['diterbitkan_pada']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Gambar sampul</h2>

            <div class="mt-4 overflow-hidden border border-dashed border-ink/20 bg-bone">
                <img
                    data-image-preview
                    src="<?= e($gambar ?? '') ?>"
                    alt="Pratinjau gambar sampul"
                    class="aspect-[16/9] w-full object-cover <?= $gambar === null ? 'hidden' : '' ?>"
                >
                <div data-image-empty class="flex aspect-[16/9] flex-col items-center justify-center gap-2 text-muted <?= $gambar !== null ? 'hidden' : '' ?>">
                    <svg class="h-7 w-7" aria-hidden="true"><use href="#i-image"/></svg>
                    <span class="text-xs">Belum ada gambar</span>
                </div>
            </div>

            <label for="gambar" class="mt-4 block text-[13px] font-semibold text-ink">Unggah gambar</label>
            <div class="mt-2 flex items-center gap-3 border border-ink/15 bg-white px-2 py-2 transition focus-within:border-cobalt focus-within:ring-2 focus-within:ring-cobalt/20" data-file-field>
                <label for="gambar" class="press inline-flex shrink-0 cursor-pointer items-center gap-2 bg-cobalt px-3.5 py-2 text-xs font-semibold text-bone transition hover:bg-ink">
                    <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-upload"/></svg>
                    Pilih gambar
                </label>
                <span data-file-name class="min-w-0 truncate text-xs text-muted" aria-live="polite">Belum ada file dipilih</span>
                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept="image/jpeg,image/png,image/webp"
                    data-image-input
                    class="sr-only"
                >
            </div>
            <p class="mt-2 text-xs leading-relaxed text-muted">JPG, PNG, atau WebP · maks. 2 MB · rasio 16:9 disarankan.</p>
            <?php if ($fieldError('gambar')): ?>
                <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['gambar']) ?></p>
            <?php endif; ?>

            <input type="hidden" name="gambar_lama" value="<?= e((string) ($berita['gambar'] ?? '')) ?>">
        </div>

        <div class="border border-ink/10 bg-white p-4 lg:sticky lg:top-24">
            <button type="submit" class="press flex w-full items-center justify-center gap-2 bg-cobalt px-5 py-3.5 text-sm font-bold text-bone transition hover:bg-ink">
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg>
                <?= $isEdit ? 'Simpan perubahan' : 'Terbitkan berita' ?>
            </button>
            <a href="<?= url('/admin/berita') ?>" class="mt-2 flex w-full items-center justify-center border border-ink/20 px-5 py-3 text-sm font-semibold text-muted transition hover:border-ink/40 hover:text-ink">
                Batal
            </a>
        </div>
    </div>
</form>
