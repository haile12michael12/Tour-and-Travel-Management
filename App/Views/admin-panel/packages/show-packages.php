<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Manage Packages</h3>
            <a href="<?php echo ADMINURL; ?>/packages/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Package
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
                            <th>Image</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($packages)): ?>
                            <tr>
                                <td colspan="9" class="text-center">No packages found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($packages as $package): ?>
                                <tr>
                                    <td><?php echo $package->id; ?></td>
                                    <td>
                                        <?php if ($package->image): ?>
                                            <img src="<?php echo BASEURL; ?>/public/uploads/packages/<?php echo $package->image; ?>" 
                                                 alt="<?php echo htmlspecialchars($package->name); ?>" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 100px;">
                                        <?php else: ?>
                                            <span class="text-muted">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($package->name); ?></td>
                                    <td><?php echo htmlspecialchars($package->city_name); ?></td>
                                    <td><?php echo htmlspecialchars($package->country_name); ?></td>
                                    <td>$<?php echo number_format($package->price, 2); ?></td>
                                    <td><?php echo $package->duration; ?> days</td>
                                    <td>
                                        <span class="badge bg-<?php echo $package->status == 'active' ? 'success' : 'danger'; ?>">
                                            <?php echo ucfirst($package->status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo ADMINURL; ?>/packages/show/<?php echo $package->id; ?>" 
                                               class="btn btn-info btn-sm" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo ADMINURL; ?>/packages/edit/<?php echo $package->id; ?>" 
                                               class="btn btn-primary btn-sm" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Delete"
                                                    onclick="confirmDelete(<?php echo $package->id; ?>)">
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
function confirmDelete(packageId) {
    if (confirm('Are you sure you want to delete this package? This action cannot be undone.')) {
        window.location.href = `<?php echo ADMINURL; ?>/packages/delete/${packageId}`;
    }
}
</script>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 