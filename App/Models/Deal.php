<?php

namespace App\Models;

use App\Core\Model;

class Deal extends Model
{
    protected $table = 'deals';

    public function getActiveDeals($limit = 4)
    {
        $sql = "SELECT d.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} d 
                JOIN cities c ON d.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE d.is_active = 1 
                AND d.valid_until >= CURDATE() 
                ORDER BY d.discount_percentage DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $sql = "SELECT d.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} d 
                JOIN cities c ON d.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE d.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function getByCity($cityId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE city_id = :city_id 
                AND is_active = 1 
                AND valid_until >= CURDATE() 
                ORDER BY discount_percentage DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':city_id', $cityId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getExpiringSoon($days = 7)
    {
        $sql = "SELECT d.*, c.name as city_name, co.name as country_name 
                FROM {$this->table} d 
                JOIN cities c ON d.city_id = c.id 
                JOIN countries co ON c.country_id = co.id 
                WHERE d.is_active = 1 
                AND d.valid_until BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :days DAY) 
                ORDER BY d.valid_until ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':days', $days, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
} 