<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>User Management</h1>
                <a href="/users/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New User
                </a>
            </div>

            <?php if (empty($users)): ?>
                <div class="alert alert-info">
                    No users found.
                </div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>#<?= $user->id ?></td>
                                            <td><?= htmlspecialchars($user->name) ?></td>
                                            <td><?= htmlspecialchars($user->email) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : 'info' ?>">
                                                    <?= ucfirst($user->role) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($user->created_at)) ?></td>
                                            <td>
                                                <a href="/users/<?= $user->id ?>/edit" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/users/<?= $user->id ?>/delete" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i === (int)$currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 