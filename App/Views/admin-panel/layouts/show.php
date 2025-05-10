<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Layout Details</h3>
                    <div>
                        <a href="<?php echo ADMINURL; ?>/layouts/edit/<?php echo $layout->id; ?>" class="btn btn-primary">Edit Layout</a>
                        <a href="<?php echo ADMINURL; ?>/layouts" class="btn btn-secondary">Back to List</a>
                    </div>
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

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td><?php echo htmlspecialchars($layout->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Type:</th>
                                    <td><?php echo htmlspecialchars($layout->type); ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-<?php echo $layout->status == 'active' ? 'success' : 'danger'; ?>">
                                            <?php echo ucfirst($layout->status); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td><?php echo date('F j, Y g:i A', strtotime($layout->created_at)); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Layout Content</h5>
                        <div class="card">
                            <div class="card-body">
                                <pre class="mb-0"><code><?php echo htmlspecialchars($layout->content); ?></code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Preview</h5>
                        <div class="card">
                            <div class="card-body">
                                <?php echo $layout->content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 