<?php require_once 'App/Views/layouts/admin.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">Edit Country</h5>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= ADMINURL ?>/countries/edit/<?= $country['id'] ?>" enctype="multipart/form-data">
                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="name" id="name" class="form-control" 
                                   placeholder="Country Name" value="<?= htmlspecialchars($country['name']) ?>" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="continent" id="continent" class="form-control" 
                                   placeholder="Continent" value="<?= htmlspecialchars($country['continent']) ?>" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="population" id="population" class="form-control" 
                                   placeholder="Population" value="<?= htmlspecialchars($country['population']) ?>" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="territory" id="territory" class="form-control" 
                                   placeholder="Territory" value="<?= htmlspecialchars($country['territory']) ?>" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="file" name="image" id="image" class="form-control" />
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <img src="<?= ADMINURL ?>/countries-admins/images_countries/<?= $country['image'] ?>" 
                                 alt="Current Image" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>

                        <div class="form-floating mb-4">
                            <textarea name="description" class="form-control" placeholder="Description" 
                                      id="description" style="height: 100px" required><?= htmlspecialchars($country['description']) ?></textarea>
                            <label for="description">Description</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Update Country</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/layouts/footer.php'; ?> 