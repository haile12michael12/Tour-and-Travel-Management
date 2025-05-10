<?php require_once 'App/Views/layouts/admin.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">Cities</h5>
                    <a href="<?= ADMINURL ?>/cities/create" class="btn btn-primary float-end">Create City</a>

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

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Price</th>
                                <th scope="col">Population</th>
                                <th scope="col">Image</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cities as $city): ?>
                                <tr>
                                    <th scope="row"><?= $city->id ?></th>
                                    <td><?= htmlspecialchars($city->name) ?></td>
                                    <td><?= htmlspecialchars($city->country_name) ?></td>
                                    <td>$<?= number_format($city->price, 2) ?></td>
                                    <td><?= number_format($city->population) ?></td>
                                    <td>
                                        <img src="<?= ADMINURL ?>/cities-admins/images_cities/<?= $city->image ?>" 
                                             alt="<?= htmlspecialchars($city->name) ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <a href="<?= ADMINURL ?>/cities/edit/<?= $city->id ?>" 
                                           class="btn btn-warning">Edit</a>
                                        <a href="<?= ADMINURL ?>/cities/delete/<?= $city->id ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this city?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/layouts/footer.php'; ?> 