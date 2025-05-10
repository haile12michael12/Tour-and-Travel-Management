<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Layout</h3>
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

                    <form action="<?php echo ADMINURL; ?>/layouts/edit/<?php echo $layout->id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Layout Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($layout->name); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Layout Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="header" <?php echo ($layout->type == 'header') ? 'selected' : ''; ?>>Header</option>
                                <option value="footer" <?php echo ($layout->type == 'footer') ? 'selected' : ''; ?>>Footer</option>
                                <option value="sidebar" <?php echo ($layout->type == 'sidebar') ? 'selected' : ''; ?>>Sidebar</option>
                                <option value="content" <?php echo ($layout->type == 'content') ? 'selected' : ''; ?>>Content</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Layout Content</label>
                            <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($layout->content); ?></textarea>
                            <small class="text-muted">You can use HTML and PHP code here</small>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?php echo ($layout->status == 'active') ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo ($layout->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Layout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 