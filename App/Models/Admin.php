<?php
class Admin {
    private $db;

    public function __construct() {
        $this->db = new PDO(
            'mysql:host=localhost;dbname=your_db_name;charset=utf8mb4',
            'your_db_user',
            'your_db_password'
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function authenticate($adminname, $password) {
        $stmt = $this->db->prepare("
            SELECT id, adminname, mypassword 
            FROM admins 
            WHERE adminname = :adminname
        ");
        $stmt->execute([':adminname' => $adminname]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['mypassword'])) {
            return $admin;
        }
        return false;
    }

    // Add other admin-related methods (create, update, delete) as needed
}