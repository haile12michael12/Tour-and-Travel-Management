<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h1 class="card-title mb-4">Payment Successful!</h1>
                    
                    <div class="alert alert-success mb-4">
                        <p class="mb-0">Your payment has been processed successfully.</p>
                        <p class="mb-0">A confirmation email has been sent to your registered email address.</p>
                    </div>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Payment Details</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Transaction ID:</strong><br>
                                        <?= htmlspecialchars($payment->transaction_id) ?>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Amount Paid:</strong><br>
                                        $<?= number_format($payment->amount, 2) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Payment Method:</strong><br>
                                        <?= ucfirst($payment->payment_method) ?>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Date:</strong><br>
                                        <?= date('F d, Y H:i:s', strtotime($payment->created_at)) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="/bookings/<?= $payment->booking_id ?>" class="btn btn-primary">
                            <i class="fas fa-ticket-alt me-2"></i>View Booking Details
                        </a>
                        <a href="/bookings" class="btn btn-secondary">
                            <i class="fas fa-list me-2"></i>View All Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 