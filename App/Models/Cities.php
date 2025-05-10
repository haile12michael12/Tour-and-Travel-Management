<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class City extends Model
{
    protected $table = 'cities';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getFeatured($limit = 3)
    {
        $sql = "SELECT c.*, co.name as country_name 
                FROM {$this->table} c 
                JOIN countries co ON c.country_id = co.id 
                WHERE c.is_featured = 1 
                ORDER BY c.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function search($countryId, $price)
    {
        $sql = "SELECT c.*, co.name as country_name 
                FROM {$this->table} c 
                JOIN countries co ON c.country_id = co.id 
                WHERE c.country_id = :country_id 
                AND c.price <= :price 
                ORDER BY c.price ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':country_id', $countryId, \PDO::PARAM_INT);
        $stmt->bindValue(':price', $price, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getByCountry($countryId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE country_id = :country_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':country_id', $countryId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getPopular($limit = 6)
    {
        $sql = "SELECT c.*, COUNT(b.id) as booking_count 
                FROM {$this->table} c 
                LEFT JOIN bookings b ON c.id = b.city_id 
                GROUP BY c.id 
                ORDER BY booking_count DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getById(int $id)
    {
        $sql = "SELECT c.*, co.name as country_name 
                FROM {$this->table} c 
                JOIN countries co ON c.country_id = co.id 
                WHERE c.id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding city: " . $e->getMessage());
            return null;
        }
    }

    public function getByCountryId(int $countryId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE country_id = :country_id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['country_id' => $countryId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching cities: " . $e->getMessage());
            return [];
        }
    }

    public function getCitiesWithBookingCount(int $countryId): array
    {
        $sql = "SELECT c.id, c.name, c.image, c.trip_days, c.price,
                COUNT(b.city_id) AS count_bookings 
                FROM {$this->table} c 
                LEFT JOIN bookings b ON c.id = b.city_id 
                WHERE c.country_id = :country_id 
                GROUP BY c.id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['country_id' => $countryId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching cities with booking count: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalCitiesByCountry(int $countryId): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE country_id = :country_id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['country_id' => $countryId]);
            return (int) $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) {
            error_log("Error counting cities: " . $e->getMessage());
            return 0;
        }
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (name, country_id, description, image, price, population) 
                VALUES (:name, :country_id, :description, :image, :price, :population)";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'country_id' => $data['country_id'],
                'description' => $data['description'],
                'image' => $data['image'],
                'price' => $data['price'],
                'population' => $data['population']
            ]);
        } catch (PDOException $e) {
            error_log("Error creating city: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                SET name = :name, 
                    country_id = :country_id, 
                    description = :description, 
                    image = :image,
                    price = :price,
                    population = :population 
                WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'country_id' => $data['country_id'],
                'description' => $data['description'],
                'image' => $data['image'],
                'price' => $data['price'],
                'population' => $data['population']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating city: " . $e->getMessage());
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
            error_log("Error deleting city: " . $e->getMessage());
            return false;
        }
    }

    public function getAll(): array
    {
        $sql = "SELECT c.*, co.name as country_name 
                FROM {$this->table} c 
                JOIN countries co ON c.country_id = co.id 
                ORDER BY c.name ASC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching cities: " . $e->getMessage());
            return [];
        }
    }
} 