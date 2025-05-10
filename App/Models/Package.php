<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Package extends Model
{
    protected $table = 'packages';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll(): array
    {
        $sql = "SELECT p.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} p 
                JOIN cities c ON p.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                ORDER BY p.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching packages: " . $e->getMessage());
            return [];
        }
    }

    public function getById(int $id)
    {
        $sql = "SELECT p.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} p 
                JOIN cities c ON p.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE p.id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding package: " . $e->getMessage());
            return null;
        }
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (name, description, city_id, price, duration, max_people, 
                includes, excludes, image, status, created_at) 
                VALUES (:name, :description, :city_id, :price, :duration, 
                :max_people, :includes, :excludes, :image, :status, NOW())";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'description' => $data['description'],
                'city_id' => $data['city_id'],
                'price' => $data['price'],
                'duration' => $data['duration'],
                'max_people' => $data['max_people'],
                'includes' => $data['includes'],
                'excludes' => $data['excludes'],
                'image' => $data['image'],
                'status' => $data['status'] ?? 'active'
            ]);
        } catch (PDOException $e) {
            error_log("Error creating package: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                SET name = :name, 
                    description = :description, 
                    city_id = :city_id, 
                    price = :price, 
                    duration = :duration, 
                    max_people = :max_people, 
                    includes = :includes, 
                    excludes = :excludes, 
                    image = :image, 
                    status = :status 
                WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'description' => $data['description'],
                'city_id' => $data['city_id'],
                'price' => $data['price'],
                'duration' => $data['duration'],
                'max_people' => $data['max_people'],
                'includes' => $data['includes'],
                'excludes' => $data['excludes'],
                'image' => $data['image'],
                'status' => $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating package: " . $e->getMessage());
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
            error_log("Error deleting package: " . $e->getMessage());
            return false;
        }
    }

    public function getPackagesByCity(int $cityId): array
    {
        $sql = "SELECT p.* 
                FROM {$this->table} p 
                WHERE p.city_id = :city_id 
                AND p.status = 'active' 
                ORDER BY p.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['city_id' => $cityId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching city packages: " . $e->getMessage());
            return [];
        }
    }

    public function getFeaturedPackages(int $limit = 6): array
    {
        $sql = "SELECT p.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} p 
                JOIN cities c ON p.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE p.status = 'active' 
                ORDER BY p.created_at DESC 
                LIMIT :limit";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching featured packages: " . $e->getMessage());
            return [];
        }
    }

    public function searchPackages(string $query): array
    {
        $sql = "SELECT p.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} p 
                JOIN cities c ON p.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE p.status = 'active' 
                AND (p.name LIKE :query 
                OR p.description LIKE :query 
                OR c.name LIKE :query 
                OR co.name LIKE :query) 
                ORDER BY p.created_at DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%{$query}%";
            $stmt->bindValue(':query', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error searching packages: " . $e->getMessage());
            return [];
        }
    }
} 