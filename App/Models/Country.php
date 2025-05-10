<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Country extends Model
{
    protected $table = 'countries';

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
            error_log("Error finding country: " . $e->getMessage());
            return null;
        }
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching countries: " . $e->getMessage());
            return [];
        }
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                 (name, continent, population, territory, description, image) 
                 VALUES (:name, :continent, :population, :territory, :description, :image)";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'continent' => $data['continent'],
                'population' => $data['population'],
                'territory' => $data['territory'],
                'description' => $data['description'],
                'image' => $data['image']
            ]);
        } catch (PDOException $e) {
            error_log("Error creating country: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                 SET name = :name, 
                     continent = :continent, 
                     population = :population, 
                     territory = :territory, 
                     description = :description, 
                     image = :image 
                 WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'continent' => $data['continent'],
                'population' => $data['population'],
                'territory' => $data['territory'],
                'description' => $data['description'],
                'image' => $data['image']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating country: " . $e->getMessage());
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
            error_log("Error deleting country: " . $e->getMessage());
            return false;
        }
    }

    public function getPopular($limit = 6)
    {
        $sql = "SELECT c.*, COUNT(b.id) as booking_count 
                FROM {$this->table} c 
                LEFT JOIN cities ci ON c.id = ci.country_id 
                LEFT JOIN bookings b ON ci.id = b.city_id 
                GROUP BY c.id 
                ORDER BY booking_count DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getWithCities()
    {
        $sql = "SELECT c.*, COUNT(ci.id) as city_count 
                FROM {$this->table} c 
                LEFT JOIN cities ci ON c.id = ci.country_id 
                GROUP BY c.id 
                ORDER BY c.name ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getAllCountriesWithAvgPrice() {
        $sql = "SELECT countries.id AS id, countries.name AS name, countries.image AS image, 
                countries.continent AS continent, countries.population AS population, 
                countries.territory AS territory, countries.description AS description,
                AVG(cities.price) AS avg_price 
                FROM countries 
                JOIN cities ON countries.id = cities.country_id 
                GROUP BY(cities.country_id)";
        return $this->query($sql);
    }
}