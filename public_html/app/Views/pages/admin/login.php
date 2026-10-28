<?php

declare(strict_types=1);
?>
<div class="border border-ink/10 bg-white p-7 sm:p-9">
    <h1 class="font-display text-[clamp(1.8rem,3.4vw,2.2rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">
        Masuk ke<br>
        panel admin<span class="text-cobalt">.</span>
    </h1>
    <p class="mt-4 text-sm leading-relaxed text-muted">
        Gunakan akun pengurus yang sudah terdaftar untuk mengelola konten situs.
    </p>

    <?php if (!empty($error)): ?>
        <div class="mt-6 flex items-start gap-3 border border-red-300 bg-red/5 px-4 py-3.5 text-sm text-red" role="alert">
            <svg class="mt-0.5 h-4 w-4 shrink-0" aria-hidden="true"><use href="#i-alert"/></svg>
            <p class="leading-relaxed"><?= e($error) ?></p>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= url('/admin/login') ?>" class="mt-7 space-y-5" novalidate>
        <?= csrf_field() ?>

        <div>
            <label for="email" class="block text-[13px] font-semibold text-ink">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= e($email ?? '') ?>"
                required
                autofocus
                autocomplete="username"
                class="mt-2 w-full border border-ink/20 bg-bone px-4 py-3 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:bg-white focus:ring-2 focus:ring-cobalt/20"
                placeholder="nama@stekom.id"
            >
        </div>

        <div>
            <div class="flex items-center justify-between gap-4">
                <label for="password" class="block text-[13px] font-semibold text-ink">Kata sandi</label>
                <span id="password-help" class="text-xs text-muted">Minimal 8 karakter</span>
            </div>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
                aria-describedby="password-help"
                class="mt-2 w-full border border-ink/20 bg-bone px-4 py-3 text-sm text-ink outline-none transition placeholder:text-muted/60 focus:border-cobalt focus:bg-white focus:ring-2 focus:ring-cobalt/20"
                placeholder="••••••••"
            >
        </div>

        <button type="submit" class="press flex w-full items-center justify-between gap-4 bg-cobalt px-5 py-3.5 text-sm font-bold text-bone transition hover:bg-ink">
            Masuk ke dashboard
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-up-right"/></svg>
        </button>
    </form>

    <p class="mt-6 border-t border-ink/10 pt-5 text-xs leading-relaxed text-muted">
        Halaman ini hanya untuk pengurus. Aktivitas masuk dicatat.
    </p>
</div>
