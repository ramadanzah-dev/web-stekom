<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;

abstract class BaseAdminController extends Controller
{
    /**
     * @var array{id: int, nama: string, email: string}|null
     */
    protected ?array $admin = null;

    public function __construct(bool $guard = true)
    {
        if (!$guard) {
            return;
        }

        $admin = $_SESSION['admin'] ?? null;

        if (!is_array($admin) || empty($admin['id'])) {
            $_SESSION['_intended'] = $this->currentPath();

            $this->redirect('/admin/login');
        }

        $this->admin = $admin;
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function adminView(string $view, array $data = []): void
    {
        $data['admin'] = $this->admin;
        $data['flash'] = $this->pullFlash();
        $data['currentPath'] = $this->currentPath();

        $this->view('pages/admin/' . $view, $data, 'layouts/admin');
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function authView(string $view, array $data = []): void
    {
        $data['flash'] = $this->pullFlash();

        $this->view('pages/admin/' . $view, $data, 'layouts/auth');
    }

    protected function guardCsrf(): void
    {
        if (!verify_csrf(is_string($_POST['_csrf'] ?? null) ? $_POST['_csrf'] : null)) {
            $this->abortAdmin(419, 'Sesi formulir sudah kedaluwarsa. Muat ulang halaman lalu coba lagi.');
        }
    }

    protected function abortAdmin(int $status, string $message): never
    {
        http_response_code($status);

        $this->view('pages/errors/admin', [
            'title' => 'Akses ditolak',
            'status' => $status,
            'message' => $message,
            'admin' => $this->admin,
            'currentPath' => $this->currentPath(),
            'flash' => null,
        ], $this->admin !== null ? 'layouts/admin' : 'layouts/auth');

        exit;
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['_flash'] = ['type' => $type, 'message' => $message];
    }

    /**
     * @return array{type: string, message: string}|null
     */
    protected function pullFlash(): ?array
    {
        $flash = $_SESSION['_flash'] ?? null;
        unset($_SESSION['_flash']);

        return is_array($flash) && isset($flash['type'], $flash['message']) ? $flash : null;
    }

    protected function input(string $key, string $default = ''): string
    {
        $value = $_POST[$key] ?? $default;

        return is_string($value) ? trim($value) : $default;
    }

    protected function currentPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/admin', PHP_URL_PATH) ?: '/admin';
    }
}
