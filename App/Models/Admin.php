<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Admin extends Model
{
    protected $table = 'admins';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding admin: " . $e->getMessage());
            return null;
        }
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching admins: " . $e->getMessage());
            return [];
        }
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (adminname, email, password, created_at) 
                VALUES (:adminname, :email, :password, NOW())";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'adminname' => $data['adminname'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);
        } catch (PDOException $e) {
            error_log("Error creating admin: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                SET adminname = :adminname, 
                    email = :email" . 
                    (isset($data['password']) ? ", password = :password" : "") . 
                " WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $params = [
                'id' => $id,
                'adminname' => $data['adminname'],
                'email' => $data['email']
            ];
            
            if (isset($data['password'])) {
                $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error updating admin: " . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting admin: " . $e->getMessage());
            return false;
        }
    }

    public function login(string $email, string $password)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch(PDO::FETCH_OBJ);

            if ($admin && password_verify($password, $admin->password)) {
                return $admin;
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error during login: " . $e->getMessage());
            return null;
        }
    }

    public function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = :email";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            return (bool) $stmt->fetch(PDO::FETCH_OBJ)->count;
        } catch (PDOException $e) {
            error_log("Error checking email: " . $e->getMessage());
            return false;
        }
    }
}