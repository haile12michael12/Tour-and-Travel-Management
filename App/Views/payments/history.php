<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="card-title mb-0">Payment History</h1>
                        <a href="/bookings" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
                        </a>
                    </div>

                    <?php if (empty($payments)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>No payment history found.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Transaction ID</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Destination</th>
                                        <th>Travel Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($payments as $payment): ?>
                                        <tr>
                                            <td><?= date('M d, Y', strtotime($payment->created_at)) ?></td>
                                            <td>
                                                <span class="text-muted"><?= substr($payment->transaction_id, 0, 8) ?>...</span>
                                            </td>
                                            <td>$<?= number_format($payment->amount, 2) ?></td>
                                            <td><?= ucfirst($payment->payment_method) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $this->getStatusBadgeClass($payment->status) ?>">
                                                    <?= ucfirst($payment->status) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($payment->city_name) ?></td>
                                            <td><?= date('M d, Y', strtotime($payment->travel_date)) ?></td>
                                            <td>
                                                <a href="/bookings/<?= $payment->booking_id ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Payment history pagination" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 