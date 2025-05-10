<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="card-title mb-0">View Inquiry</h1>
                        <a href="/inquiries" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Inquiries
                        </a>
                    </div>

                    <!-- Inquiry Details -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Name:</strong><br>
                                        <?= htmlspecialchars($inquiry->name) ?>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Email:</strong><br>
                                        <a href="mailto:<?= htmlspecialchars($inquiry->email) ?>">
                                            <?= htmlspecialchars($inquiry->email) ?>
                                        </a>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Phone:</strong><br>
                                        <a href="tel:<?= htmlspecialchars($inquiry->phone) ?>">
                                            <?= htmlspecialchars($inquiry->phone) ?>
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Date Submitted:</strong><br>
                                        <?= date('F d, Y H:i:s', strtotime($inquiry->created_at)) ?>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Status:</strong><br>
                                        <span class="badge bg-<?= $this->getStatusBadgeClass($inquiry->status) ?>">
                                            <?= ucfirst(str_replace('_', ' ', $inquiry->status)) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-2">
                                <strong>Subject:</strong><br>
                                <?= htmlspecialchars($inquiry->subject) ?>
                            </div>

                            <div class="mb-0">
                                <strong>Message:</strong><br>
                                <div class="mt-2 p-3 bg-white rounded">
                                    <?= nl2br(htmlspecialchars($inquiry->message)) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Update Status</h5>
                            <form action="/inquiries/<?= $inquiry->id ?>/status" method="POST">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <select name="status" class="form-select" required>
                                            <?php foreach ($statusOptions as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= $inquiry->status === $value ? 'selected' : '' ?>>
                                                    <?= $label ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Status
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="d-flex gap-2">
                        <a href="mailto:<?= htmlspecialchars($inquiry->email) ?>" class="btn btn-outline-primary">
                            <i class="fas fa-reply me-2"></i>Reply via Email
                        </a>
                        <button type="button" 
                                class="btn btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete Inquiry
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
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