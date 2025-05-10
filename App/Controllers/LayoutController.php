<?php

namespace App\Controllers;

use App\Models\Layout;

class LayoutController
{
    private $layoutModel;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->layoutModel = new Layout($db);
    }

    public function index()
    {
        $layouts = $this->layoutModel->getAllLayouts();
        require_once 'App/Views/admin-panel/layouts/index.php';
    }

    public function show($id)
    {
        $layout = $this->layoutModel->getLayoutById($id);
        if (!$layout) {
            $_SESSION['error'] = "Layout not found.";
            header("Location: " . ADMINURL . "/layouts");
            exit;
        }
        require_once 'App/Views/admin-panel/layouts/show.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'type' => $_POST['type'] ?? '',
                'content' => $_POST['content'] ?? '',
                'status' => $_POST['status'] ?? 'active'
            ];

            if (empty($data['name']) || empty($data['type']) || empty($data['content'])) {
                $_SESSION['error'] = "All fields are required.";
                header("Location: " . ADMINURL . "/layouts/create");
                exit;
            }

            if ($this->layoutModel->create($data)) {
                $_SESSION['success'] = "Layout created successfully.";
                header("Location: " . ADMINURL . "/layouts");
                exit;
            } else {
                $_SESSION['error'] = "Failed to create layout.";
                header("Location: " . ADMINURL . "/layouts/create");
                exit;
            }
        }

        require_once 'App/Views/admin-panel/layouts/create.php';
    }

    public function edit($id)
    {
        $layout = $this->layoutModel->getLayoutById($id);
        if (!$layout) {
            $_SESSION['error'] = "Layout not found.";
            header("Location: " . ADMINURL . "/layouts");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'type' => $_POST['type'] ?? '',
                'content' => $_POST['content'] ?? '',
                'status' => $_POST['status'] ?? 'active'
            ];

            if (empty($data['name']) || empty($data['type']) || empty($data['content'])) {
                $_SESSION['error'] = "All fields are required.";
                header("Location: " . ADMINURL . "/layouts/edit/" . $id);
                exit;
            }

            if ($this->layoutModel->update($id, $data)) {
                $_SESSION['success'] = "Layout updated successfully.";
                header("Location: " . ADMINURL . "/layouts");
                exit;
            } else {
                $_SESSION['error'] = "Failed to update layout.";
                header("Location: " . ADMINURL . "/layouts/edit/" . $id);
                exit;
            }
        }

        require_once 'App/Views/admin-panel/layouts/edit.php';
    }

    public function delete($id)
    {
        if ($this->layoutModel->delete($id)) {
            $_SESSION['success'] = "Layout deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete layout.";
        }
        header("Location: " . ADMINURL . "/layouts");
        exit;
    }

    public function updateStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            if (!in_array($status, ['active', 'inactive'])) {
                $_SESSION['error'] = "Invalid status.";
                header("Location: " . ADMINURL . "/layouts");
                exit;
            }

            if ($this->layoutModel->updateStatus($id, $status)) {
                $_SESSION['success'] = "Layout status updated successfully.";
            } else {
                $_SESSION['error'] = "Failed to update layout status.";
            }
        }
        header("Location: " . ADMINURL . "/layouts");
        exit;
    }
} 