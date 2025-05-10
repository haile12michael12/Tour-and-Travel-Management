<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - Tour and Travel Management</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
                <button type="button" id="sidebarCollapse" class="btn btn-link">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="list-unstyled components">
                <li class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                    <a href="/admin/dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="<?= $currentPage === 'bookings' ? 'active' : '' ?>">
                    <a href="/admin/bookings">
                        <i class="fas fa-calendar-check"></i>
                        Bookings
                    </a>
                </li>
                <li class="<?= $currentPage === 'users' ? 'active' : '' ?>">
                    <a href="/admin/users">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li class="<?= $currentPage === 'destinations' ? 'active' : '' ?>">
                    <a href="/admin/destinations">
                        <i class="fas fa-map-marker-alt"></i>
                        Destinations
                    </a>
                </li>
                <li class="<?= $currentPage === 'deals' ? 'active' : '' ?>">
                    <a href="/admin/deals">
                        <i class="fas fa-tags"></i>
                        Deals
                    </a>
                </li>
                <li class="<?= $currentPage === 'settings' ? 'active' : '' ?>">
                    <a href="/admin/settings">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="notificationsDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <span class="badge bg-danger">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Notifications</h6>
                                <a class="dropdown-item" href="#">New booking received</a>
                                <a class="dropdown-item" href="#">New user registered</a>
                                <a class="dropdown-item" href="#">Deal expiring soon</a>
                            </div>
                        </div>

                        <div class="dropdown ms-3">
                            <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <img src="/assets/images/admin/avatar.jpg" alt="Admin" class="rounded-circle" width="32">
                                <span class="ms-2"><?= $_SESSION['user_name'] ?? 'Admin' ?></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="/admin/profile">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                                <a class="dropdown-item" href="/admin/settings">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/admin/logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="container-fluid py-4">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?= $content ?>
            </main>

            <!-- Footer -->
            <footer class="footer mt-auto py-3 bg-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="text-muted">&copy; <?= date('Y') ?> Tour and Travel Management. All rights reserved.</span>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="text-muted">Version 1.0.0</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/admin.js"></script>
</body>
</html> 