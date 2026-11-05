<?php

declare(strict_types=1);

/*
 * Modal konfirmasi untuk form[data-confirm].
 * Satu modal dipakai ulang; judul, pesan, label, dan ikon diambil dari
 * atribut data-confirm-* pada form yang memicunya (lihat admin.js).
 */
?>
<div
    data-confirm-modal
    class="admin-modal fixed inset-0 z-[70] items-center justify-center p-4 sm:p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="admin-confirm-title"
    aria-describedby="admin-confirm-message"
    hidden
>
    <div class="absolute inset-0 bg-ink/70" data-confirm-close aria-hidden="true"></div>

    <div class="admin-modal__card relative w-full max-w-md overflow-hidden border border-ink/10 bg-white shadow-[0_24px_70px_-24px_rgba(8,23,47,0.5)]">
        <div class="flex items-start gap-4 border-b border-ink/10 bg-bone p-6">
            <span class="grid h-11 w-11 shrink-0 place-items-center bg-red/10 text-red">
                <svg class="h-5 w-5" aria-hidden="true"><use href="#i-trash" data-confirm-icon/></svg>
            </span>

            <div class="min-w-0 flex-1 pt-0.5">
                <h2 id="admin-confirm-title" class="font-display text-xl font-black leading-tight tracking-[-0.03em]" data-confirm-title>
                    Hapus data ini?
                </h2>
            </div>

            <button
                type="button"
                class="grid h-8 w-8 shrink-0 place-items-center border border-ink/15 text-muted transition hover:border-ink/40 hover:text-ink"
                data-confirm-close
                aria-label="Tutup dialog"
            >
                <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-x"/></svg>
            </button>
        </div>

        <p id="admin-confirm-message" class="px-6 pt-5 text-sm leading-relaxed text-muted" data-confirm-message></p>

        <div class="flex flex-col-reverse gap-2 p-6 sm:flex-row sm:justify-end">
            <button
                type="button"
                class="border border-ink/20 bg-white px-5 py-3 text-sm font-semibold text-ink transition hover:border-ink/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-cobalt/30"
                data-confirm-close
                data-confirm-decline
            >
                Batal
            </button>
            <button
                type="button"
                class="bg-red px-5 py-3 text-sm font-bold text-bone transition hover:bg-ink focus:outline-none focus-visible:ring-2 focus-visible:ring-red/40"
                data-confirm-accept
            >
                Hapus
            </button>
        </div>
    </div>
</div>
