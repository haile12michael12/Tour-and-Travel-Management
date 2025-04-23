<?php
class AdminController {
    public function dashboard() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: login');
            exit;
        }
        
        // You can fetch admin-specific data here if needed
        $adminData = [
            'adminname' => $_SESSION['adminname'],
            'id' => $_SESSION['admin_id']
        ];
        
        require_once '../app/views/admin/dashboard.php';
    }
}