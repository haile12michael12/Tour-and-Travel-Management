<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Package Details</h3>
                    <div>
                        <a href="<?php echo ADMINURL; ?>/packages/edit/<?php echo $package->id; ?>" class="btn btn-primary">Edit Package</a>
                        <a href="<?php echo ADMINURL; ?>/packages" class="btn btn-secondary">Back to List</a>
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

                    <div class="row">
                        <?php if ($package->image): ?>
                            <div class="col-md-4 mb-4">
                                <img src="<?php echo BASEURL; ?>/public/uploads/packages/<?php echo $package->image; ?>" 
                                     alt="<?php echo htmlspecialchars($package->name); ?>" 
                                     class="img-fluid rounded">
                            </div>
                        <?php endif; ?>

                        <div class="col-md-<?php echo $package->image ? '8' : '12'; ?>">
                            <h4><?php echo htmlspecialchars($package->name); ?></h4>
                            <p class="text-muted">
                                <i class="fas fa-map-marker-alt"></i> 
                                <?php echo htmlspecialchars($package->city_name); ?>, <?php echo htmlspecialchars($package->country_name); ?>
                            </p>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Price</h5>
                                            <p class="card-text h4">$<?php echo number_format($package->price, 2); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Duration</h5>
                                            <p class="card-text h4"><?php echo $package->duration; ?> days</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Max People</h5>
                                            <p class="card-text h4"><?php echo $package->max_people; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5>Description</h5>
                                <p><?php echo nl2br(htmlspecialchars($package->description)); ?></p>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>What's Included</h5>
                                    <ul class="list-unstyled">
                                        <?php foreach (explode("\n", $package->includes) as $item): ?>
                                            <?php if (trim($item)): ?>
                                                <li><i class="fas fa-check text-success me-2"></i><?php echo htmlspecialchars(trim($item)); ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>What's Not Included</h5>
                                    <ul class="list-unstyled">
                                        <?php foreach (explode("\n", $package->excludes) as $item): ?>
                                            <?php if (trim($item)): ?>
                                                <li><i class="fas fa-times text-danger me-2"></i><?php echo htmlspecialchars(trim($item)); ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5>Status</h5>
                                <span class="badge bg-<?php echo $package->status == 'active' ? 'success' : 'danger'; ?>">
                                    <?php echo ucfirst($package->status); ?>
                                </span>
                            </div>

                            <div class="mb-4">
                                <h5>Created At</h5>
                                <p><?php echo date('F j, Y g:i A', strtotime($package->created_at)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 