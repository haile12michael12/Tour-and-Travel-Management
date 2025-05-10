<?php

class CountryController {
    private $countryModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->countryModel = new Country($db);
    }

    public function index() {
        $countries = $this->countryModel->getAll();
        require_once 'App/Views/admin-panel/countries-admins/show-country.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['name']) || empty($_POST['continent']) || empty($_POST['population']) 
                || empty($_POST['territory']) || empty($_POST['description'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: " . ADMINURL . "/countries/create");
                exit();
            }

            $data = [
                'name' => $_POST['name'],
                'continent' => $_POST['continent'],
                'population' => $_POST['population'],
                'territory' => $_POST['territory'],
                'description' => $_POST['description'],
                'image' => $_FILES['image']['name']
            ];

            $dir = "App/Views/admin-panel/countries-admins/images_countries/" . basename($_FILES['image']['name']);

            if ($this->countryModel->create($data) && move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
                $_SESSION['success'] = "Country created successfully";
                header("Location: " . ADMINURL . "/countries");
                exit();
            } else {
                $_SESSION['error'] = "Error creating country";
                header("Location: " . ADMINURL . "/countries/create");
                exit();
            }
        }

        require_once 'App/Views/admin-panel/countries-admins/create-country.php';
    }

    public function edit($id) {
        $country = $this->countryModel->getById($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'continent' => $_POST['continent'],
                'population' => $_POST['population'],
                'territory' => $_POST['territory'],
                'description' => $_POST['description'],
                'image' => $_FILES['image']['name'] ?: $country['image']
            ];

            if ($this->countryModel->update($id, $data)) {
                if ($_FILES['image']['name']) {
                    $dir = "App/Views/admin-panel/countries-admins/images_countries/" . basename($_FILES['image']['name']);
                    move_uploaded_file($_FILES['image']['tmp_name'], $dir);
                }
                $_SESSION['success'] = "Country updated successfully";
                header("Location: " . ADMINURL . "/countries");
                exit();
            } else {
                $_SESSION['error'] = "Error updating country";
            }
        }

        require_once 'App/Views/admin-panel/countries-admins/edit-country.php';
    }

    public function delete($id) {
        if ($this->countryModel->delete($id)) {
            $_SESSION['success'] = "Country deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting country";
        }
        header("Location: " . ADMINURL . "/countries");
        exit();
    }
} 