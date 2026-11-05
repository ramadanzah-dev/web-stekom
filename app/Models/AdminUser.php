<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class AdminUser
{
    /**
     * @return array<string, mixed>|null
     */
    public function findByEmail(string $email): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, nama, email, password_hash, role, aktif, last_login_at
             FROM users
             WHERE email = :email AND role = :role
             LIMIT 1'
        );
        $statement->bindValue(':email', $email);
        $statement->bindValue(':role', 'admin');
        $statement->execute();

        $user = $statement->fetch();

        return $user === false ? null : $user;
    }

    public function touchLogin(int $id): void
    {
        $statement = Database::connection()->prepare(
            'UPDATE users SET last_login_at = NOW() WHERE id = :id'
        );
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
