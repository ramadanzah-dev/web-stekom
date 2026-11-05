<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

abstract class Controller
{
    /**
     * Render view di dalam layout, lalu kirim ke browser.
     *
     * @param array<string, mixed> $data
     */
    protected function view(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        $viewFile = BASE_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';
        $layoutFile = BASE_PATH . '/app/Views/' . str_replace('.', '/', $layout) . '.php';

        if (!is_file($viewFile) || !is_file($layoutFile)) {
            throw new RuntimeException('View tidak ditemukan: ' . $view);
        }

        $data['site'] = config('site');
        $data['csrfToken'] = csrf_token();

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        require $layoutFile;
    }

    protected function redirect(string $path = '/'): never
    {
        header('Location: ' . url($path), true, 302);
        exit;
    }

    protected function abort(int $status = 404): never
    {
        http_response_code($status);
        $this->view('pages/errors/404', ['title' => 'Halaman tidak ditemukan']);
        exit;
    }
}
