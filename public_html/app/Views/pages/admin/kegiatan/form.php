<?php

declare(strict_types=1);

$inputClass = 'mt-2 w-full border bg-white px-4 py-3 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:ring-2 focus:ring-cobalt/20';
$fieldError = static fn (string $key): bool => isset($errors[$key]);
$borderClass = static fn (string $key): string => $fieldError($key) ? 'border-red/50 focus:border-red' : 'border-ink/20 focus:border-cobalt';
?>
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <a href="<?= url('/admin/kegiatan') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted transition hover:text-ink">
            <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-chevron-left"/></svg>
            Semua kegiatan
        </a>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            <?= $isEdit ? 'Edit kegiatan' : 'Tambah kegiatan' ?><span class="text-cobalt">.</span>
        </h1>
    </div>
    <p class="hidden text-xs text-muted sm:block">
        <?= $isEdit ? 'Perbarui jadwal atau agenda' : 'Buat agenda baru untuk beranda' ?>
    </p>
</div>

<form method="post" action="<?= e($action) ?>" class="mt-7 grid gap-4 lg:grid-cols-12">
    <?= csrf_field() ?>

    <div class="space-y-4 lg:col-span-8">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Detail kegiatan</h2>

            <div class="mt-5">
                <label for="judul" class="block text-[13px] font-semibold text-ink">Judul kegiatan <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="judul"
                    name="judul"
                    value="<?= e((string) ($values['judul'] ?? '')) ?>"
                    required
                    maxlength="150"
                    class="<?= e($inputClass . ' ' . $borderClass('judul')) ?> text-lg font-semibold"
                    placeholder="Workshop IoT & Sensor"
                >
                <?php if ($fieldError('judul')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['judul']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="kategori" class="block text-[13px] font-semibold text-ink">Kategori</label>
                    <input
                        type="text"
                        id="kategori"
                        name="kategori"
                        value="<?= e((string) ($values['kategori'] ?? 'Agenda')) ?>"
                        maxlength="50"
                        class="<?= e($inputClass . ' ' . $borderClass('kategori')) ?>"
                        placeholder="Workshop / Expo / Pendaftaran"
                    >
                    <?php if ($fieldError('kategori')): ?>
                        <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['kategori']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="tanggal_mulai" class="block text-[13px] font-semibold text-ink">Tanggal mulai <span class="text-red">*</span></label>
                    <input
                        type="date"
                        id="tanggal_mulai"
                        name="tanggal_mulai"
                        value="<?= e((string) ($values['tanggal_mulai'] ?? date('Y-m-d'))) ?>"
                        required
                        class="<?= e($inputClass . ' ' . $borderClass('tanggal_mulai')) ?> tabular-nums"
                    >
                    <?php if ($fieldError('tanggal_mulai')): ?>
                        <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['tanggal_mulai']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <label for="lokasi" class="block text-[13px] font-semibold text-ink">Lokasi / Tempat</label>
                <input
                    type="text"
                    id="lokasi"
                    name="lokasi"
                    value="<?= e((string) ($values['lokasi'] ?? '')) ?>"
                    maxlength="150"
                    class="<?= e($inputClass . ' ' . $borderClass('lokasi')) ?>"
                    placeholder="Lab Hardware / Auditorium / Online"
                >
                <?php if ($fieldError('lokasi')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['lokasi']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <label for="tautan" class="block text-[13px] font-semibold text-ink">Tautan Kegiatan (URL / Pendaftaran)</label>
                <input
                    type="text"
                    id="tautan"
                    name="tautan"
                    value="<?= e((string) ($values['tautan'] ?? '')) ?>"
                    maxlength="255"
                    class="<?= e($inputClass . ' ' . $borderClass('tautan')) ?>"
                    placeholder="https://... atau /pendaftaran"
                >
                <?php if ($fieldError('tautan')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['tautan']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <label for="deskripsi" class="block text-[13px] font-semibold text-ink">Deskripsi singkat</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                    class="<?= e($inputClass . ' ' . $borderClass('deskripsi')) ?> resize-y leading-relaxed"
                    placeholder="Penjelasan singkat mengenai acara ini…"
                ><?= e((string) ($values['deskripsi'] ?? '')) ?></textarea>
                <?php if ($fieldError('deskripsi')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['deskripsi']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="space-y-4 lg:col-span-4">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Publikasi</h2>
            <div class="mt-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="aktif"
                        value="1"
                        <?= !empty($values['aktif']) ? 'checked' : '' ?>
                        class="h-4 w-4 rounded border-ink/20 text-cobalt focus:ring-cobalt"
                    >
                    <span class="text-[13px] font-semibold text-ink">Tampilkan di Beranda</span>
                </label>
                <p class="mt-1.5 text-xs text-muted">Hanya kegiatan aktif dan tanggal mendatang yang tampil di section agenda beranda.</p>
            </div>
        </div>

        <div class="border border-ink/10 bg-white p-4">
            <button type="submit" class="press flex w-full items-center justify-center gap-2 bg-cobalt px-5 py-3.5 text-sm font-bold text-bone transition hover:bg-ink">
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg>
                <?= $isEdit ? 'Simpan Perubahan' : 'Terbitkan Kegiatan' ?>
            </button>
        </div>
    </div>
</form>
