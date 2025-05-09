<?php require_once 'App/Views/layouts/admin.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">Countries</h5>
                    <a href="<?= ADMINURL ?>/countries/create" class="btn btn-primary float-end">Create Country</a>

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
                                <th scope="col">Continent</th>
                                <th scope="col">Population</th>
                                <th scope="col">Territory</th>
                                <th scope="col">Image</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($countries as $country): ?>
                                <tr>
                                    <th scope="row"><?= $country['id'] ?></th>
                                    <td><?= htmlspecialchars($country['name']) ?></td>
                                    <td><?= htmlspecialchars($country['continent']) ?></td>
                                    <td><?= htmlspecialchars($country['population']) ?></td>
                                    <td><?= htmlspecialchars($country['territory']) ?></td>
                                    <td>
                                        <img src="<?= ADMINURL ?>/countries-admins/images_countries/<?= $country['image'] ?>" 
                                             alt="<?= htmlspecialchars($country['name']) ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <a href="<?= ADMINURL ?>/countries/edit/<?= $country['id'] ?>" 
                                           class="btn btn-warning">Edit</a>
                                        <a href="<?= ADMINURL ?>/countries/delete/<?= $country['id'] ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this country?')">Delete</a>
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
