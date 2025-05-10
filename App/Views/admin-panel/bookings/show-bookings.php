<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Bookings</h2>
        <a href="<?php echo ADMINURL; ?>/bookings/create" class="btn btn-primary">Add New Booking</a>
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
                            <th>User</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Guests</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo $booking->id; ?></td>
                                <td><?php echo htmlspecialchars($booking->user_name); ?></td>
                                <td><?php echo htmlspecialchars($booking->city_name); ?></td>
                                <td><?php echo htmlspecialchars($booking->country_name); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($booking->check_in)); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($booking->check_out)); ?></td>
                                <td><?php echo $booking->guests; ?></td>
                                <td>$<?php echo number_format($booking->total_price, 2); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger'); ?>">
                                        <?php echo ucfirst($booking->status); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo ADMINURL; ?>/bookings/show/<?php echo $booking->id; ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="<?php echo ADMINURL; ?>/bookings/edit/<?php echo $booking->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?php echo ADMINURL; ?>/bookings/delete/<?php echo $booking->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
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