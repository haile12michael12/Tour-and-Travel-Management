<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title text-center mb-4">Edit User</h1>

                    <form action="/users/<?= $user->id ?>/edit" method="POST" class="needs-validation" novalidate>
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= htmlspecialchars($user->name) ?>" required>
                            <div class="invalid-feedback">
                                Please enter the user's full name.
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

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   minlength="8">
                            <div class="invalid-feedback">
                                If changing password, it must be at least 8 characters long.
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a role.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <a href="/users" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Users
                            </a>
                        </div>
                    </form>
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