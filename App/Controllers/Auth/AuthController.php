<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $type = $_POST['type'] ?? 'user';

            if ($type === 'admin') {
                $user = Admin::findByEmail($email);
                if ($user && password_verify($password, $user['mypassword'])) {
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_name'] = $user['adminname'];
                    $this->redirect('/admin/dashboard');
                    return;
                }
            } else {
                $user = User::authenticate($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $this->redirect('/dashboard');
                    return;
                }
            }

            $this->view('auth/login', [
                'error' => 'Invalid email or password',
                'email' => $email
            ]);
            return;
        }

        $this->view('auth/login');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $errors = [];

            if (empty($email)) {
                $errors['email'] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format';
            } elseif (User::findByEmail($email)) {
                $errors['email'] = 'Email already exists';
            }

            if (empty($username)) {
                $errors['username'] = 'Username is required';
            } elseif (User::findByUsername($username)) {
                $errors['username'] = 'Username already exists';
            }

            if (empty($password)) {
                $errors['password'] = 'Password is required';
            } elseif (strlen($password) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            }

            if ($password !== $confirmPassword) {
                $errors['confirm_password'] = 'Passwords do not match';
            }

            if (empty($errors)) {
                $userData = [
                    'email' => $email,
                    'username' => $username,
                    'mypassword' => password_hash($password, PASSWORD_DEFAULT)
                ];

                if (User::create($userData)) {
                    $_SESSION['success'] = 'Registration successful! Please login.';
                    $this->redirect('/login');
                    return;
                }

                $errors['general'] = 'Registration failed. Please try again.';
            }

            $this->view('auth/register', [
                'errors' => $errors,
                'email' => $email,
                'username' => $username
            ]);
            return;
        }

        $this->view('auth/register');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
} 