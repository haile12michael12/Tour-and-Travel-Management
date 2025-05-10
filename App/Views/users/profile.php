<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title text-center mb-4">My Profile</h1>

                    <form action="/profile" method="POST" class="needs-validation" novalidate>
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= htmlspecialchars($user->name) ?>" required>
                            <div class="invalid-feedback">
                                Please enter your full name.
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($user->email) ?>" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" 
                                   name="current_password" required>
                            <div class="invalid-feedback">
                                Please enter your current password.
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   minlength="8">
                            <div class="invalid-feedback">
                                If changing password, it must be at least 8 characters long.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>

                    <!-- Account Information -->
                    <div class="mt-5">
                        <h5 class="text-muted mb-3">Account Information</h5>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="mb-2">
                                    <strong>Member Since:</strong> 
                                    <?= date('F d, Y', strtotime($user->created_at)) ?>
                                </p>
                                <p class="mb-2">
                                    <strong>Account Type:</strong>
                                    <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : 'info' ?>">
                                        <?= ucfirst($user->role) ?>
                                    </span>
                                </p>
                                <p class="mb-0">
                                    <strong>Last Updated:</strong>
                                    <?= date('F d, Y', strtotime($user->updated_at)) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script> 