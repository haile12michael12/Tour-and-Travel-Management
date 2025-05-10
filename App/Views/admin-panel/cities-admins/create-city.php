<?php require_once 'App/Views/layouts/admin.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">Create City</h5>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= ADMINURL ?>/cities/create" enctype="multipart/form-data">
                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="name" id="name" class="form-control" placeholder="City Name" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <select name="country_id" id="country_id" class="form-control" required>
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?= $country->id ?>"><?= htmlspecialchars($country->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="number" name="price" id="price" class="form-control" placeholder="Price" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="number" name="population" id="population" class="form-control" placeholder="Population" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="file" name="image" id="image" class="form-control" required />
                        </div>

                        <div class="form-floating mb-4">
                            <textarea name="description" class="form-control" placeholder="Description" id="description" style="height: 100px" required></textarea>
                            <label for="description">Description</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create City</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/layouts/footer.php'; ?> 