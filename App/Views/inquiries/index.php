<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="card-title mb-0">Manage Inquiries</h1>
                        <a href="/dashboard" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>

                    <?php if (empty($inquiries)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>No inquiries found.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($inquiries as $inquiry): ?>
                                        <tr>
                                            <td><?= date('M d, Y', strtotime($inquiry->created_at)) ?></td>
                                            <td><?= htmlspecialchars($inquiry->name) ?></td>
                                            <td><?= htmlspecialchars($inquiry->email) ?></td>
                                            <td><?= htmlspecialchars($inquiry->subject) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $this->getStatusBadgeClass($inquiry->status) ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $inquiry->status)) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/inquiries/<?= $inquiry->id ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal<?= $inquiry->id ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal<?= $inquiry->id ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this inquiry?</p>
                                                                <p class="mb-0"><strong>Subject:</strong> <?= htmlspecialchars($inquiry->subject) ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <form action="/inquiries/<?= $inquiry->id ?>/delete" method="POST" class="d-inline">
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Inquiry pagination" class="mt-4">
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