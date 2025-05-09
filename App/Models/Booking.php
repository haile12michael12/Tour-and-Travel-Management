<?php

namespace App\Models;

use App\Core\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    public static function create(array $data): bool
    {
        return self::query(
            "INSERT INTO bookings (name, phone_number, num_of_geusts, checkin_date, destination, status, city_id, user_id, payment) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['name'],
                $data['phone_number'],
                $data['num_of_geusts'],
                $data['checkin_date'],
                $data['destination'],
                $data['status'],
                $data['city_id'],
                $data['user_id'],
                $data['payment']
            ]
        )->rowCount() > 0;
    }

    public static function update(int $id, array $data): bool
    {
        return self::query(
            "UPDATE bookings SET 
                name = ?, 
                phone_number = ?, 
                num_of_geusts = ?, 
                checkin_date = ?, 
                destination = ?, 
                status = ?, 
                city_id = ?, 
                user_id = ?, 
                payment = ? 
             WHERE id = ?",
            [
                $data['name'],
                $data['phone_number'],
                $data['num_of_geusts'],
                $data['checkin_date'],
                $data['destination'],
                $data['status'],
                $data['city_id'],
                $data['user_id'],
                $data['payment'],
                $id
            ]
        )->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        return self::query(
            "DELETE FROM bookings WHERE id = ?",
            [$id]
        )->rowCount() > 0;
    }

    public static function getById(int $id): ?array
    {
        return self::fetch(
            "SELECT b.*, c.name as city_name, u.username 
             FROM bookings b 
             LEFT JOIN cities c ON b.city_id = c.id 
             LEFT JOIN users u ON b.user_id = u.id 
             WHERE b.id = ?",
            [$id]
        );
    }

    public static function getByUserId(int $userId): array
    {
        return self::fetchAll(
            "SELECT b.*, c.name as city_name 
             FROM bookings b 
             LEFT JOIN cities c ON b.city_id = c.id 
             WHERE b.user_id = ? 
             ORDER BY b.created_at DESC",
            [$userId]
        );
    }

    public static function getAll(): array
    {
        return self::fetchAll(
            "SELECT b.*, c.name as city_name, u.username 
             FROM bookings b 
             LEFT JOIN cities c ON b.city_id = c.id 
             LEFT JOIN users u ON b.user_id = u.id 
             ORDER BY b.created_at DESC"
        );
    }

    public function getRecentBookings(int $limit = 5): array
    {
        $sql = "SELECT b.*, u.username as user_name, c.name as destination 
                FROM {$this->table} b 
                LEFT JOIN users u ON b.user_id = u.id 
                LEFT JOIN cities c ON b.city_id = c.id 
                ORDER BY b.created_at DESC 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBookingsByUser(int $userId): array
    {
        return $this->where('user_id', $userId);
    }

    public function getBookingsByCity(int $cityId): array
    {
        return $this->where('city_id', $cityId);
    }

    public function getBookingsByStatus(string $status): array
    {
        return $this->where('status', $status);
    }

    public function updateStatus(int $id, string $status): bool
    {
        return $this->update($id, ['status' => $status]);
    }
}
