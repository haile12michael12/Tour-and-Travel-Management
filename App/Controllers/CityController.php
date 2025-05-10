<?php

class CityController {
    private $cityModel;
    private $countryModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->cityModel = new City($db);
        $this->countryModel = new Country($db);
    }

    public function index() {
        $cities = $this->cityModel->getAll();
        require_once 'App/Views/admin-panel/cities-admins/show-city.php';
    }

    public function create() {
        $countries = $this->countryModel->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['name']) || empty($_POST['country_id']) || empty($_POST['description']) 
                || empty($_POST['price']) || empty($_POST['population'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: " . ADMINURL . "/cities/create");
                exit();
            }

            $data = [
                'name' => $_POST['name'],
                'country_id' => $_POST['country_id'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'population' => $_POST['population'],
                'image' => $_FILES['image']['name']
            ];

            $dir = "App/Views/admin-panel/cities-admins/images_cities/" . basename($_FILES['image']['name']);

            if ($this->cityModel->create($data) && move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
                $_SESSION['success'] = "City created successfully";
                header("Location: " . ADMINURL . "/cities");
                exit();
            } else {
                $_SESSION['error'] = "Error creating city";
                header("Location: " . ADMINURL . "/cities/create");
                exit();
            }
        }

        require_once 'App/Views/admin-panel/cities-admins/create-city.php';
    }

    public function edit($id) {
        $city = $this->cityModel->getById($id);
        $countries = $this->countryModel->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'country_id' => $_POST['country_id'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'population' => $_POST['population'],
                'image' => $_FILES['image']['name'] ?: $city->image
            ];

            if ($this->cityModel->update($id, $data)) {
                if ($_FILES['image']['name']) {
                    $dir = "App/Views/admin-panel/cities-admins/images_cities/" . basename($_FILES['image']['name']);
                    move_uploaded_file($_FILES['image']['tmp_name'], $dir);
                }
                $_SESSION['success'] = "City updated successfully";
                header("Location: " . ADMINURL . "/cities");
                exit();
            } else {
                $_SESSION['error'] = "Error updating city";
            }
        }

        require_once 'App/Views/admin-panel/cities-admins/edit-city.php';
    }

    public function delete($id) {
        if ($this->cityModel->delete($id)) {
            $_SESSION['success'] = "City deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting city";
        }
        header("Location: " . ADMINURL . "/cities");
        exit();
    }
} 