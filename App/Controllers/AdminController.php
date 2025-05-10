<?php

class AdminController {
    private $adminModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->adminModel = new Admin($db);
    }

    public function index() {
        $admins = $this->adminModel->getAll();
        require_once 'App/Views/admin-panel/admins/show-admin.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['adminname']) || empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: " . ADMINURL . "/admins/create");
                exit();
            }

            if ($this->adminModel->emailExists($_POST['email'])) {
                $_SESSION['error'] = "Email already exists";
                header("Location: " . ADMINURL . "/admins/create");
                exit();
            }

            $data = [
                'adminname' => $_POST['adminname'],
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];

            if ($this->adminModel->create($data)) {
                $_SESSION['success'] = "Admin created successfully";
                header("Location: " . ADMINURL . "/admins");
                exit();
            } else {
                $_SESSION['error'] = "Error creating admin";
                header("Location: " . ADMINURL . "/admins/create");
                exit();
            }
        }

        require_once 'App/Views/admin-panel/admins/create-admin.php';
    }

    public function edit($id) {
        $admin = $this->adminModel->getById($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['adminname']) || empty($_POST['email'])) {
                $_SESSION['error'] = "Name and email are required";
                header("Location: " . ADMINURL . "/admins/edit/" . $id);
                exit();
            }

            $data = [
                'adminname' => $_POST['adminname'],
                'email' => $_POST['email']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            if ($this->adminModel->update($id, $data)) {
                $_SESSION['success'] = "Admin updated successfully";
                header("Location: " . ADMINURL . "/admins");
                exit();
            } else {
                $_SESSION['error'] = "Error updating admin";
            }
        }

        require_once 'App/Views/admin-panel/admins/edit-admin.php';
    }

    public function delete($id) {
        if ($this->adminModel->delete($id)) {
            $_SESSION['success'] = "Admin deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting admin";
        }
        header("Location: " . ADMINURL . "/admins");
        exit();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = "Email and password are required";
                header("Location: " . ADMINURL . "/login");
                exit();
            }

            $admin = $this->adminModel->login($_POST['email'], $_POST['password']);

            if ($admin) {
                $_SESSION['admin_id'] = $admin->id;
                $_SESSION['adminname'] = $admin->adminname;
                $_SESSION['email'] = $admin->email;
                header("Location: " . ADMINURL . "/dashboard");
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password";
                header("Location: " . ADMINURL . "/login");
                exit();
            }
        }

        require_once 'App/Views/admin-panel/admins/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: " . ADMINURL . "/login");
        exit();
    }
} 