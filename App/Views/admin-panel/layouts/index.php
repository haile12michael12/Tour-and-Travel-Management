<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Manage Layouts</h3>
            <a href="<?php echo ADMINURL; ?>/layouts/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Layout
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($layouts)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No layouts found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($layouts as $layout): ?>
                                <tr>
                                    <td><?php echo $layout->id; ?></td>
                                    <td><?php echo htmlspecialchars($layout->name); ?></td>
                                    <td><?php echo htmlspecialchars($layout->type); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $layout->status == 'active' ? 'success' : 'danger'; ?>">
                                            <?php echo ucfirst($layout->status); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('F j, Y g:i A', strtotime($layout->created_at)); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo ADMINURL; ?>/layouts/show/<?php echo $layout->id; ?>" 
                                               class="btn btn-info btn-sm" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo ADMINURL; ?>/layouts/edit/<?php echo $layout->id; ?>" 
                                               class="btn btn-primary btn-sm" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Delete"
                                                    onclick="confirmDelete(<?php echo $layout->id; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(layoutId) {
    if (confirm('Are you sure you want to delete this layout? This action cannot be undone.')) {
        window.location.href = `<?php echo ADMINURL; ?>/layouts/delete/${layoutId}`;
    }
}
</script>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 