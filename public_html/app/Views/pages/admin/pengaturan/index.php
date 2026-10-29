<?php

declare(strict_types=1);

$logo = gambar_url($values['site_logo'] ?? null);

$inputClass = 'mt-2 w-full border bg-white px-4 py-3 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:ring-2 focus:ring-cobalt/20';
$fieldError = static fn (string $key): bool => isset($errors[$key]);
$borderClass = static fn (string $key): string => $fieldError($key) ? 'border-red/50 focus:border-red' : 'border-ink/20 focus:border-cobalt';
?>
<div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-xs font-medium text-muted">Situs · Identitas &amp; tampilan</p>
        <h1 class="mt-3 font-display text-[clamp(1.7rem,3.2vw,2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
            Pengaturan situs<span class="text-cobalt">.</span>
        </h1>
        <p class="mt-3 max-w-xl text-sm leading-relaxed text-muted">
            Ubah judul, teks footer, logo, serta kontak yang tampil di seluruh halaman.
            Perubahan langsung berlaku setelah disimpan.
        </p>
    </div>
</div>

<form method="post" action="<?= url('/admin/pengaturan') ?>" enctype="multipart/form-data" class="mt-7 grid grid-cols-1 gap-4 lg:grid-cols-12">
    <?= csrf_field() ?>

    <div class="space-y-4 lg:col-span-8">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Identitas</h2>

            <div class="mt-5">
                <label for="site_name" class="block text-[13px] font-semibold text-ink">Nama situs (title) <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="site_name"
                    name="site_name"
                    value="<?= e($values['site_name']) ?>"
                    required
                    maxlength="60"
                    class="<?= e($inputClass . ' ' . $borderClass('site_name')) ?> text-lg font-semibold"
                    placeholder="STEKOM"
                >
                <p class="mt-1.5 text-xs text-muted">Dipakai di judul tab browser, navbar, footer, dan panel admin.</p>
                <?php if ($fieldError('site_name')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="site_full_name" class="block text-[13px] font-semibold text-ink">Nama lengkap <span class="text-red">*</span></label>
                <input
                    type="text"
                    id="site_full_name"
                    name="site_full_name"
                    value="<?= e($values['site_full_name']) ?>"
                    required
                    maxlength="120"
                    class="<?= e($inputClass . ' ' . $borderClass('site_full_name')) ?>"
                    placeholder="Himpunan Mahasiswa Sistem Komputer"
                >
                <?php if ($fieldError('site_full_name')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_full_name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="site_tagline" class="block text-[13px] font-semibold text-ink">Tagline</label>
                <input
                    type="text"
                    id="site_tagline"
                    name="site_tagline"
                    value="<?= e($values['site_tagline']) ?>"
                    maxlength="180"
                    class="<?= e($inputClass . ' ' . $borderClass('site_tagline')) ?>"
                    placeholder="Ruang tumbuh mahasiswa Sistem Komputer."
                >
                <?php if ($fieldError('site_tagline')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_tagline']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="site_description" class="block text-[13px] font-semibold text-ink">Deskripsi situs</label>
                <textarea
                    id="site_description"
                    name="site_description"
                    rows="4"
                    maxlength="400"
                    class="<?= e($inputClass . ' ' . $borderClass('site_description')) ?> resize-y leading-relaxed"
                    placeholder="Deskripsi singkat yang dipakai untuk meta description."
                ><?= e($values['site_description']) ?></textarea>
                <p class="mt-1.5 text-xs text-muted">Dipakai mesin pencari dan pratinjau tautan.</p>
                <?php if ($fieldError('site_description')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_description']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="site_periode" class="block text-[13px] font-semibold text-ink">Periode kepengurusan</label>
                <input
                    type="text"
                    id="site_periode"
                    name="site_periode"
                    value="<?= e($values['site_periode']) ?>"
                    maxlength="20"
                    class="<?= e($inputClass . ' ' . $borderClass('site_periode')) ?> tabular-nums"
                    placeholder="2026/2027"
                >
                <?php if ($fieldError('site_periode')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_periode']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Beranda &amp; Open Recruitment</h2>

            <div class="mt-5">
                <label for="site_marquee" class="block text-[13px] font-semibold text-ink">Teks Marquee Beranda</label>
                <input
                    type="text"
                    id="site_marquee"
                    name="site_marquee"
                    value="<?= e($values['site_marquee'] ?? '') ?>"
                    maxlength="300"
                    class="<?= e($inputClass . ' ' . $borderClass('site_marquee')) ?>"
                    placeholder="Ngoprek bareng, Bikin karya, ..."
                >
                <p class="mt-1.5 text-xs text-muted">Pisahkan dengan koma (,).</p>
                <?php if ($fieldError('site_marquee')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_marquee']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="oprec_deadline" class="block text-[13px] font-semibold text-ink">Batas Deadline Oprec</label>
                    <input
                        type="text"
                        id="oprec_deadline"
                        name="oprec_deadline"
                        value="<?= e($values['oprec_deadline'] ?? '') ?>"
                        maxlength="60"
                        class="<?= e($inputClass . ' ' . $borderClass('oprec_deadline')) ?>"
                        placeholder="30 November 2026"
                    >
                    <?php if ($fieldError('oprec_deadline')): ?>
                        <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['oprec_deadline']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="oprec_link" class="block text-[13px] font-semibold text-ink">Link Oprec / URL</label>
                    <input
                        type="text"
                        id="oprec_link"
                        name="oprec_link"
                        value="<?= e($values['oprec_link'] ?? '') ?>"
                        maxlength="200"
                        class="<?= e($inputClass . ' ' . $borderClass('oprec_link')) ?>"
                        placeholder="/berita/open-recruitment-..."
                    >
                    <?php if ($fieldError('oprec_link')): ?>
                        <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['oprec_link']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="oprec_aktif"
                        value="1"
                        <?= !empty($values['oprec_aktif']) && $values['oprec_aktif'] === '1' ? 'checked' : '' ?>
                        class="h-4 w-4 rounded border-ink/20 text-cobalt focus:ring-cobalt"
                    >
                    <span class="text-[13px] font-semibold text-ink">Aktifkan Banner &amp; Status Open Recruitment</span>
                </label>
                <p class="mt-1.5 text-xs text-muted">Jika dimatikan, banner CTA pendaftaran di beranda akan disembunyikan.</p>
            </div>
        </div>

        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Footer</h2>

            <div class="mt-5">
                <label for="site_footer_text" class="block text-[13px] font-semibold text-ink">Teks footer</label>
                <textarea
                    id="site_footer_text"
                    name="site_footer_text"
                    rows="3"
                    maxlength="240"
                    class="<?= e($inputClass . ' ' . $borderClass('site_footer_text')) ?> resize-y leading-relaxed"
                    placeholder="Belajar, berkarya, dan bertumbuh bersama."
                ><?= e($values['site_footer_text']) ?></textarea>
                <p class="mt-1.5 text-xs text-muted">Tampil di bawah tagline pada footer situs.</p>
                <?php if ($fieldError('site_footer_text')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_footer_text']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="site_footer_note" class="block text-[13px] font-semibold text-ink">Catatan hak cipta</label>
                <input
                    type="text"
                    id="site_footer_note"
                    name="site_footer_note"
                    value="<?= e($values['site_footer_note']) ?>"
                    maxlength="160"
                    class="<?= e($inputClass . ' ' . $borderClass('site_footer_note')) ?>"
                    placeholder="Dibuat dengan rapi."
                >
                <p class="mt-1.5 text-xs text-muted">Diletakkan setelah “© <?= date('Y') ?> nama situs”.</p>
                <?php if ($fieldError('site_footer_note')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_footer_note']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Kontak &amp; sosial</h2>

            <div class="mt-5">
                <label for="site_email" class="block text-[13px] font-semibold text-ink">Email</label>
                <input
                    type="email"
                    id="site_email"
                    name="site_email"
                    value="<?= e($values['site_email']) ?>"
                    maxlength="150"
                    class="<?= e($inputClass . ' ' . $borderClass('site_email')) ?>"
                    placeholder="halo@stekom.id"
                >
                <?php if ($fieldError('site_email')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="site_instagram" class="block text-[13px] font-semibold text-ink">Instagram</label>
                <input
                    type="url"
                    id="site_instagram"
                    name="site_instagram"
                    value="<?= e($values['site_instagram']) ?>"
                    maxlength="200"
                    class="<?= e($inputClass . ' ' . $borderClass('site_instagram')) ?>"
                    placeholder="https://www.instagram.com/stekom"
                >
                <?php if ($fieldError('site_instagram')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_instagram']) ?></p>
                <?php endif; ?>
            </div>

            <div class="mt-5">
                <label for="site_location" class="block text-[13px] font-semibold text-ink">Lokasi</label>
                <input
                    type="text"
                    id="site_location"
                    name="site_location"
                    value="<?= e($values['site_location']) ?>"
                    maxlength="120"
                    class="<?= e($inputClass . ' ' . $borderClass('site_location')) ?>"
                    placeholder="Kampus Sistem Komputer"
                >
                <?php if ($fieldError('site_location')): ?>
                    <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['site_location']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="space-y-4 lg:col-span-4">
        <div class="border border-ink/10 bg-white p-6">
            <h2 class="font-display text-lg font-bold tracking-[-0.02em]">Logo</h2>

            <div class="mx-auto mt-4 grid aspect-square w-full max-w-[12rem] place-items-center overflow-hidden border border-dashed border-ink/20 bg-bone">
                <img
                    data-image-preview
                    src="<?= e($logo ?? '') ?>"
                    alt="Pratinjau logo situs"
                    class="h-full w-full object-contain p-4 <?= $logo === null ? 'hidden' : '' ?>"
                >
                <div data-image-empty class="flex flex-col items-center gap-2 text-muted <?= $logo !== null ? 'hidden' : '' ?>">
                    <span class="grid h-14 w-14 place-items-center bg-gold font-display text-2xl font-black text-ink">S</span>
                    <span class="text-xs">Belum ada logo</span>
                </div>
            </div>

            <label for="logo" class="mt-4 block text-[13px] font-semibold text-ink">Unggah logo</label>
            <div class="mt-2 flex items-center gap-3 border border-ink/15 bg-white px-2 py-2 transition focus-within:border-cobalt focus-within:ring-2 focus-within:ring-cobalt/20" data-file-field>
                <label for="logo" class="press inline-flex shrink-0 cursor-pointer items-center gap-2 bg-cobalt px-3.5 py-2 text-xs font-semibold text-bone transition hover:bg-ink">
                    <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-upload"/></svg>
                    Pilih logo
                </label>
                <span data-file-name class="min-w-0 truncate text-xs text-muted" aria-live="polite">Belum ada file dipilih</span>
                <input
                    type="file"
                    id="logo"
                    name="logo"
                    accept="image/jpeg,image/png,image/webp"
                    data-image-input
                    class="sr-only"
                >
            </div>
            <p class="mt-2 text-xs leading-relaxed text-muted">PNG transparan disarankan · maks. 2 MB · JPG, PNG, atau WebP.</p>
            <?php if ($fieldError('logo')): ?>
                <p class="mt-1.5 text-xs font-medium text-red"><?= e($errors['logo']) ?></p>
            <?php endif; ?>

            <?php if ($logo !== null): ?>
                <label for="hapus_logo" class="mt-4 flex cursor-pointer items-start gap-3 border border-ink/15 bg-bone px-4 py-3">
                    <input
                        type="checkbox"
                        id="hapus_logo"
                        name="hapus_logo"
                        value="1"
                        class="mt-0.5 h-4 w-4 accent-cobalt"
                    >
                    <span class="text-xs leading-relaxed text-muted">Hapus logo saat menyimpan dan kembali ke huruf “S”.</span>
                </label>
            <?php endif; ?>
        </div>

        <div class="border border-ink/10 bg-white p-4 lg:sticky lg:top-24">
            <button type="submit" class="press flex w-full items-center justify-center gap-2 bg-cobalt px-5 py-3.5 text-sm font-bold text-bone transition hover:bg-ink">
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg>
                Simpan pengaturan
            </button>
            <a href="<?= url('/') ?>" target="_blank" rel="noopener noreferrer" class="mt-2 flex w-full items-center justify-center gap-2 border border-ink/20 px-5 py-3 text-sm font-semibold text-muted transition hover:border-ink/40 hover:text-ink">
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-eye"/></svg>
                Lihat situs
            </a>
        </div>
    </div>
</form>

<form method="post" action="<?= url('/admin/pengaturan/reset') ?>" data-confirm-title="Kembalikan pengaturan ke bawaan?" data-confirm="Semua penyesuaian di halaman ini akan dihapus dan logo yang diunggah ikut terhapus." data-confirm-label="Ya, kembalikan" data-confirm-icon="i-alert" class="mt-4 border border-red/30 bg-red/5 p-6">
    <?= csrf_field() ?>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="font-display text-base font-bold text-red">Kembalikan ke bawaan</p>
            <p class="mt-1.5 max-w-xl text-sm leading-relaxed text-muted">
                Semua penyesuaian di halaman ini dihapus dan situs memakai nilai awal dari konfigurasi.
                Logo yang diunggah ikut dihapus.
            </p>
        </div>
        <button type="submit" class="press shrink-0 border border-red/40 bg-white px-5 py-2.5 text-sm font-semibold text-red transition hover:bg-red hover:text-bone">
            Kembalikan ke bawaan
        </button>
    </div>
</form>
