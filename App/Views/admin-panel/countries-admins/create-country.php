<?php require_once 'App/Views/layouts/admin.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">Create Country</h5>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= ADMINURL ?>/countries/create" enctype="multipart/form-data">
                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Country Name" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="continent" id="continent" class="form-control" placeholder="Continent" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="population" id="population" class="form-control" placeholder="Population" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="text" name="territory" id="territory" class="form-control" placeholder="Territory" required />
                        </div>

                        <div class="form-outline mb-4 mt-4">
                            <input type="file" name="image" id="image" class="form-control" required />
                        </div>

                        <div class="form-floating mb-4">
                            <textarea name="description" class="form-control" placeholder="Description" id="description" style="height: 100px" required></textarea>
                            <label for="description">Description</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create Country</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'App/Views/layouts/footer.php'; ?>      
