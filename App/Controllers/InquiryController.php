<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Inquiry;
use App\Models\City;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class InquiryController extends Controller
{
    private $inquiryModel;
    private $cityModel;
    private $db;
    private $mailer;

    public function __construct($db)
    {
        parent::__construct();
        $this->db = $db;
        $this->inquiryModel = new Inquiry($db);
        $this->cityModel = new City($db);
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
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: /');
            exit;
        }

        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $inquiries = $this->inquiryModel->getAll($page, $limit);
        $totalInquiries = $this->inquiryModel->getTotal();
        $totalPages = ceil($totalInquiries / $limit);

        $this->view('inquiries/index', [
            'title' => 'Manage Inquiries',
            'inquiries' => $inquiries,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function show($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: /');
            exit;
        }

        $inquiry = $this->inquiryModel->getById($id);

        if (!$inquiry) {
            $_SESSION['error'] = 'Inquiry not found.';
            header('Location: /inquiries');
            exit;
        }

        $this->view('inquiries/show', [
            'title' => 'View Inquiry',
            'inquiry' => $inquiry,
            'statusOptions' => $this->inquiryModel->getStatusOptions()
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || 
                empty($_POST['city_id']) || empty($_POST['check_in']) || empty($_POST['check_out']) || 
                empty($_POST['guests'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: " . ADMINURL . "/inquiries/create");
                exit();
            }

            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'city_id' => $_POST['city_id'],
                'check_in' => $_POST['check_in'],
                'check_out' => $_POST['check_out'],
                'guests' => $_POST['guests'],
                'message' => $_POST['message'] ?? '',
                'status' => $_POST['status'] ?? 'pending'
            ];

            if ($this->inquiryModel->create($data)) {
                $_SESSION['success'] = "Inquiry created successfully";
                header("Location: " . ADMINURL . "/inquiries");
                exit();
            } else {
                $_SESSION['error'] = "Error creating inquiry";
                header("Location: " . ADMINURL . "/inquiries/create");
                exit();
            }
        }

        $cities = $this->cityModel->getAll();
        $this->view('inquiries/create', [
            'title' => 'Create Inquiry',
            'cities' => $cities
        ]);
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: /');
            exit;
        }

        $inquiry = $this->inquiryModel->getById($id);
        if (!$inquiry) {
            $_SESSION['error'] = "Inquiry not found";
            header("Location: " . ADMINURL . "/inquiries");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || 
                empty($_POST['city_id']) || empty($_POST['check_in']) || empty($_POST['check_out']) || 
                empty($_POST['guests'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: " . ADMINURL . "/inquiries/edit/" . $id);
                exit();
            }

            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'city_id' => $_POST['city_id'],
                'check_in' => $_POST['check_in'],
                'check_out' => $_POST['check_out'],
                'guests' => $_POST['guests'],
                'message' => $_POST['message'] ?? '',
                'status' => $_POST['status']
            ];

            if ($this->inquiryModel->update($id, $data)) {
                $_SESSION['success'] = "Inquiry updated successfully";
                header("Location: " . ADMINURL . "/inquiries");
                exit();
            } else {
                $_SESSION['error'] = "Error updating inquiry";
            }
        }

        $cities = $this->cityModel->getAll();
        $this->view('inquiries/edit', [
            'title' => 'Edit Inquiry',
            'inquiry' => $inquiry,
            'cities' => $cities
        ]);
    }

    public function delete($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: /');
            exit;
        }

        if ($this->inquiryModel->delete($id)) {
            $_SESSION['success'] = "Inquiry deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting inquiry";
        }
        header("Location: " . ADMINURL . "/inquiries");
        exit();
    }

    public function updateStatus($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
            if ($this->inquiryModel->updateStatus($id, $_POST['status'])) {
                $_SESSION['success'] = "Inquiry status updated successfully";
            } else {
                $_SESSION['error'] = "Error updating inquiry status";
            }
        }
        header("Location: " . ADMINURL . "/inquiries");
        exit();
    }

    public function reservation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || 
                empty($_POST['city_id']) || empty($_POST['check_in']) || empty($_POST['check_out']) || 
                empty($_POST['guests'])) {
                $_SESSION['error'] = "All fields are required";
                header("Location: /reservation");
                exit();
            }

            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'city_id' => $_POST['city_id'],
                'check_in' => $_POST['check_in'],
                'check_out' => $_POST['check_out'],
                'guests' => $_POST['guests'],
                'message' => $_POST['message'] ?? '',
                'status' => 'pending'
            ];

            if ($this->inquiryModel->create($data)) {
                $_SESSION['success'] = "Your reservation request has been submitted successfully. We will contact you soon.";
                header("Location: /reservation");
                exit();
            } else {
                $_SESSION['error'] = "Error submitting reservation request. Please try again.";
                header("Location: /reservation");
                exit();
            }
        }

        $cities = $this->cityModel->getAll();
        $this->view('inquiries/reservation', [
            'title' => 'Reservation',
            'cities' => $cities
        ]);
    }

    private function sendInquiryConfirmationEmail($data)
    {
        try {
            $this->mailer->addAddress($data['email'], $data['name']);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Inquiry Received - Tour and Travel';
            $this->mailer->Body = $this->getInquiryConfirmationTemplate($data);
            $this->mailer->send();
        } catch (Exception $e) {
            error_log("Inquiry confirmation email error: " . $e->getMessage());
        }
    }

    private function getInquiryConfirmationTemplate($data)
    {
        return "
            <h2>Thank You for Your Inquiry</h2>
            <p>Dear {$data['name']},</p>
            <p>Thank you for contacting us. We have received your inquiry and will get back to you as soon as possible.</p>
            
            <h3>Your Inquiry Details:</h3>
            <ul>
                <li><strong>Subject:</strong> {$data['subject']}</li>
                <li><strong>Message:</strong> {$data['message']}</li>
                <li><strong>Date:</strong> " . date('F d, Y H:i:s') . "</li>
            </ul>

            <p>We will review your inquiry and respond within 24-48 business hours.</p>
            
            <p>If you have any additional questions, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>Tour and Travel Team</p>
        ";
    }
} 