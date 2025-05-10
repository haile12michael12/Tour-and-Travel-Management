<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">My Bookings</h1>
            
            <?php if (empty($bookings)): ?>
                <div class="alert alert-info">
                    You haven't made any bookings yet. 
                    <a href="/destinations" class="alert-link">Explore our destinations</a> to start your journey!
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Destination</th>
                                <th>Travel Date</th>
                                <th>People</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td>#<?= $booking->id ?></td>
                                    <td>
                                        <?= $booking->city_name ?>, <?= $booking->country_name ?>
                                        <?php if ($booking->deal_title): ?>
                                            <span class="badge bg-success">Deal: <?= $booking->deal_title ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($booking->travel_date)) ?></td>
                                    <td><?= $booking->number_of_people ?></td>
                                    <td>$<?= number_format($booking->total_price, 2) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $this->getStatusBadgeClass($booking->status) ?>">
                                            <?= ucfirst($booking->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $this->getPaymentStatusBadgeClass($booking->payment_status) ?>">
                                            <?= ucfirst($booking->payment_status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/bookings/<?= $booking->id ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <?php if ($booking->status === 'pending'): ?>
                                            <a href="/bookings/<?= $booking->id ?>/cancel" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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