<?php

declare(strict_types=1);

$oprecAktif = (bool) config('oprec_aktif', false);
$gabungUrl = $oprecAktif ? url((string) config('oprec_link', '/berita')) : null;
$deadlineOprec = (string) config('oprec_deadline', '30 November 2026');

$utama = $beritaTerbaru[0] ?? null;
$sisaBerita = array_slice($beritaTerbaru, 1);
?>
<section id="beranda" class="relative overflow-hidden bg-cobalt text-bone">
    <div class="mx-auto w-full max-w-[1600px] px-4 sm:px-6 lg:px-8">
        <div class="pt-8 sm:pt-12 lg:pt-14">
            <h1 class="font-display text-[clamp(3.4rem,12.5vw,10.5rem)] font-black uppercase leading-[0.84] tracking-[-0.045em]">
                <span class="hero-line"><span>Tempatnya</span></span>
                <span class="hero-line text-right"><span>Ngoprek<span class="text-gold">.</span></span></span>
            </h1>
        </div>

        <div class="mt-8 grid gap-8 pb-10 sm:mt-10 lg:grid-cols-12 lg:items-end lg:gap-8 lg:pb-14">
            <div class="hero-fade lg:col-span-5">
                <p class="max-w-[40ch] text-lg leading-relaxed text-bone sm:text-xl">
                    Himpunan mahasiswa Sistem Komputer dan Teknik Komputer IIB Darmajaya.
                    Buat yang suka bongkar alat, bikin produk, dan ngulik bareng.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <?php if ($gabungUrl !== null): ?>
                        <a
                            href="<?= e($gabungUrl) ?>"
                            class="press inline-flex items-center gap-3 bg-gold px-6 py-4 text-lg font-bold text-ink hover:bg-bone"
                        >
                            Gabung angkatan ini
                            <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                        </a>
                    <?php endif; ?>
                    <a
                        href="#divisi"
                        class="press inline-flex items-center gap-3 bg-bone px-6 py-4 text-lg font-bold text-ink hover:bg-gold"
                    >
                        Lihat divisi
                        <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                    </a>
                </div>

                <p class="mt-6 text-base leading-relaxed text-bone/80">
                    Kampus IIB Darmajaya, Bandar Lampung · Periode <?= e($site['periode']) ?>
                </p>
            </div>

            <figure class="hero-fade photo-tilt lg:col-span-6 lg:col-start-7">
                <div class="overflow-hidden bg-cobalt-deep">
                    <img
                        src="<?= e(asset('img/found/macro-circuit-board.jpg')) ?>"
                        alt="Makro papan sirkuit dengan jalur tembaga dan komponen elektronika"
                        width="1920"
                        height="1280"
                        class="aspect-[5/3] w-full object-cover"
                    >
                </div>
                <figcaption class="mt-3 text-sm leading-relaxed text-bone/80">
                    Ilustrasi papan sirkuit. Foto: Ingo Dierking, CC BY-SA 4.0.
                </figcaption>
            </figure>
        </div>
    </div>
</section>

<div class="marquee overflow-hidden bg-gold py-3 text-ink">
    <div class="marquee-track">
        <?php for ($group = 0; $group < 2; $group++): ?>
            <div class="flex shrink-0 items-center" <?= $group === 1 ? 'aria-hidden="true"' : '' ?>>
                <?php foreach ($marquee as $item): ?>
                    <span class="flex items-center gap-6 px-6 text-base font-bold uppercase">
                        <?= e($item) ?>
                        <svg class="h-3 w-3" aria-hidden="true"><use href="#i-spark"/></svg>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>

<section id="tentang" class="scroll-mt-20 bg-bone text-ink">
    <div class="mx-auto max-w-[1600px] px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-12 lg:items-start lg:gap-8">
            <div class="reveal lg:col-span-5">
                <h2 class="font-display text-[clamp(2.7rem,7.2vw,6.8rem)] font-black uppercase leading-[0.88] tracking-[-0.045em]">
                    Bukan cuma<br>
                    <span class="text-cobalt">organisasi.</span>
                </h2>
                <p class="mt-6 max-w-[52ch] text-xl leading-relaxed text-ink">
                    STEKOM tempat mahasiswa Sistem Komputer dan Teknik Komputer belajar di luar kelas:
                    membangun proyek, berbagi ilmu, dan menyiapkan diri buat industri.
                </p>
                <p class="mt-5 max-w-[52ch] text-lg leading-relaxed text-muted">
                    Nggak harus jago dulu buat masuk. Modal utamanya rasa penasaran, sisanya kita
                    kerjakan bareng-bareng.
                </p>
                <a
                    href="#divisi"
                    class="press mt-8 inline-flex items-center gap-3 bg-cobalt px-6 py-4 text-lg font-bold text-bone hover:bg-ink"
                >
                    Cari jalurmu
                    <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                </a>
            </div>

            <figure class="reveal lg:col-span-6 lg:col-start-7">
                <div class="overflow-hidden bg-ink">
                    <img
                        src="<?= e(asset('img/found/computer-labs.jpg')) ?>"
                        alt="Deretan komputer di ruang laboratorium komputer"
                        width="1280"
                        height="960"
                        loading="lazy"
                        class="aspect-[4/3] w-full object-cover"
                    >
                </div>
                <figcaption class="mt-3 text-sm leading-relaxed text-muted">
                    Ilustrasi suasana laboratorium komputer. Foto: Mailane vanesa, CC0.
                </figcaption>
            </figure>
        </div>
    </div>
</section>

<section aria-label="STEKOM dalam angka" class="bg-gold text-ink">
    <dl class="mx-auto grid max-w-[1600px] grid-cols-2 gap-x-6 gap-y-8 px-4 py-10 sm:px-6 sm:py-12 lg:grid-cols-4 lg:px-8">
        <?php foreach ($stats as $stat): ?>
            <div class="reveal">
                <dt class="order-2 mt-2 text-base font-medium"><?= e($stat['label']) ?></dt>
                <dd class="order-1 font-display text-[clamp(2.5rem,4.5vw,4.5rem)] font-black leading-none tracking-[-0.04em]">
                    <?= e($stat['value']) ?>
                </dd>
            </div>
        <?php endforeach; ?>
    </dl>
</section>

<section id="divisi" class="scroll-mt-20 bg-ink text-bone">
    <div class="mx-auto max-w-[1600px] px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
            <h2 class="reveal font-display text-[clamp(2.7rem,7vw,6.4rem)] font-black uppercase leading-[0.88] tracking-[-0.045em] lg:col-span-7">
                Pilih jalur<br>
                <span class="text-gold">ngoprek.</span>
            </h2>
            <p class="reveal max-w-[46ch] text-lg leading-relaxed text-bone/85 lg:col-span-4 lg:col-start-9">
                Enam divisi, enam cara buat mulai. Pilih yang paling bikin kamu penasaran,
                atau coba beberapa sekaligus.
            </p>
        </div>

        <div class="mt-12 grid gap-10 lg:grid-cols-12 lg:gap-12">
            <figure class="reveal lg:col-span-5">
                <div class="overflow-hidden bg-cobalt-deep">
                    <img
                        src="<?= e(asset('img/found/a-messy-network-server-room-showing-wires.jpg')) ?>"
                        alt="Rak server dengan kabel dan panel jaringan yang tersusun rapi"
                        width="1542"
                        height="2048"
                        loading="lazy"
                        class="aspect-[4/5] w-full object-cover"
                    >
                </div>
                <figcaption class="mt-3 text-sm leading-relaxed text-bone/75">
                    Ilustrasi ruang server. Foto: Moses Cursor Ssebunya, CC0.
                </figcaption>
            </figure>

            <div class="reveal lg:col-span-6 lg:col-start-7" data-interest-picker>
                <div class="space-y-3">
                    <?php foreach ($divisi as $item): ?>
                        <details class="interest" data-interest="<?= e($item['slug']) ?>">
                            <summary class="flex items-center justify-between gap-4 px-5 py-5">
                                <span class="flex min-w-0 flex-col">
                                    <span class="font-display text-xl font-bold leading-tight tracking-[-0.02em] sm:text-2xl">
                                        <?= e($item['minat']) ?>
                                    </span>
                                    <span class="mt-1 text-base opacity-80"><?= e($item['nama']) ?></span>
                                </span>
                                <svg class="interest-sign h-6 w-6 shrink-0" aria-hidden="true"><use href="#i-plus"/></svg>
                            </summary>
                            <div class="interest-body px-5 pb-5">
                                <p class="max-w-[52ch] text-lg leading-relaxed">
                                    <?= e($item['deskripsi']) ?>
                                </p>
                                <p class="mt-4 text-base">
                                    Koordinator:
                                    <strong class="font-bold"><?= e($item['koordinator'] ?? 'belum ditetapkan') ?></strong>
                                </p>
                                <a
                                    href="<?= url('/organisasi#divisi') ?>"
                                    class="mt-5 inline-flex items-center gap-2 bg-gold px-4 py-3 text-base font-bold text-ink hover:bg-bone"
                                >
                                    Lihat divisi ini
                                    <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                                </a>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>

                <a
                    href="<?= url('/organisasi') ?>"
                    class="press mt-7 inline-flex items-center gap-3 bg-bone px-5 py-4 text-lg font-bold text-ink hover:bg-gold"
                >
                    Kenalan sama pengurus
                    <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section id="agenda" class="scroll-mt-20 bg-cobalt text-bone">
    <div class="mx-auto max-w-[1600px] px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
            <h2 class="reveal font-display text-[clamp(2.7rem,7vw,6.4rem)] font-black uppercase leading-[0.88] tracking-[-0.045em] lg:col-span-7">
                Agenda<br>
                <span class="text-gold">terdekat.</span>
            </h2>
            <p class="reveal max-w-[44ch] text-lg leading-relaxed text-bone/85 lg:col-span-4 lg:col-start-9">
                Dari workshop sampai pameran karya. Catat tanggalnya, ajak satu teman,
                dan datang.
            </p>
        </div>

        <div class="mt-12 space-y-3">
            <?php foreach ($kegiatan as $item): ?>
                <article class="agenda-row reveal grid gap-3 bg-bone px-5 py-6 text-ink sm:grid-cols-12 sm:items-center sm:gap-6 sm:px-6">
                    <time datetime="<?= e($item['datetime']) ?>" class="font-display text-4xl font-black uppercase leading-none tracking-[-0.03em] text-cobalt sm:col-span-2">
                        <?= e($item['day'] . ' ' . $item['month']) ?>
                    </time>

                    <div class="sm:col-span-6">
                        <h3 class="font-display text-2xl font-bold leading-tight tracking-[-0.02em]">
                            <?= e($item['title']) ?>
                        </h3>
                        <p class="mt-2 max-w-[54ch] text-base leading-relaxed text-muted">
                            <?= e($item['description']) ?>
                        </p>
                    </div>

                    <p class="text-base font-medium sm:col-span-3">
                        <?= e($item['category']) ?> · <?= e($item['location']) ?>
                    </p>

                    <span class="hidden justify-self-end sm:col-span-1 sm:block" aria-hidden="true">
                        <svg class="h-6 w-6"><use href="#i-arrow-up-right"/></svg>
                    </span>
                </article>
            <?php endforeach; ?>
        </div>

        <a
            href="<?= e($gabungUrl) ?>"
            class="press mt-8 inline-flex items-center gap-3 bg-gold px-5 py-4 text-lg font-bold text-ink hover:bg-bone"
        >
            Ikut open recruitment
            <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-right"/></svg>
        </a>
    </div>
</section>

<section id="kabar" class="scroll-mt-20 bg-bone text-ink">
    <div class="mx-auto max-w-[1600px] px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
            <h2 class="reveal font-display text-[clamp(2.7rem,7vw,6.4rem)] font-black uppercase leading-[0.88] tracking-[-0.045em]">
                Kabar dari<br>
                <span class="text-red">lab.</span>
            </h2>
            <a href="<?= url('/berita') ?>" class="press inline-flex items-center gap-3 bg-ink px-5 py-4 text-lg font-bold text-bone hover:bg-cobalt">
                Semua kabar
                <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-right"/></svg>
            </a>
        </div>

        <?php if ($utama === null): ?>
            <p class="mt-10 max-w-[52ch] text-lg leading-relaxed text-muted">
                Belum ada kabar yang terbit. Nanti kita ceritakan di sini.
            </p>
        <?php else: ?>
            <?php
            $utamaGambar = gambar_url($utama['gambar'] ?? null);
            $utamaUrl = url('/berita/' . rawurlencode((string) $utama['slug']));
            ?>
            <div class="mt-12 grid gap-10 lg:grid-cols-12 lg:gap-8">
                <article class="reveal news-shot group lg:col-span-7">
                    <a href="<?= e($utamaUrl) ?>" class="block overflow-hidden bg-cobalt" tabindex="-1" aria-hidden="true">
                        <?php if ($utamaGambar !== null): ?>
                            <img
                                src="<?= e($utamaGambar) ?>"
                                alt=""
                                width="1200"
                                height="800"
                                class="aspect-[3/2] w-full object-cover"
                            >
                        <?php endif; ?>
                    </a>

                    <div class="mt-5 flex flex-wrap items-center gap-4">
                        <span class="bg-red px-3 py-1 text-base font-bold text-bone"><?= e($utama['kategori']) ?></span>
                        <time datetime="<?= e(date('c', strtotime((string) $utama['diterbitkan_pada']))) ?>" class="text-base text-muted">
                            <?= e(tanggal_id((string) $utama['diterbitkan_pada'])) ?>
                        </time>
                    </div>

                    <h3 class="mt-3 max-w-[24ch] font-display text-[clamp(1.5rem,2.2vw,1.9rem)] font-bold leading-[1.08] tracking-[-0.03em]">
                        <?= e($utama['judul']) ?>
                    </h3>
                    <p class="mt-3 max-w-[56ch] text-lg leading-relaxed text-muted">
                        <?= e($utama['ringkasan']) ?>
                    </p>
                    <a href="<?= e($utamaUrl) ?>" class="press mt-5 inline-flex items-center gap-3 bg-cobalt px-5 py-3 text-lg font-bold text-bone hover:bg-ink">
                        Baca kabar
                        <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
                    </a>
                </article>

                <div class="space-y-8 lg:col-span-5">
                    <?php foreach ($sisaBerita as $item): ?>
                        <?php
                        $itemGambar = gambar_url($item['gambar'] ?? null);
                        $itemUrl = url('/berita/' . rawurlencode((string) $item['slug']));
                        ?>
                        <article class="reveal news-shot group">
                            <a href="<?= e($itemUrl) ?>" class="block overflow-hidden bg-cobalt" tabindex="-1" aria-hidden="true">
                                <?php if ($itemGambar !== null): ?>
                                    <img
                                        src="<?= e($itemGambar) ?>"
                                        alt=""
                                        width="1200"
                                        height="675"
                                        loading="lazy"
                                        class="aspect-[16/9] w-full object-cover"
                                    >
                                <?php endif; ?>
                            </a>
                            <p class="mt-4 text-base font-bold text-red"><?= e($item['kategori']) ?></p>
                            <h3 class="mt-2 font-display text-[clamp(1.25rem,1.8vw,1.5rem)] font-bold leading-[1.12] tracking-[-0.02em]">
                                <a href="<?= e($itemUrl) ?>" class="hover:text-cobalt"><?= e($item['judul']) ?></a>
                            </h3>
                            <time datetime="<?= e(date('c', strtotime((string) $item['diterbitkan_pada']))) ?>" class="mt-2 block text-base text-muted">
                                <?= e(tanggal_id((string) $item['diterbitkan_pada'])) ?>
                            </time>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section id="organisasi" class="scroll-mt-20 bg-red text-bone">
    <div class="mx-auto grid max-w-[1600px] gap-10 px-4 py-16 sm:px-6 sm:py-24 lg:grid-cols-12 lg:gap-8 lg:px-8">
        <figure class="reveal lg:col-span-5">
            <div class="overflow-hidden bg-ink">
                <img
                    src="<?= e(asset('img/found/portrait-view-of-bandar-lampung-lampung-29.jpg')) ?>"
                    alt="Panorama Kota Bandar Lampung dilihat dari perbukitan"
                    width="1280"
                    height="2276"
                    loading="lazy"
                    class="aspect-[4/5] w-full object-cover object-top"
                >
            </div>
            <figcaption class="mt-3 text-sm leading-relaxed text-bone/80">
                Bandar Lampung dari atas. Foto: Firzafp, CC BY-SA 4.0.
            </figcaption>
        </figure>

        <div class="reveal lg:col-span-6 lg:col-start-7">
            <h2 class="font-display text-[clamp(2.7rem,6.6vw,6rem)] font-black uppercase leading-[0.88] tracking-[-0.045em]">
                Yang<br>
                <span class="text-gold">jalanin.</span>
            </h2>
            <p class="mt-6 max-w-[50ch] text-lg leading-relaxed text-bone">
                Pengurus yang ngurus program, jaga ritme, dan buka pintu buat anggota baru.
                Kenalan dulu, siapa tahu cocok.
            </p>

            <?php if ($ketua !== null): ?>
                <?php $fotoKetua = gambar_url($ketua['foto'] ?? null); ?>
                <article class="mt-8 flex items-center gap-5">
                    <div class="h-24 w-24 shrink-0 overflow-hidden bg-ink">
                        <?php if ($fotoKetua !== null): ?>
                            <img
                                src="<?= e($fotoKetua) ?>"
                                alt="Foto <?= e($ketua['nama']) ?>, <?= e($ketua['jabatan']) ?> STEKOM"
                                width="192"
                                height="192"
                                loading="lazy"
                                class="h-full w-full object-cover"
                            >
                        <?php else: ?>
                            <span class="grid h-full w-full place-items-center font-display text-3xl font-black text-gold">
                                <?= e(initials((string) $ketua['nama'])) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gold"><?= e($ketua['jabatan']) ?></p>
                        <h3 class="mt-1 font-display text-2xl font-bold leading-tight tracking-[-0.02em]"><?= e($ketua['nama']) ?></h3>
                    </div>
                </article>
            <?php endif; ?>

            <?php $anggotaInti = array_slice($core, 1, 3); ?>
            <?php if ($anggotaInti !== []): ?>
                <ul class="mt-6 space-y-3">
                    <?php foreach ($anggotaInti as $person): ?>
                        <li class="flex items-center gap-4 bg-red px-4 py-3">
                            <span class="grid h-12 w-12 shrink-0 place-items-center bg-gold font-display text-lg font-black text-ink">
                                <?= e(initials((string) $person['nama'])) ?>
                            </span>
                            <div class="min-w-0">
                                <p class="font-display text-lg font-bold leading-tight"><?= e($person['nama']) ?></p>
                                <p class="mt-0.5 text-base text-bone/85"><?= e($person['jabatan']) ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <a
                href="<?= url('/organisasi') ?>"
                class="press mt-8 inline-flex items-center gap-3 bg-bone px-5 py-4 text-lg font-bold text-ink hover:bg-gold"
            >
                Lihat semua pengurus
                <svg class="h-5 w-5" aria-hidden="true"><use href="#i-arrow-right"/></svg>
            </a>
        </div>
    </div>
</section>

<?php if ($oprecAktif): ?>
    <a href="<?= e($gabungUrl) ?>" class="cta-band block bg-gold text-ink">
        <div class="mx-auto max-w-[1600px] px-4 pb-6 pt-8 sm:px-6 sm:pb-8 sm:pt-10 lg:px-8">
            <div class="flex items-start justify-between gap-6">
                <p class="max-w-[42ch] text-lg font-bold leading-snug sm:text-xl">
                    Pendaftaran anggota 2026/2027 dibuka sampai <?= e($deadlineOprec) ?>. Jangan cuma
                    jadi penonton.
                </p>
                <svg class="h-10 w-10 shrink-0 sm:h-12 sm:w-12" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
            </div>
            <span class="cta-word mt-4 block text-center font-display text-[clamp(5rem,21vw,19rem)] font-black uppercase leading-[0.78] tracking-[-0.055em]">
                Gabung
            </span>
        </div>
    </a>
<?php endif; ?>
