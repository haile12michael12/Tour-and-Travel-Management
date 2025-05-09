<?php

namespace App\Models;

use App\Core\Model;

class City extends Model
{
    public static function create(array $data): bool
    {
        return self::query(
            "INSERT INTO cities (name, image, trip_days, price, country_id) 
             VALUES (?, ?, ?, ?, ?)",
            [
                $data['name'],
                $data['image'],
                $data['trip_days'],
                $data['price'],
                $data['country_id']
            ]
        )->rowCount() > 0;
    }

    public static function update(int $id, array $data): bool
    {
        return self::query(
            "UPDATE cities SET 
                name = ?, 
                image = ?, 
                trip_days = ?, 
                price = ?, 
                country_id = ? 
             WHERE id = ?",
            [
                $data['name'],
                $data['image'],
                $data['trip_days'],
                $data['price'],
                $data['country_id'],
                $id
            ]
        )->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        return self::query(
            "DELETE FROM cities WHERE id = ?",
            [$id]
        )->rowCount() > 0;
    }

    public static function getById(int $id): ?array
    {
        return self::fetch(
            "SELECT c.*, co.name as country_name 
             FROM cities c 
             LEFT JOIN countries co ON c.country_id = co.id 
             WHERE c.id = ?",
            [$id]
        );
    }

    public static function getByCountryId(int $countryId): array
    {
        return self::fetchAll(
            "SELECT * FROM cities WHERE country_id = ? ORDER BY name",
            [$countryId]
        );
    }

    public static function getAll(): array
    {
        return self::fetchAll(
            "SELECT c.*, co.name as country_name 
             FROM cities c 
             LEFT JOIN countries co ON c.country_id = co.id 
             ORDER BY c.name"
        );
    }
} 