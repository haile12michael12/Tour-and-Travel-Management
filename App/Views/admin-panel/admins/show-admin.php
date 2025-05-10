<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Admins</h2>
        <a href="<?php echo ADMINURL; ?>/admins/create" class="btn btn-primary">Add New Admin</a>
    </div>

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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?php echo $admin->id; ?></td>
                                <td><?php echo htmlspecialchars($admin->adminname); ?></td>
                                <td><?php echo htmlspecialchars($admin->email); ?></td>
                                <td>
                                    <a href="<?php echo ADMINURL; ?>/admins/edit/<?php echo $admin->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?php echo ADMINURL; ?>/admins/delete/<?php echo $admin->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 