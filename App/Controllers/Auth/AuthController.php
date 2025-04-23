<?php
class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = new Admin();
            $adminname = $_POST['adminname'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $admin = $adminModel->authenticate($adminname, $password);
            
            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['adminname'] = $admin['adminname'];
                header('Location: dashboard');
                exit;
            } else {
                $error = 'Invalid credentials';
            }
        }
        
        require_once '../app/views/auth/login.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: login');
        exit;
    }
}