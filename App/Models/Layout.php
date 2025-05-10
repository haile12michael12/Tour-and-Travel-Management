<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Layout extends Model
{
    protected $table = 'layouts';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getLayoutById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding layout: " . $e->getMessage());
            return null;
        }
    }

    public function getLayoutByType(string $type)
    {
        $sql = "SELECT * FROM {$this->table} WHERE type = :type AND status = 'active'";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['type' => $type]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding layout by type: " . $e->getMessage());
            return null;
        }
    }

    public function getAllLayouts(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching layouts: " . $e->getMessage());
            return [];
        }
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (name, type, content, status, created_at) 
                VALUES (:name, :type, :content, :status, NOW())";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'type' => $data['type'],
                'content' => $data['content'],
                'status' => $data['status'] ?? 'active'
            ]);
        } catch (PDOException $e) {
            error_log("Error creating layout: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                SET name = :name, 
                    type = :type, 
                    content = :content, 
                    status = :status 
                WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'type' => $data['type'],
                'content' => $data['content'],
                'status' => $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating layout: " . $e->getMessage());
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
            error_log("Error deleting layout: " . $e->getMessage());
            return false;
        }
    }

    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE {$this->table} SET status = :status WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
        } catch (PDOException $e) {
            error_log("Error updating layout status: " . $e->getMessage());
            return false;
        }
    }
} 