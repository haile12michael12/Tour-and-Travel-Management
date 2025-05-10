<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Country;
use App\Models\City;
use App\Models\Booking;

class AboutController extends Controller
{
    private $countryModel;
    private $cityModel;
    private $bookingModel;

    public function __construct()
    {
        parent::__construct();
        $this->countryModel = new Country();
        $this->cityModel = new City();
        $this->bookingModel = new Booking();
    }

    public function index()
    {
        $this->view('about/index', [
            'title' => 'About Us'
        ]);
    }

    public function country($id)
    {
        $country = $this->countryModel->getById($id);
        
        if (!$country) {
            $_SESSION['error'] = 'Country not found.';
            header('Location: /404');
            exit;
        }

        // Get cities with their images
        $citiesImages = $this->cityModel->getByCountryId($id);

        // Get cities with booking counts
        $cities = $this->cityModel->getCitiesWithBookingCount($id);

        // Get total number of cities
        $numCities = $this->cityModel->getTotalCitiesByCountry($id);

        // Get total number of bookings
        $numBookings = $this->bookingModel->getTotalBookingsByCountry($id);

        $this->view('about/country', [
            'title' => 'About ' . $country->name,
            'country' => $country,
            'citiesImages' => $citiesImages,
            'cities' => $cities,
            'numCities' => $numCities,
            'numBookings' => $numBookings
        ]);
    }
} 