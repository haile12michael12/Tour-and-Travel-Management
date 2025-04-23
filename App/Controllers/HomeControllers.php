<?php
class HomeController extends Controller {
    public function index() {
        // Load the CountryModel
        $countryModel = new CountryModel();

        // Fetch all countries with average price
        $allCountries = $countryModel->getAllCountriesWithAvgPrice();

        // Pass data to the view
        $this->view('home/index', [
            'allCountries' => $allCountries
        ]);
    }
}