<?php

namespace App\Models;

use App\Core\Model;

class Country extends Model
{
    public static function create(array $data): bool
    {
        return self::query(
            "INSERT INTO countries (name, image, continent, population, territory, description) 
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                $data['name'],
                $data['image'],
                $data['continent'],
                $data['population'],
                $data['territory'],
                $data['description']
            ]
        )->rowCount() > 0;
    }

    public static function update(int $id, array $data): bool
    {
        return self::query(
            "UPDATE countries SET 
                name = ?, 
                image = ?, 
                continent = ?, 
                population = ?, 
                territory = ?, 
                description = ? 
             WHERE id = ?",
            [
                $data['name'],
                $data['image'],
                $data['continent'],
                $data['population'],
                $data['territory'],
                $data['description'],
                $id
            ]
        )->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        return self::query(
            "DELETE FROM countries WHERE id = ?",
            [$id]
        )->rowCount() > 0;
    }

    public static function getById(int $id): ?array
    {
        return self::fetch(
            "SELECT * FROM countries WHERE id = ?",
            [$id]
        );
    }

    public static function getAll(): array
    {
        return self::fetchAll(
            "SELECT * FROM countries ORDER BY name"
        );
    }

    public static function getByContinent(string $continent): array
    {
        return self::fetchAll(
            "SELECT * FROM countries WHERE continent = ? ORDER BY name",
            [$continent]
        );
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