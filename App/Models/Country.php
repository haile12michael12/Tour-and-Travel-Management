<?php
class CountryModel extends Model {
    protected $table = 'countries';

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