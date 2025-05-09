<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', [
            'title' => 'Welcome to Tour and Travel Management',
            'description' => 'Your one-stop solution for all travel needs'
        ]);
    }

    public function about(): void
    {
        $this->view('home/about', [
            'title' => 'About Us',
            'description' => 'Learn more about our services'
        ]);
    }

    public function contact(): void
    {
        $this->view('home/contact', [
            'title' => 'Contact Us',
            'description' => 'Get in touch with us'
        ]);
    }
} 