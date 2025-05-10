<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Booking extends Model
{
    protected $table = 'bookings';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll(): array
    {
        $sql = "SELECT b.*, c.name as city_name, co.name as country_name, u.name as user_name 
                FROM {$this->table} b 
                JOIN cities c ON b.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                JOIN users u ON b.user_id = u.id 
                ORDER BY b.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching bookings: " . $e->getMessage());
            return [];
        }
    }

    public function getById(int $id)
    {
        $sql = "SELECT b.*, c.name as city_name, co.name as country_name, u.name as user_name 
                FROM {$this->table} b 
                JOIN cities c ON b.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                JOIN users u ON b.user_id = u.id 
                WHERE b.id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding booking: " . $e->getMessage());
            return null;
        }
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (user_id, city_id, check_in, check_out, guests, total_price, status, created_at) 
                VALUES (:user_id, :city_id, :check_in, :check_out, :guests, :total_price, :status, NOW())";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'user_id' => $data['user_id'],
                'city_id' => $data['city_id'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'],
                'total_price' => $data['total_price'],
                'status' => $data['status'] ?? 'pending'
            ]);
        } catch (PDOException $e) {
            error_log("Error creating booking: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                SET check_in = :check_in, 
                    check_out = :check_out, 
                    guests = :guests, 
                    total_price = :total_price, 
                    status = :status 
                WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'],
                'total_price' => $data['total_price'],
                'status' => $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating booking: " . $e->getMessage());
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
            error_log("Error deleting booking: " . $e->getMessage());
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
            error_log("Error updating booking status: " . $e->getMessage());
            return false;
        }
    }

    public function getBookingsByUser(int $userId): array
    {
        $sql = "SELECT b.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} b 
                JOIN cities c ON b.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE b.user_id = :user_id 
                ORDER BY b.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching user bookings: " . $e->getMessage());
            return [];
        }
    }

    public function getBookingsByCity(int $cityId): array
    {
        $sql = "SELECT b.*, u.name as user_name 
                FROM {$this->table} b 
                JOIN users u ON b.user_id = u.id 
                WHERE b.city_id = :city_id 
                ORDER BY b.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['city_id' => $cityId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching city bookings: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalBookingsByCountry(int $countryId): int
    {
        $sql = "SELECT COUNT(b.id) as total 
                FROM {$this->table} b 
                JOIN cities c ON b.city_id = c.id 
                WHERE c.country_id = :country_id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['country_id' => $countryId]);
            return (int) $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) {
            error_log("Error counting bookings: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalBookings()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(\PDO::FETCH_OBJ)->total;
    }

    public function getRecentBookings($limit = 5)
    {
        $sql = "SELECT b.*, 
                       c.name as city_name, 
                       co.name as country_name,
                       u.name as user_name
                FROM {$this->table} b
                JOIN cities c ON b.city_id = c.id
                JOIN countries co ON c.country_id = co.id
                JOIN users u ON b.user_id = u.id
                ORDER BY b.booking_date DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getBookingsByStatus($status)
    {
        $sql = "SELECT b.*, 
                       c.name as city_name, 
                       co.name as country_name,
                       u.name as user_name
                FROM {$this->table} b
                JOIN cities c ON b.city_id = c.id
                JOIN countries co ON c.country_id = co.id
                JOIN users u ON b.user_id = u.id
                WHERE b.status = :status
                ORDER BY b.booking_date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':status', $status, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
