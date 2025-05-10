<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PaymentController extends Controller
{
    private $paymentModel;
    private $bookingModel;
    private $mailer;

    public function __construct()
    {
        parent::__construct();
        $this->paymentModel = new Payment();
        $this->bookingModel = new Booking();
        $this->mailer = new PHPMailer(true);
        $this->setupMailer();
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    private function setupMailer()
    {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = $_ENV['MAIL_HOST'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $_ENV['MAIL_USERNAME'];
            $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = $_ENV['MAIL_PORT'];
            $this->mailer->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        } catch (Exception $e) {
            error_log("Mailer setup error: " . $e->getMessage());
        }
    }

    public function process($bookingId)
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to make a payment.';
            header('Location: /login');
            exit;
        }

        $booking = $this->bookingModel->getById($bookingId);

        if (!$booking || $booking->user_id !== $_SESSION['user_id']) {
            $_SESSION['error'] = 'Invalid booking.';
            header('Location: /bookings');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Create Stripe PaymentIntent
                $paymentIntent = PaymentIntent::create([
                    'amount' => $booking->total_price * 100, // Convert to cents
                    'currency' => 'usd',
                    'payment_method' => $_POST['payment_method_id'],
                    'confirm' => true,
                    'return_url' => $_ENV['APP_URL'] . '/payment/success/' . $bookingId
                ]);

                // Create payment record
                $paymentData = [
                    'booking_id' => $bookingId,
                    'user_id' => $_SESSION['user_id'],
                    'amount' => $booking->total_price,
                    'payment_method' => 'credit_card',
                    'transaction_id' => $paymentIntent->id,
                    'status' => 'completed'
                ];

                if ($this->paymentModel->create($paymentData)) {
                    // Update booking status
                    $this->bookingModel->updateStatus($bookingId, 'confirmed');
                    $this->bookingModel->updatePaymentStatus($bookingId, 'paid');

                    // Send confirmation email
                    $this->sendPaymentConfirmationEmail($booking, $paymentData);

                    $_SESSION['success'] = 'Payment processed successfully!';
                    header('Location: /bookings/' . $bookingId);
                    exit;
                }
            } catch (\Exception $e) {
                error_log("Payment processing error: " . $e->getMessage());
                $_SESSION['error'] = 'Payment processing failed. Please try again.';
            }
        }

        $this->view('payments/process', [
            'title' => 'Process Payment',
            'booking' => $booking,
            'stripeKey' => $_ENV['STRIPE_PUBLIC_KEY']
        ]);
    }

    public function success($bookingId)
    {
        $payment = $this->paymentModel->findByBookingId($bookingId);

        if (!$payment) {
            $_SESSION['error'] = 'Payment not found.';
            header('Location: /bookings');
            exit;
        }

        $this->view('payments/success', [
            'title' => 'Payment Successful',
            'payment' => $payment
        ]);
    }

    public function history()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to view payment history.';
            header('Location: /login');
            exit;
        }

        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $payments = $this->paymentModel->getByUserId($_SESSION['user_id'], $page, $limit);
        $totalPayments = $this->paymentModel->getTotalPayments($_SESSION['user_id']);
        $totalPages = ceil($totalPayments / $limit);

        $this->view('payments/history', [
            'title' => 'Payment History',
            'payments' => $payments,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    private function sendPaymentConfirmationEmail($booking, $payment)
    {
        try {
            $this->mailer->addAddress($booking->user_email, $booking->user_name);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Payment Confirmation - Tour and Travel';
            $this->mailer->Body = $this->getPaymentConfirmationTemplate($booking, $payment);
            $this->mailer->send();
        } catch (Exception $e) {
            error_log("Payment confirmation email error: " . $e->getMessage());
        }
    }

    private function getPaymentConfirmationTemplate($booking, $payment)
    {
        return "
            <h2>Payment Confirmation</h2>
            <p>Dear {$booking->user_name},</p>
            <p>Thank you for your payment. Your booking has been confirmed.</p>
            
            <h3>Payment Details:</h3>
            <ul>
                <li>Transaction ID: {$payment['transaction_id']}</li>
                <li>Amount: $" . number_format($payment['amount'], 2) . "</li>
                <li>Payment Method: " . ucfirst($payment['payment_method']) . "</li>
                <li>Date: " . date('F d, Y H:i:s') . "</li>
            </ul>

            <h3>Booking Details:</h3>
            <ul>
                <li>Destination: {$booking->city_name}, {$booking->country_name}</li>
                <li>Travel Date: " . date('F d, Y', strtotime($booking->travel_date)) . "</li>
                <li>Number of People: {$booking->number_of_people}</li>
            </ul>

            <p>You can view your booking details at: {$_ENV['APP_URL']}/bookings/{$booking->id}</p>
            
            <p>If you have any questions, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>Tour and Travel Team</p>
        ";
    }
} 