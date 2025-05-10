<?php

namespace App\Controllers;

class PagesController extends Controller
{
    public function home()
    {
        $this->view('pages/home');
    }

    public function about()
    {
        $this->view('pages/about');
    }

    public function contact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle contact form submission
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';

            // TODO: Add validation and email sending logic
            $_SESSION['success'] = 'Your message has been sent successfully!';
            header('Location: /contact');
            exit;
        }

        $this->view('pages/contact');
    }

    public function deals()
    {
        // TODO: Add deals data from model
        $this->view('pages/deals');
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $destination = $_GET['destination'] ?? '';
        $date = $_GET['date'] ?? '';

        // TODO: Add search logic using models
        $this->view('pages/search', [
            'query' => $query,
            'destination' => $destination,
            'date' => $date
        ]);
    }
} 