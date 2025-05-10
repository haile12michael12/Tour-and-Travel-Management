<?php require_once 'App/Views/admin-panel/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Add New Package</h3>
                    <a href="<?php echo ADMINURL; ?>/packages" class="btn btn-secondary">Back to List</a>
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

                    <form action="<?php echo ADMINURL; ?>/packages/create" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Package Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">City</label>
                                <select class="form-select" id="city_id" name="city_id" required>
                                    <option value="">Select City</option>
                                    <?php foreach ($cities as $city): ?>
                                        <option value="<?php echo $city->id; ?>">
                                            <?php echo htmlspecialchars($city->name); ?> - <?php echo htmlspecialchars($city->country_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label">Duration (days)</label>
                                <input type="number" class="form-control" id="duration" name="duration" min="1" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="max_people" class="form-label">Maximum People</label>
                                <input type="number" class="form-control" id="max_people" name="max_people" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="includes" class="form-label">What's Included</label>
                            <textarea class="form-control" id="includes" name="includes" rows="3"></textarea>
                            <small class="text-muted">Enter each item on a new line</small>
                        </div>

                        <div class="mb-3">
                            <label for="excludes" class="form-label">What's Not Included</label>
                            <textarea class="form-control" id="excludes" name="excludes" rows="3"></textarea>
                            <small class="text-muted">Enter each item on a new line</small>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Package Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Package</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/admin-panel/layouts/footer.php'; ?> 