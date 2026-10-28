<?php

declare(strict_types=1);

if (empty($flash) || !is_array($flash)) {
    return;
}

$type = (string) ($flash['type'] ?? 'success');
$styles = [
    'success' => 'border-cobalt/25 bg-cobalt/5 text-ink',
    'error' => 'border-red/30 bg-red/5 text-ink',
    'warning' => 'border-amber-400 bg-amber-50 text-ink',
];
$dots = [
    'success' => 'text-cobalt',
    'error' => 'text-red',
    'warning' => 'text-amber-600',
];
$icons = [
    'success' => 'i-check',
    'error' => 'i-alert',
    'warning' => 'i-alert',
];
$style = $styles[$type] ?? $styles['success'];
$dot = $dots[$type] ?? $dots['success'];
$icon = $icons[$type] ?? 'i-check';
?>
<div class="mb-6 flex items-start gap-3 border px-4 py-3.5 text-sm <?= e($style) ?>" role="status" data-flash>
    <svg class="mt-0.5 h-4 w-4 shrink-0 <?= e($dot) ?>" aria-hidden="true"><use href="#<?= e($icon) ?>"/></svg>
    <p class="flex-1 leading-relaxed"><?= e($flash['message'] ?? '') ?></p>
    <button type="button" class="shrink-0 p-1 text-muted transition hover:text-ink" data-flash-close aria-label="Tutup notifikasi">
        <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-x"/></svg>
    </button>
</div>
