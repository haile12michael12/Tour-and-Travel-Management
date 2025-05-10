<!-- Header -->
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/assets/images/logo.png" alt="Logo" height="40">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'destinations' ? 'active' : '' ?>" href="/destinations">Destinations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'deals' ? 'active' : '' ?>" href="/deals">Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'about' ? 'active' : '' ?>" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>" href="/contact">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <img src="/assets/images/users/<?= $_SESSION['user_avatar'] ?? 'default.jpg' ?>" 
                                     alt="User" 
                                     class="rounded-circle" 
                                     width="32">
                                <span class="ms-2"><?= $_SESSION['user_name'] ?></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="/profile">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                                <a class="dropdown-item" href="/bookings">
                                    <i class="fas fa-calendar-check"></i> My Bookings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-primary me-2">Login</a>
                        <a href="/register" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header> 