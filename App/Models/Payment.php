<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Payment extends Model
{
    protected $table = 'payments';

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (
                    booking_id,
                    user_id,
                    amount,
                    payment_method,
                    transaction_id,
                    status,
                    created_at
                ) VALUES (
                    :booking_id,
                    :user_id,
                    :amount,
                    :payment_method,
                    :transaction_id,
                    :status,
                    NOW()
                )";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'booking_id' => $data['booking_id'],
                'user_id' => $data['user_id'],
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'transaction_id' => $data['transaction_id'],
                'status' => $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("Error creating payment: " . $e->getMessage());
            return false;
        }
    }

    public function findByBookingId(int $bookingId)
    {
        $sql = "SELECT p.*, b.total_price, b.status as booking_status
                FROM {$this->table} p
                JOIN bookings b ON p.booking_id = b.id
                WHERE p.booking_id = :booking_id";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['booking_id' => $bookingId]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error finding payment: " . $e->getMessage());
            return null;
        }
    }

    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE {$this->table} 
                SET status = :status, 
                    updated_at = NOW() 
                WHERE id = :id";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
        } catch (PDOException $e) {
            error_log("Error updating payment status: " . $e->getMessage());
            return false;
        }
    }

    public function getByUserId(int $userId, int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT p.*, b.travel_date, c.name as city_name
                FROM {$this->table} p
                JOIN bookings b ON p.booking_id = b.id
                JOIN cities c ON b.city_id = c.id
                WHERE p.user_id = :user_id
                ORDER BY p.created_at DESC
                LIMIT :limit OFFSET :offset";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error fetching user payments: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalPayments(int $userId): int
    {
        $sql = "SELECT COUNT(*) as total 
                FROM {$this->table} 
                WHERE user_id = :user_id";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return (int) $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) {
            error_log("Error counting payments: " . $e->getMessage());
            return 0;
        }
    }

    public function getPaymentMethods(): array
    {
        return [
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'paypal' => 'PayPal',
            'bank_transfer' => 'Bank Transfer'
        ];
    }

    public function getStatusBadgeClass(string $status): string
    {
        switch ($status) {
            case 'pending':
                return 'warning';
            case 'completed':
                return 'success';
            case 'failed':
                return 'danger';
            case 'refunded':
                return 'info';
            default:
                return 'secondary';
        }
    }
} 