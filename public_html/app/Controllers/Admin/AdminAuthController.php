<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\AdminUser;

final class AdminAuthController extends BaseAdminController
{
    private const MAX_ATTEMPTS = 5;
    private const ATTEMPT_WINDOW = 600;

    public function __construct()
    {
        parent::__construct(false);
    }

    public function showLogin(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/admin');
        }

        $this->renderLogin('', null);
    }

    public function login(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/admin');
        }

        $this->guardCsrf();

        $email = strtolower($this->input('email'));
        $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

        $attempts = $this->recentAttempts();

        if (count($attempts) >= self::MAX_ATTEMPTS) {
            $this->renderLogin($email, 'Terlalu banyak percobaan masuk. Tunggu 10 menit lalu coba lagi.');

            return;
        }

        if ($email === '' || $password === '') {
            $this->renderLogin($email, 'Email dan kata sandi wajib diisi.');

            return;
        }

        $user = (new AdminUser())->findByEmail($email);

        if (
            $user === null
            || (int) $user['aktif'] !== 1
            || !password_verify($password, (string) $user['password_hash'])
        ) {
            $attempts[] = time();
            $_SESSION['_login_attempts'] = $attempts;

            $this->renderLogin($email, 'Email atau kata sandi salah.');

            return;
        }

        $intended = is_string($_SESSION['_intended'] ?? null) ? $_SESSION['_intended'] : '/admin';

        unset($_SESSION['_login_attempts'], $_SESSION['_intended'], $_SESSION['_csrf']);

        session_regenerate_id(true);

        $_SESSION['admin'] = [
            'id' => (int) $user['id'],
            'nama' => (string) $user['nama'],
            'email' => (string) $user['email'],
        ];

        (new AdminUser())->touchLogin((int) $user['id']);

        $this->flash('success', 'Selamat datang, ' . $user['nama'] . '.');

        $destination = str_starts_with($intended, '/admin') && !str_starts_with($intended, '/admin/login')
            ? $intended
            : '/admin';

        $this->redirect($destination);
    }

    public function logout(): void
    {
        $this->guardCsrf();

        $_SESSION = [];

        if (ini_get('session.use_cookies') === '1') {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
        session_start();
        session_regenerate_id(true);

        $this->flash('success', 'Kamu sudah keluar dari halaman admin.');

        $this->redirect('/admin/login');
    }

    private function isLoggedIn(): bool
    {
        $admin = $_SESSION['admin'] ?? null;

        return is_array($admin) && !empty($admin['id']);
    }

    /**
     * @return array<int, int>
     */
    private function recentAttempts(): array
    {
        $attempts = $_SESSION['_login_attempts'] ?? [];
        $attempts = is_array($attempts) ? $attempts : [];

        $threshold = time() - self::ATTEMPT_WINDOW;
        $attempts = array_values(array_filter(
            $attempts,
            static fn (mixed $timestamp): bool => is_int($timestamp) && $timestamp >= $threshold
        ));

        return $attempts;
    }

    private function renderLogin(string $email, ?string $error): void
    {
        $this->authView('login', [
            'title' => 'Masuk Admin',
            'email' => $email,
            'error' => $error,
        ]);
    }
}
