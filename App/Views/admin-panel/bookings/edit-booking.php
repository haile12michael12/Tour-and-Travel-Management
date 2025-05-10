<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Booking</h3>
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

                    <form action="<?php echo ADMINURL; ?>/bookings/edit/<?php echo $booking->id; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="check_in" class="form-label">Check In Date</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" 
                                       value="<?php echo date('Y-m-d', strtotime($booking->check_in)); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="check_out" class="form-label">Check Out Date</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" 
                                       value="<?php echo date('Y-m-d', strtotime($booking->check_out)); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="guests" class="form-label">Number of Guests</label>
                                <input type="number" class="form-control" id="guests" name="guests" 
                                       value="<?php echo $booking->guests; ?>" min="1" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="total_price" class="form-label">Total Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="total_price" name="total_price" 
                                           value="<?php echo $booking->total_price; ?>" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" <?php echo $booking->status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo $booking->status === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="cancelled" <?php echo $booking->status === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 