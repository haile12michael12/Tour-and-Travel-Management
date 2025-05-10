<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

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

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (
                    name, 
                    email, 
                    password, 
                    role,
                    created_at
                ) VALUES (
                    :name,
                    :email,
                    :password,
                    :role,
                    NOW()
                )";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role' => $data['role'] ?? 'user'
            ]);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET 
                name = :name,
                email = :email,
                updated_at = NOW()
                WHERE id = :id";

        if (!empty($data['password'])) {
            $sql = "UPDATE {$this->table} SET 
                    name = :name,
                    email = :email,
                    password = :password,
                    updated_at = NOW()
                    WHERE id = :id";
        }

        try {
            $stmt = $this->db->prepare($sql);
            $params = [
                'id' => $id,
                'name' => $data['name'],
                'email' => $data['email']
            ];

            if (!empty($data['password'])) {
                $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public static function getById(int $id): ?array
    {
        return self::fetch(
            "SELECT * FROM users WHERE id = ?",
            [$id]
        );
    }

    public function getAll(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalUsers(): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        try {
            $stmt = $this->db->query($sql);
            return (int) $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) {
            error_log("Error counting users: " . $e->getMessage());
            return 0;
        }
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
