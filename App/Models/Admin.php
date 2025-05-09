<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model
{
    public static function findByEmail(string $email): ?array
    {
        return self::fetch(
            "SELECT * FROM admins WHERE email = ?",
            [$email]
        );
    }

    public static function create(array $data): bool
    {
        return self::query(
            "INSERT INTO admins (adminname, email, mypassword) VALUES (?, ?, ?)",
            [$data['adminname'], $data['email'], $data['mypassword']]
        )->rowCount() > 0;
    }

    public static function update(int $id, array $data): bool
    {
        return self::query(
            "UPDATE admins SET adminname = ?, email = ?, mypassword = ? WHERE id = ?",
            [$data['adminname'], $data['email'], $data['mypassword'], $id]
        )->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        return self::query(
            "DELETE FROM admins WHERE id = ?",
            [$id]
        )->rowCount() > 0;
    }

    public static function getAll(): array
    {
        return self::fetchAll("SELECT * FROM admins ORDER BY created_at DESC");
    }
}