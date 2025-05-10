<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Add New Layout</h3>
                    <a href="<?php echo ADMINURL; ?>/layouts" class="btn btn-secondary">Back to List</a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo ADMINURL; ?>/layouts/create" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Layout Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Layout Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="header">Header</option>
                                <option value="footer">Footer</option>
                                <option value="sidebar">Sidebar</option>
                                <option value="content">Content</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Layout Content</label>
                            <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                            <small class="text-muted">You can use HTML and PHP code here</small>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Layout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 