<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Booking Details</h3>
                    <a href="<?php echo ADMINURL; ?>/bookings" class="btn btn-secondary">Back to List</a>
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>User Information</h5>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($booking->user_name); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Booking Status</h5>
                            <p>
                                <span class="badge bg-<?php echo $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger'); ?>">
                                    <?php echo ucfirst($booking->status); ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Destination</h5>
                            <p><strong>City:</strong> <?php echo htmlspecialchars($booking->city_name); ?></p>
                            <p><strong>Country:</strong> <?php echo htmlspecialchars($booking->country_name); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Booking Details</h5>
                            <p><strong>Check In:</strong> <?php echo date('Y-m-d', strtotime($booking->check_in)); ?></p>
                            <p><strong>Check Out:</strong> <?php echo date('Y-m-d', strtotime($booking->check_out)); ?></p>
                            <p><strong>Number of Guests:</strong> <?php echo $booking->guests; ?></p>
                            <p><strong>Total Price:</strong> $<?php echo number_format($booking->total_price, 2); ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5>Actions</h5>
                            <div class="btn-group">
                                <a href="<?php echo ADMINURL; ?>/bookings/edit/<?php echo $booking->id; ?>" class="btn btn-warning">Edit Booking</a>
                                <a href="<?php echo ADMINURL; ?>/bookings/delete/<?php echo $booking->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete Booking</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 