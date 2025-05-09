<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\City;
use App\Models\Country;

class DashboardController extends Controller
{
    private $bookingModel;
    private $userModel;
    private $cityModel;
    private $countryModel;

    public function __construct()
    {
        // Check if user is logged in as admin
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /login');
            exit;
        }

        $this->bookingModel = new Booking();
        $this->userModel = new User();
        $this->cityModel = new City();
        $this->countryModel = new Country();
    }

    public function index()
    {
        // Get total counts
        $totalBookings = $this->bookingModel->getTotalCount();
        $totalUsers = $this->userModel->getTotalCount();
        $totalCities = $this->cityModel->getTotalCount();
        $totalCountries = $this->countryModel->getTotalCount();

        // Get recent bookings with user information
        $recentBookings = $this->bookingModel->getRecentBookings(5);

        // Get recent users
        $recentUsers = $this->userModel->getRecentUsers(5);

        // Pass data to the view
        $data = [
            'totalBookings' => $totalBookings,
            'totalUsers' => $totalUsers,
            'totalCities' => $totalCities,
            'totalCountries' => $totalCountries,
            'recentBookings' => $recentBookings,
            'recentUsers' => $recentUsers
        ];

        // Render the dashboard view
        $this->view('admin/dashboard/index', $data);
    }
} 