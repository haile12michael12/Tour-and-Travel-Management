<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    public function getRecentUsers(int $limit = 5): array
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit);
    }

    public function findByEmail(string $email): ?array
    {
        $result = $this->where('email', $email);
        return $result ? $result[0] : null;
    }

    public function findByUsername(string $username): ?array
    {
        $result = $this->where('username', $username);
        return $result ? $result[0] : null;
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    public static function create(array $data): bool
    {
        return self::query(
            "INSERT INTO users (email, username, mypassword) VALUES (?, ?, ?)",
            [
                $data['email'],
                $data['username'],
                $data['mypassword']
            ]
        )->rowCount() > 0;
    }

    public static function update(int $id, array $data): bool
    {
        return self::query(
            "UPDATE users SET email = ?, username = ?, mypassword = ? WHERE id = ?",
            [
                $data['email'],
                $data['username'],
                $data['mypassword'],
                $id
            ]
        )->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        return self::query(
            "DELETE FROM users WHERE id = ?",
            [$id]
        )->rowCount() > 0;
    }

    public static function getById(int $id): ?array
    {
        return self::fetch(
            "SELECT * FROM users WHERE id = ?",
            [$id]
        );
    }

    public static function getAll(): array
    {
        return self::fetchAll(
            "SELECT * FROM users ORDER BY created_at DESC"
        );
    }
}
