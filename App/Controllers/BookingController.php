<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Booking;
use App\Models\City;
use App\Models\Deal;
use App\Models\User;

class BookingController extends Controller
{
    private $bookingModel;
    private $cityModel;
    private $dealModel;
    private $userModel;
    private $db;

    public function __construct($db)
    {
        parent::__construct();
        $this->db = $db;
        $this->bookingModel = new Booking($db);
        $this->cityModel = new City($db);
        $this->dealModel = new Deal();
        $this->userModel = new User($db);
    }

    public function index()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to view your bookings.';
            header('Location: /login');
            exit;
        }

        $bookings = $this->bookingModel->getByUserId($_SESSION['user_id']);
        
        $this->view('bookings/index', [
            'title' => 'My Bookings',
            'bookings' => $bookings
        ]);
    }

    public function create()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to make a booking.';
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'city_id' => $_POST['city_id'],
                'deal_id' => $_POST['deal_id'] ?? null,
                'travel_date' => $_POST['travel_date'],
                'number_of_people' => $_POST['number_of_people'],
                'total_price' => $this->calculateTotalPrice($_POST)
            ];

            if ($this->bookingModel->create($data)) {
                $_SESSION['success'] = 'Booking created successfully!';
                header('Location: /bookings');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to create booking. Please try again.';
            }
        }

        $cities = $this->cityModel->getAll();
        $deals = $this->dealModel->getActiveDeals();
        
        $this->view('bookings/create', [
            'title' => 'Create Booking',
            'cities' => $cities,
            'deals' => $deals
        ]);
    }

    public function show($id)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to view booking details.';
            header('Location: /login');
            exit;
        }

        $booking = $this->bookingModel->getById($id);

        // Check if booking exists and belongs to user
        if (!$booking || $booking->user_id !== $_SESSION['user_id']) {
            $_SESSION['error'] = 'Booking not found.';
            header('Location: /bookings');
            exit;
        }

        $this->view('bookings/show', [
            'title' => 'Booking Details',
            'booking' => $booking
        ]);
    }

    public function cancel($id)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to cancel booking.';
            header('Location: /login');
            exit;
        }

        $booking = $this->bookingModel->getById($id);

        // Check if booking exists and belongs to user
        if (!$booking || $booking->user_id !== $_SESSION['user_id']) {
            $_SESSION['error'] = 'Booking not found.';
            header('Location: /bookings');
            exit;
        }

        // Check if booking can be cancelled
        if ($booking->status !== 'pending') {
            $_SESSION['error'] = 'This booking cannot be cancelled.';
            header('Location: /bookings');
            exit;
        }

        if ($this->bookingModel->updateStatus($id, 'cancelled')) {
            $_SESSION['success'] = 'Booking cancelled successfully.';
        } else {
            $_SESSION['error'] = 'Failed to cancel booking. Please try again.';
        }

        header('Location: /bookings');
        exit;
    }

    private function calculateTotalPrice($data)
    {
        $city = $this->cityModel->getById($data['city_id']);
        $basePrice = $city->price_per_person;
        $numberOfPeople = $data['number_of_people'];
        $totalPrice = $basePrice * $numberOfPeople;

        // Apply deal discount if applicable
        if (!empty($data['deal_id'])) {
            $deal = $this->dealModel->getById($data['deal_id']);
            if ($deal && $deal->status === 'active') {
                $discount = ($totalPrice * $deal->discount_percentage) / 100;
                $totalPrice -= $discount;
            }
        }

        return $totalPrice;
    }

    public function showAdmin($id)
    {
        $booking = $this->bookingModel->getById($id);
        if (!$booking) {
            $_SESSION['error'] = "Booking not found";
            header("Location: " . ADMINURL . "/bookings");
            exit();
        }
        require_once 'App/Views/admin-panel/bookings/show-booking.php';
    }

    public function createAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['user_id']) || empty($_POST['city_id']) || empty($_POST['check_in']) || 
                empty($_POST['check_out']) || empty($_POST['guests']) || empty($_POST['total_price'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: " . ADMINURL . "/bookings/create");
                exit();
            }

            $data = [
                'user_id' => $_POST['user_id'],
                'city_id' => $_POST['city_id'],
                'check_in' => $_POST['check_in'],
                'check_out' => $_POST['check_out'],
                'guests' => $_POST['guests'],
                'total_price' => $_POST['total_price'],
                'status' => $_POST['status'] ?? 'pending'
            ];

            if ($this->bookingModel->create($data)) {
                $_SESSION['success'] = "Booking created successfully";
                header("Location: " . ADMINURL . "/bookings");
                exit();
            } else {
                $_SESSION['error'] = "Error creating booking";
                header("Location: " . ADMINURL . "/bookings/create");
                exit();
            }
        }

        $cities = $this->cityModel->getAll();
        $users = $this->userModel->getAll();
        require_once 'App/Views/admin-panel/bookings/create-booking.php';
    }

    public function editAdmin($id)
    {
        $booking = $this->bookingModel->getById($id);
        if (!$booking) {
            $_SESSION['error'] = "Booking not found";
            header("Location: " . ADMINURL . "/bookings");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['check_in']) || empty($_POST['check_out']) || 
                empty($_POST['guests']) || empty($_POST['total_price'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: " . ADMINURL . "/bookings/edit/" . $id);
                exit();
            }

            $data = [
                'check_in' => $_POST['check_in'],
                'check_out' => $_POST['check_out'],
                'guests' => $_POST['guests'],
                'total_price' => $_POST['total_price'],
                'status' => $_POST['status']
            ];

            if ($this->bookingModel->update($id, $data)) {
                $_SESSION['success'] = "Booking updated successfully";
                header("Location: " . ADMINURL . "/bookings");
                exit();
            } else {
                $_SESSION['error'] = "Error updating booking";
            }
        }

        require_once 'App/Views/admin-panel/bookings/edit-booking.php';
    }

    public function deleteAdmin($id)
    {
        if ($this->bookingModel->delete($id)) {
            $_SESSION['success'] = "Booking deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting booking";
        }
        header("Location: " . ADMINURL . "/bookings");
        exit();
    }

    public function updateStatusAdmin($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
            if ($this->bookingModel->updateStatus($id, $_POST['status'])) {
                $_SESSION['success'] = "Booking status updated successfully";
            } else {
                $_SESSION['error'] = "Error updating booking status";
            }
        }
        header("Location: " . ADMINURL . "/bookings");
        exit();
    }
} 