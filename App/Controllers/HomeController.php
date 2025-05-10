<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Deal;

class HomeController extends Controller
{
    private $cityModel;
    private $countryModel;
    private $dealModel;

    public function __construct()
    {
        $this->cityModel = new City();
        $this->countryModel = new Country();
        $this->dealModel = new Deal();
    }

    public function index()
    {
        // Get featured destinations
        $featuredDestinations = $this->cityModel->getFeatured(3);
        
        // Get special deals
        $specialDeals = $this->dealModel->getActiveDeals(4);
        
        // Get popular countries
        $popularCountries = $this->countryModel->getPopular(6);

        // Get search data for the search form
        $countries = $this->countryModel->getAll();

        // Pass data to the view
        $data = [
            'featuredDestinations' => $featuredDestinations,
            'specialDeals' => $specialDeals,
            'popularCountries' => $popularCountries,
            'countries' => $countries,
            'title' => 'Home - Tour and Travel Management'
        ];

        $this->view('pages/home', $data);
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $countryId = $_POST['country_id'] ?? null;
            $price = $_POST['price'] ?? null;

            if (empty($countryId) || empty($price)) {
                $_SESSION['error'] = 'Please fill in all search criteria';
                header('Location: /');
                exit;
            }

            $searchResults = $this->cityModel->search($countryId, $price);
            
            $data = [
                'searchResults' => $searchResults,
                'title' => 'Search Results - Tour and Travel Management'
            ];

            $this->view('pages/search', $data);
        } else {
            header('Location: /');
            exit;
        }
    }

    public function newsletter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Please provide a valid email address';
                header('Location: /');
                exit;
            }

            // TODO: Add newsletter subscription logic
            $_SESSION['success'] = 'Thank you for subscribing to our newsletter!';
            header('Location: /');
            exit;
        }
    }

    public function about(): void
    {
        $this->view('home/about', [
            'title' => 'About Us',
            'description' => 'Learn more about our services'
        ]);
    }

    public function contact(): void
    {
        $this->view('home/contact', [
            'title' => 'Contact Us',
            'description' => 'Get in touch with us'
        ]);
    }
} 