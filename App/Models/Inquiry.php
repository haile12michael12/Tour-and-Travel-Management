<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Inquiry extends Model
{
    protected $table = 'inquiries';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll(): array
    {
        $sql = "SELECT i.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} i 
                JOIN cities c ON i.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                ORDER BY i.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching inquiries: " . $e->getMessage());
            return [];
        }
    }

    public function getById(int $id)
    {
        $sql = "SELECT i.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} i 
                JOIN cities c ON i.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE i.id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding inquiry: " . $e->getMessage());
            return null;
        }
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (name, email, phone, city_id, check_in, check_out, guests, message, status, created_at) 
                VALUES (:name, :email, :phone, :city_id, :check_in, :check_out, :guests, :message, :status, NOW())";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'city_id' => $data['city_id'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'],
                'message' => $data['message'],
                'status' => $data['status'] ?? 'pending'
            ]);
        } catch (PDOException $e) {
            error_log("Error creating inquiry: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                SET name = :name, 
                    email = :email, 
                    phone = :phone, 
                    city_id = :city_id, 
                    check_in = :check_in, 
                    check_out = :check_out, 
                    guests = :guests, 
                    message = :message, 
                    status = :status 
                WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'city_id' => $data['city_id'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'],
                'message' => $data['message'],
                'status' => $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating inquiry: " . $e->getMessage());
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
            error_log("Error deleting inquiry: " . $e->getMessage());
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
            error_log("Error updating inquiry status: " . $e->getMessage());
            return false;
        }
    }

    public function getInquiriesByCity(int $cityId): array
    {
        $sql = "SELECT i.* 
                FROM {$this->table} i 
                WHERE i.city_id = :city_id 
                ORDER BY i.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['city_id' => $cityId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching city inquiries: " . $e->getMessage());
            return [];
        }
    }

    public function getInquiriesByStatus(string $status): array
    {
        $sql = "SELECT i.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} i 
                JOIN cities c ON i.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE i.status = :status 
                ORDER BY i.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching inquiries by status: " . $e->getMessage());
            return [];
        }
    }

    public function getStatusBadgeClass(string $status): string
    {
        switch ($status) {
            case 'pending':
                return 'warning';
            case 'in_progress':
                return 'info';
            case 'resolved':
                return 'success';
            case 'closed':
                return 'secondary';
            default:
                return 'primary';
        }
    }

    public function getStatusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed'
        ];
    }
} 