<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends Controller
{
    private $userModel;
    private $mailer;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->mailer = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer()
    {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = $_ENV['MAIL_HOST'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $_ENV['MAIL_USERNAME'];
            $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = $_ENV['MAIL_PORT'];
            $this->mailer->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        } catch (Exception $e) {
            error_log("Mailer setup error: " . $e->getMessage());
        }
    }

    public function index()
    {
        // Check if user is admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: /');
            exit;
        }

        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $users = $this->userModel->getAll($page, $limit);
        $totalUsers = $this->userModel->getTotalUsers();
        $totalPages = ceil($totalUsers / $limit);

        $this->view('users/index', [
            'title' => 'User Management',
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $_POST['role'] ?? 'user'
            ];

            if ($this->userModel->create($data)) {
                $_SESSION['success'] = 'User created successfully.';
                header('Location: /users');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to create user.';
            }
        }

        $this->view('users/create', [
            'title' => 'Create User'
        ]);
    }

    public function edit($id)
    {
        $user = $this->userModel->findById($id);

        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            header('Location: /users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            if ($this->userModel->update($id, $data)) {
                $_SESSION['success'] = 'User updated successfully.';
                header('Location: /users');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to update user.';
            }
        }

        $this->view('users/edit', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            $_SESSION['success'] = 'User deleted successfully.';
        } else {
            $_SESSION['error'] = 'Failed to delete user.';
        }

        header('Location: /users');
        exit;
    }

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            if ($this->userModel->update($_SESSION['user_id'], $data)) {
                $_SESSION['success'] = 'Profile updated successfully.';
                header('Location: /profile');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to update profile.';
            }
        }

        $this->view('users/profile', [
            'title' => 'My Profile',
            'user' => $user
        ]);
    }

    private function sendWelcomeEmail($user)
    {
        try {
            $this->mailer->addAddress($user->email, $user->name);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Welcome to Tour and Travel';
            $this->mailer->Body = $this->getWelcomeEmailTemplate($user);
            $this->mailer->send();
        } catch (Exception $e) {
            error_log("Welcome email error: " . $e->getMessage());
        }
    }

    private function getWelcomeEmailTemplate($user)
    {
        return "
            <h2>Welcome to Tour and Travel, {$user->name}!</h2>
            <p>Thank you for joining our platform. We're excited to help you plan your next adventure.</p>
            <p>You can now:</p>
            <ul>
                <li>Browse our destinations</li>
                <li>Make bookings</li>
                <li>View your booking history</li>
                <li>Update your profile</li>
            </ul>
            <p>If you have any questions, feel free to contact our support team.</p>
            <p>Best regards,<br>Tour and Travel Team</p>
        ";
    }
} 