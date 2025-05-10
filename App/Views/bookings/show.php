<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="card-title mb-0">Booking Details</h1>
                        <span class="badge bg-<?= $this->getStatusBadgeClass($booking->status) ?> fs-6">
                            <?= ucfirst($booking->status) ?>
                        </span>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Booking Information</h5>
                            <p><strong>Booking ID:</strong> #<?= $booking->id ?></p>
                            <p><strong>Booking Date:</strong> <?= date('M d, Y', strtotime($booking->booking_date)) ?></p>
                            <p><strong>Travel Date:</strong> <?= date('M d, Y', strtotime($booking->travel_date)) ?></p>
                            <p><strong>Number of People:</strong> <?= $booking->number_of_people ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Destination Details</h5>
                            <p><strong>City:</strong> <?= $booking->city_name ?></p>
                            <p><strong>Country:</strong> <?= $booking->country_name ?></p>
                            <?php if ($booking->deal_title): ?>
                                <p>
                                    <strong>Special Deal:</strong> 
                                    <span class="badge bg-success"><?= $booking->deal_title ?></span>
                                </p>
                                <p><strong>Discount:</strong> <?= $booking->discount_percentage ?>%</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Price Details</h5>
                            <div class="row">
                                <div class="col-6">Base Price:</div>
                                <div class="col-6 text-end">
                                    $<?= number_format($booking->total_price / (1 - ($booking->discount_percentage ?? 0) / 100), 2) ?>
                                </div>
                            </div>
                            <?php if ($booking->discount_percentage): ?>
                                <div class="row">
                                    <div class="col-6">Discount (<?= $booking->discount_percentage ?>%):</div>
                                    <div class="col-6 text-end">
                                        -$<?= number_format($booking->total_price / (1 - $booking->discount_percentage / 100) - $booking->total_price, 2) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="row fw-bold">
                                <div class="col-6">Total Price:</div>
                                <div class="col-6 text-end">$<?= number_format($booking->total_price, 2) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Payment Information</h5>
                            <p>
                                <strong>Payment Status:</strong>
                                <span class="badge bg-<?= $this->getPaymentStatusBadgeClass($booking->payment_status) ?>">
                                    <?= ucfirst($booking->payment_status) ?>
                                </span>
                            </p>
                            <?php if ($booking->payment_status === 'pending'): ?>
                                <a href="/bookings/<?= $booking->id ?>/payment" class="btn btn-success">
                                    <i class="fas fa-credit-card me-2"></i>Make Payment
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Contact Information</h5>
                            <p><strong>Name:</strong> <?= $booking->user_name ?></p>
                            <p><strong>Email:</strong> <?= $booking->user_email ?></p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/bookings" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
                        </a>
                        <?php if ($booking->status === 'pending'): ?>
                            <a href="/bookings/<?= $booking->id ?>/cancel" 
                               class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to cancel this booking?')">
                                <i class="fas fa-times me-2"></i>Cancel Booking
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Helper functions for badge classes
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'pending':
            return 'warning';
        case 'confirmed':
            return 'success';
        case 'cancelled':
            return 'danger';
        case 'completed':
            return 'info';
        default:
            return 'secondary';
    }
}

function getPaymentStatusBadgeClass($status) {
    switch ($status) {
        case 'pending':
            return 'warning';
        case 'paid':
            return 'success';
        case 'failed':
            return 'danger';
        case 'refunded':
            return 'info';
        default:
            return 'secondary';
    }
}
?> 