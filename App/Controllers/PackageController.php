<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Package;
use App\Models\City;

class PackageController extends Controller
{
    private $packageModel;
    private $cityModel;
    private $db;

    public function __construct($db)
    {
        parent::__construct();
        $this->db = $db;
        $this->packageModel = new Package($db);
        $this->cityModel = new City($db);
    }

    public function index()
    {
        $packages = $this->packageModel->getAll();
        require_once 'App/Views/admin-panel/packages/show-packages.php';
    }

    public function show($id)
    {
        $package = $this->packageModel->getById($id);
        if (!$package) {
            $_SESSION['error'] = "Package not found";
            header("Location: " . ADMINURL . "/packages");
            exit();
        }
        require_once 'App/Views/admin-panel/packages/show-package.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['city_id']) || 
                empty($_POST['price']) || empty($_POST['duration']) || empty($_POST['max_people'])) {
                $_SESSION['error'] = "All required fields must be filled";
                header("Location: " . ADMINURL . "/packages/create");
                exit();
            }

            // Handle image upload
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/uploads/packages/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = $uploadFile;
                }
            }

            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'city_id' => $_POST['city_id'],
                'price' => $_POST['price'],
                'duration' => $_POST['duration'],
                'max_people' => $_POST['max_people'],
                'includes' => $_POST['includes'] ?? '',
                'excludes' => $_POST['excludes'] ?? '',
                'image' => $image,
                'status' => $_POST['status'] ?? 'active'
            ];

            if ($this->packageModel->create($data)) {
                $_SESSION['success'] = "Package created successfully";
                header("Location: " . ADMINURL . "/packages");
                exit();
            } else {
                $_SESSION['error'] = "Error creating package";
                header("Location: " . ADMINURL . "/packages/create");
                exit();
            }
        }

        $cities = $this->cityModel->getAll();
        require_once 'App/Views/admin-panel/packages/create-package.php';
    }

    public function edit($id)
    {
        $package = $this->packageModel->getById($id);
        if (!$package) {
            $_SESSION['error'] = "Package not found";
            header("Location: " . ADMINURL . "/packages");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['city_id']) || 
                empty($_POST['price']) || empty($_POST['duration']) || empty($_POST['max_people'])) {
                $_SESSION['error'] = "All required fields must be filled";
                header("Location: " . ADMINURL . "/packages/edit/" . $id);
                exit();
            }

            // Handle image upload
            $image = $package->image;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/uploads/packages/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Delete old image if exists
                    if ($package->image && file_exists($package->image)) {
                        unlink($package->image);
                    }
                    $image = $uploadFile;
                }
            }

            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'city_id' => $_POST['city_id'],
                'price' => $_POST['price'],
                'duration' => $_POST['duration'],
                'max_people' => $_POST['max_people'],
                'includes' => $_POST['includes'] ?? '',
                'excludes' => $_POST['excludes'] ?? '',
                'image' => $image,
                'status' => $_POST['status']
            ];

            if ($this->packageModel->update($id, $data)) {
                $_SESSION['success'] = "Package updated successfully";
                header("Location: " . ADMINURL . "/packages");
                exit();
            } else {
                $_SESSION['error'] = "Error updating package";
            }
        }

        $cities = $this->cityModel->getAll();
        require_once 'App/Views/admin-panel/packages/edit-package.php';
    }

    public function delete($id)
    {
        $package = $this->packageModel->getById($id);
        if ($package && $package->image && file_exists($package->image)) {
            unlink($package->image);
        }

        if ($this->packageModel->delete($id)) {
            $_SESSION['success'] = "Package deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting package";
        }
        header("Location: " . ADMINURL . "/packages");
        exit();
    }

    public function view($id)
    {
        $package = $this->packageModel->getById($id);
        if (!$package) {
            $_SESSION['error'] = "Package not found";
            header("Location: /packages");
            exit();
        }
        require_once 'App/Views/packages/view-package.php';
    }

    public function list()
    {
        $packages = $this->packageModel->getAll();
        require_once 'App/Views/packages/list-packages.php';
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $packages = $this->packageModel->searchPackages($query);
        require_once 'App/Views/packages/search-results.php';
    }
}